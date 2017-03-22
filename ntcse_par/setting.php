<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1061_ntcse_par',//這裡有改
    'login_customize' => 1,
 	'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntcse_par.intro',
			'head' => 'ques.data.ntcse_par.head',
			'body' => 'ques.data.ntcse_par.body',
			'footer' => 'ques.data.ntcse_par.footer'
		),
		'endView' => 'ques.data.ntcse_par.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntcse106_1.dbo.ntcse106par_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id','grade')->first();

                Ques\Answerer::login('ntcse_par', $user->newcid);

				//Session::put('ques', $user->ques);
				//Session::put('grade', $user->grade);

			}else{
				$validator->getMessageBag()->add('identity_id','身分證字號錯誤');
			}
		}
	),

	//存檔後執行
	'update' => function($page,$controller,$insert){
		if( $page=='2' ){
			$user_table = DB::table('ntcse106_1.dbo.ntcse106par_pstat')->where('newcid', Ques\Answerer::newcid());
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id','grade')->first();
				//判斷填答答案決定跳頁
				/*
				1	4,5,6,7,8,9,10,11,12,13,15,16
				2	3,4,6,7,8,9,10,11,12,13,15,16
				3A	3,4,5,8,9,10,11,12,13,15,16,17
				3B	3,4,5,7,9,10,11,12,13,15,16,17
				4	3,4,5,6,7,8,9,11,12,13,14,15,16
				5	3,4,5,6,7,8,9,10,13,14,15,16,17
				6	3,4,5,6,7,8,9,10,11,12,14,17

				*/
				if($user->sch_id=='014645'){
					/*
					if(Input::get('p2q3sc1','') =='3' || Input::get('p2q3sc1','') =='4'){
						$controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,14,15,16,17));
						DB::table('ntcse105par_pstat')
						->where('newcid', $user->newcid)
						->update(array('ques' => '100'));
					}else{
						$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,17));
						DB::table('ntcse105par_pstat')
						->where('newcid', $user->newcid)
						->update(array('ques' => '99'));
					}
					*/
				}
				elseif ((Input::get('p2q3sc1','') =='3' || Input::get('p2q3sc1','') =='4') && (Input::get('p2q3sc2','') =='3' || Input::get('p2q3sc2','') =='4')) {
					//if((Input::get('p2q3sc2','') =='3' || Input::get('p2q3sc2','') =='4')){
						//當第2頁的校長跟行政都填3.4分時，則隨機分配
					$counts = DB::table('ntcse106_1.dbo.ntcse106par_pstat')->select(DB::raw('COUNT(*) as cc'))->where('sch_id',  $user->sch_id)->whereIn('ques',array('1', '2'))->first();
					if ($counts->cc <= 6){
						$isShuntN = ($counts->cc % 2) + 1;
					}else{
						$types = DB::table('ntcse106_1.dbo.ntcse106par_pstat')
						->select(DB::raw('ques'))
						->where('sch_id',  $user->sch_id)
						->whereIn('ques',array('1', '2'))
						->orderBy(DB::raw('COUNT(ques),ques'))
						->groupBy(DB::raw('ques'))
						->first();
						$isShuntN = $types->ques;
					}
					switch($isShuntN){
						case '1':
							$controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,15,16));
							break;
						case '2':
							$controller->skip_page(array(3,4,6,7,8,9,10,11,12,13,15,16));
							break;
					}
					//更新ques值為 $isShuntN
					DB::table('ntcse106_1.dbo.ntcse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => $isShuntN));
					//}
				}
				elseif((Input::get('p2q3sc1','') =='3' || Input::get('p2q3sc1','') =='4') && (Input::get('p2q3sc2','') =='1' || Input::get('p2q3sc2','') =='2'))
				{	//ntcse105par_P2_q3sc1 填 3 或 4 者，優先填 1 卷
					//if(Input::get('p2q3sc2','') =='1' || Input::get('p2q3sc2','') =='2'){
						if (substr($user->sch_id,2,1)=='1'){
						//私立
						$controller->skip_page(array(5,6,7,8,9,10,11,12,13,15,16));//這裡有改
					}else{
						//公立
						$controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,15,16));//這裡有改
					}
					//更新ques值為 1
					DB::table('ntcse106_1.dbo.ntcse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '1'));
					//}
				}
				elseif((Input::get('p2q3sc2','') =='3' || Input::get('p2q3sc2','') =='4') && (Input::get('p2q3sc1','') =='1' || Input::get('p2q3sc1','') =='2'))
				{	//ntcse105par_P2_q3sc1 填 3 或 4 者，優先填 2 卷
					//if(Input::get('p2q3sc1','') =='1' || Input::get('p2q3sc1','') =='2'){
						if(substr($user->sch_id,2,1)=='1'){
						//私立
						$controller->skip_page(array(3,6,7,8,9,10,11,12,13,15,16));
					}else{
						//公立
						$controller->skip_page(array(3,4,6,7,8,9,10,11,12,13,15,16));
					}
					
					//更新ques值為 2
					DB::table('ntcse106_1.dbo.ntcse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '2'));
					//}
				}
				else{
					//其他四卷平均分配
					$counts = DB::table('ntcse106_1.dbo.ntcse106par_pstat')->select(DB::raw('COUNT(*) as cc'))->where('sch_id',  $user->sch_id)->whereIn('ques',array('3A', '3B', '4', '5', '6'))->first();
					if ($counts->cc <= 12){
						$isShuntN = ($counts->cc % 4) + 3;
					}else{
						$types = DB::table('ntcse106_1.dbo.ntcse106par_pstat')
						->select(DB::raw('case ques when \'3A\' then \'3\' when \'3B\' then \'3\' else ques end as ques'))
						->where('sch_id',  $user->sch_id)
						->whereIn('ques',array('3A', '3B', '4', '5', '6'))
						->orderBy(DB::raw('COUNT(case ques when \'3A\' then \'3\' when \'3B\' then \'3\' else ques end),ques'))
						->groupBy(DB::raw('case ques when \'3A\' then \'3\' when \'3B\' then \'3\' else ques end'))
						->first();
						$isShuntN = $types->ques;
					}
					switch($isShuntN){
						case '3':
							//第三份問卷還分成 A B 卷
							if ($user->grade == '7' || $user->grade == '8' || $user->grade == '9'){
								$isShuntN='3B';
								$controller->skip_page(array(3,4,5,7,9,10,11,12,13,15,16,17));
							}else{
								$isShuntN='3A';
								$controller->skip_page(array(3,4,5,8,9,10,11,12,13,15,16,17));
							}
							break;
						case '4':
							$controller->skip_page(array(3,4,5,6,7,8,9,11,12,13,14,15,16));
							break;
						case '5':
							$controller->skip_page(array(3,4,5,6,7,8,9,10,13,14,15,16,17));
							break;
						case '6':
							$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,14,17));
							break;
					}

					//更新ques值為 $isShuntN
					DB::table('ntcse106_1.dbo.ntcse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => $isShuntN));
				}
			}
		}
//有QQ
		if( $page=='6' ){
			if( Input::get('p6q1','') =='1' || Input::get('p6q1','') =='2' && Input::get('p6q2') =='1' || Input::get('p6q2') =='2' ){

				$controller->skip_page(array(7,8));
			}
		}
	},

	'hide' => function($page){
		if( !Ques\Answerer::newcid() )
			return false;

		if( $page=='13' ){
			$hide_array = array();
			$pageanswer = DB::table('ntcse106_1.dbo.ntcse106par_pstat')->where('newcid', Ques\Answerer::newcid())->select('grade')->first();
			if( $pageanswer->grade < '7' ){//這裡有改
				array_push($hide_array,'QID_csyop0h1');
				return $hide_array;
			}else{
				return false;
			}
		}

	},

	'publicData' => function($data){
		switch($data){
			case 'area':
			break;
		}
	}


);