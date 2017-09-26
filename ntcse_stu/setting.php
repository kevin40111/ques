<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1062_ntcse_stu',//這裡有改
    'login_customize' => 1,
    'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntcse_stu.intro',
			'head' => 'ques.data.ntcse_stu.head',
			'body' => 'ques.data.ntcse_stu.body',
			'footer' => 'ques.data.ntcse_stu.footer'
		),
		'endView' => 'ques.data.ntcse_stu.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntcse106_2.dbo.ntcse106stu_pstat')->where('newcid',Input::get('identity_id'));//這裡有改
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id')->first();

                Ques\Answerer::login('ntcse_stu', $user->newcid);


				if($user->sch_id=='014795'){
					// 同榮國小只填校長向度
					$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13,15));
					DB::table('ntcse106_2.dbo.ntcse106stu_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '100'));
				
				}
				else{
					/*
					1A	2,3,5,7,8,9,11,12,15
					1B	2,3,4,7,8,9,11,12,15
					2	4,5,6,8,9,10,11,12,13,15
					3	2,3,4,5,6,7,8,10,11,13,15
					4	2,3,4,5,6,7,9,10,12,13,15
					*/
					//以下其勳加入
					switch($user->ques){
					case '1A'://elementary school
						$controller->skip_page(array(2,3,5,7,8,9,11,12,15));
						break;
					case '1B'://junior high school
						$controller->skip_page(array(2,3,4,7,8,9,11,12,15));
						break;
					case '2':
						$controller->skip_page(array(4,5,6,8,9,10,11,12,13,15));
						break;
					case '3':
						$controller->skip_page(array(2,3,4,5,6,7,8,10,11,13,15));
						break;
					case '4':
						$controller->skip_page(array(2,3,4,5,6,7,9,10,12,13,15));
						break;
					default:
						break;
					}
					//以上其勳加入
				}



			}else{
				$validator->getMessageBag()->add('identity_id','身分證字號錯誤');
			}
		}
	),

	//存檔後執行
	'update' => function($page,$controller,$insert){

	},

	'publicData' => function($data){
		switch($data){
			case 'area':
			break;
		}
	}


);