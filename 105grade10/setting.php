<?php
return array(
	
	
	'debug' => true,
    'forceClose' => 0,
	'buildQuestion' => 'v10',
	'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',    	
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/105grade10',
    
	'auth' => array(
		'loginView' => array(
			'head' => 'ques.data.105grade10.head',
			'body' => 'ques.data.105grade10.body',
			'footer' => 'ques.data.105grade10.footer'
		),
		'endView' => 'ques.data.105grade10.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(	
			'identity_id' => 'required|alpha_num|size:10'				
		),
		'input_rull_message' => array(
			'identity_id.required' =>'身分證字號必填',
			'identity_id.alpha_num' =>'身分證字號格式錯誤',
			'identity_id.size' =>'身分證字號必需是10個字'	
		),
		'checker' => function(&$validator,$controller){		
			$checkid = check_id_number(Input::get('identity_id'));
			if($checkid != true)
			{	
				$validator->getMessageBag()->add('identity_id','身分證字號錯誤');
			}
			else
			{   $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = createnewcid($identity_id);
                if (!DB::table('use_105.dbo.seniorOne105_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('use_105.dbo.seniorOne105_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                }  
				Answerer::login('105grade10', $pcreate_newcid);
			}
		}
	),
            
	'update' => function($page, $controller){
		if ($page=='3') {
			$birth_year = Input::get('p3s18') + 1911;
			$birth_month = Input::get('p3s17');

			$birth = Carbon\Carbon::createFromDate($birth_year, $birth_month, 1);

			$months_75 = $birth->diffInMonths(Carbon\Carbon::createFromDate(1986, 8, 1), false);
			$months_85 = $birth->diffInMonths(Carbon\Carbon::createFromDate(1996, 8, 1), false);

			if ($months_75 > 0) {
				$controller->skip_page(array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ));
			} else if ($months_75 <= 0 && $months_85 > 0) {
				$controller->skip_page(array(4, 5, 6, 7, 8, 9, 10, 11, 12, 15));
			}
		}
	},
	'blade' => function($page, &$init){	
		if( is_null(Answerer::newcid()) )
			return false;
	},
            
	'hide' => function($page){
		if( is_null(Answerer::newcid()) )
			return false;

		if( $page == '18' ) {
			$page15 = DB::table('use_105.dbo.seniorOne105_page15')->where('newcid', Answerer::newcid())->select('p15q1')->first();
			if ($page15->p15q1 == '8') {
				return ['QID_bdd8jhpz','QID_i7nqxu3q','QID_iwufbj1m'];
			}
		}
        
		if( $page == '20' ) {
			$page13 = DB::table('use_105.dbo.seniorOne105_page13')->where('newcid', Answerer::newcid())->select('p13q1')->first();
			if ($page13->p13q1 != '2')
				return ['QID_lbbrg8za'];
		}	
	},
	
	'publicData' => function($data){
        
        switch($data){
            case 'school':
                
                $citycode_map = array(
                    '63' => array('63', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42'),
                    '66' => array('66', '06', '19'),
                    '67' => array('67', '11', '21'),
                    '64' => array('64', '12', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61'),
					'68' => array('68','03')
                );
                
                $category_map = array('1'=>array('0', '1', '2'), '2'=>array('3', 'F'), '3'=>array('4'), '4'=>array('B', 'C'));
                
                $citycode = Input::get('citycode');
                $category = Input::get('category');

                $schools = DB::table('plat_public.dbo.secondary_school')
                        ->where('year', '105')
                        ->whereIn('citycode', isset($citycode_map[$citycode]) ? $citycode_map[$citycode] : array($citycode) )
                        ->whereIn('category', $category_map[$category])
                        ->orderBy('name')
                        ->lists('name', 'id');
                
                return Response::json($schools);
               
			case 'city':
                
                $citys = DB::table('plat_public.dbo.lists')->where('type', 'city')->orderBy('sort')->select('name', 'code')->get();
                return Response::json($citys);
                
            case 'area':

                $areas = DB::table('plat_public.dbo.list_area')->where('city', Input::get('citycode', ''))->lists('cname', 'area');
                return Response::json($areas);  
			   
            default :
            break;
        }

	}
);