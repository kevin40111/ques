<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/105parent11',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.105parent11.head',
            'body' => 'ques.data.105parent11.body',
            'footer' => 'ques.data.105parent11.footer'
        ),
        'endView' => 'ques.data.105parent11.end',
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
            {
                $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = createnewcid($identity_id);

                $user_table = DB::table('rows.dbo.row_20160817_140417_ctuql')->where('C1185', $identity_id)->select('id');

                if ($user_table->exists()) {
                    if (!DB::table('use_105.dbo.parentTwo105_id')->where('newcid', $pcreate_newcid)->exists()) {
                        DB::table('use_105.dbo.parentTwo105_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                    }
                    Answerer::login('105parent11', $pcreate_newcid);
                }
                else
                {
                    $validator->getMessageBag()->add('identity_id','您不是調查對象');
                }
            }
        }
    ),

    'update' => function($page, $controller){

    },
    'blade' => function($page, &$init){
        if( is_null(Answerer::newcid()) )
            return false;
        if ($page=='3') {
            $id = DB::table('use_105.dbo.parentTwo105_id')
                ->where('newcid', Answerer::newcid())
                ->select('stdidnumber')
                ->first();
            $name = '';
            $school = '';
            $user = DB::table('rows.dbo.row_20160817_140417_ctuql')
                ->where('C1185', $id->stdidnumber)
                ->select('C1186','C1187')
                ->first();
            if (!empty($user->C1186)) {
                $school = DB::table('plat_public.dbo.secondary_school')
                        ->where('year', '105')
                        ->where('id', $user->C1186)
                        ->select('name')
                        ->first();
            }
            if (!empty($user->C1187)) {
                $name = $user->C1187;
            }
            return array(
                'name' => $name,
                'school' => $school->name,
            );
        }
    },

    'hide' => function($page){
        if( is_null(Answerer::newcid()) )
            return false;

        if( $page == '12' ) {
            $page3 = DB::table('use_105.dbo.parentTwo105_page3')
                    ->where('newcid', Answerer::newcid())
                    ->select('p3q2')
                    ->first();
            if ($page3->p3q2 != '1') {
                return ['QID_vtwrhani','QID_wpodz9qr'];
            }
        }
    },

    'publicData' => function($data){
        switch($data){
            case 'school':
                $schoolId =
                $school = DB::table('plat_public.dbo.secondary_school')
                        ->where('year', '105')
                        ->whereIn('citycode', isset($citycode_map[$citycode]) ? $citycode_map[$citycode] : array($citycode) )
                        ->whereIn('category', $category_map[$category])
                        ->orderBy('name')
                        ->lists('name', 'id');

                return Response::json($school);

            case 'city':

                $citys = DB::table('plat_public.dbo.lists')
                        ->where('type', 'city')
                        ->orderBy('sort')
                        ->select('name', 'code')
                        ->get();
                return Response::json($citys);

            case 'area':

                $areas = DB::table('plat_public.dbo.list_area')
                        ->where('city', Input::get('citycode', ''))
                        ->lists('cname', 'area');
                return Response::json($areas);

            case 'care':

                $care = DB::table('use_105.dbo.parentTwo105_page3')
                        ->where('newcid', Answerer::newcid())
                        ->select('p3q2')
                        ->first();
                return Response::json($care);

            default :
            break;
        }
    }
);