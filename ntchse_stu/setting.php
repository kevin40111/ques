<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1061_ntchse_stu',
    'login_customize' => 1,
    'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntchse_stu.intro',
			'head' => 'ques.data.ntchse_stu.head',
			'body' => 'ques.data.ntchse_stu.body',
			'footer' => 'ques.data.ntchse_stu.footer'
		),
		'endView' => 'ques.data.ntchse_stu.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntchse106_1.dbo.ntchse106stu_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id','pro')->first();

                Ques\Answerer::login('ntchse_stu', $user->newcid);

                /*
				if($user->sch_id=='014645'){
					$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13));
					DB::table('ntchse105par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '99'));
				}
				*/
				//else{
					/*
					1	4,5,6,7,8,9,10,11,12,13,15,16,17,19
					2A	3,6,8,9,10,11,12,13,14,15,17,18,19
					2B	3,5,8,9,10,11,12,13,14,15,17,18,19
					3A	3,4,5,6,7,10,11,12,14,16,17,18,19
					3B	3,4,5,6,7,9,11,12,14,16,17,18,19
					3C	3,4,5,6,7,9,10,12,14,16,17,18,19
					3D	3,4,5,6,7,9,10,11,14,16,17,18,19
					D	3,4,5,6,7,8,9,10,11,12,13,14,15,16,18
					*/

					if(substr($user->pro,0,1)=='0' || substr($user->pro,0,1)=='1'){
	                	//國高中跳過群科頁
						$controller->skip_page(array(20));
	                }

					switch($user->ques){
					case '1':
						$controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,15,16,17,19));
						break;
					case '2A':
						$controller->skip_page(array(3,6,8,9,10,11,12,13,14,15,17,18,19));
						break;
					case '2B':
						$controller->skip_page(array(3,5,8,9,10,11,12,13,14,15,17,18,19));
						break;
					case '3A':
						//下次問卷加入判斷，遇到先填4卷
						$controller->skip_page(array(3,4,5,6,7,10,11,12,14,16,17,18,19));
						break;
					case '3B':
						$controller->skip_page(array(3,4,5,6,7,9,11,12,14,16,17,18,19));
						break;
					case '3C':
						$controller->skip_page(array(3,4,5,6,7,9,10,14,16,17,18,19));
						break;
					case '4':
						$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,18));
						break;
					default:
						break;
					}
					//以上其勳加入
				//}



			}else{
				$validator->getMessageBag()->add('identity_id','身分證字號錯誤');
			}
		}
	),

	//存檔後執行
	'update' => function($page,$controller,$insert){
		if($page == '2'){
			if( Input::get('p2q2','') =='6' || Input::get('p2q2','') =='7' || Input::get('p2q2','') =='8'){
				if (Input::get('p2q3','') =='1' || Input::get('p2q3','') =='3' || Input::get('p2q3','') =='5'){
					$controller->skip_page(array(12));
				}else{
					$controller->skip_page(array(11));
				}			
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