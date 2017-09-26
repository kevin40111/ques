<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1062_ntcse_tea',
    'login_customize' => 1,
 	'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntcse_tea.intro',
			'head' => 'ques.data.ntcse_tea.head',
			'body' => 'ques.data.ntcse_tea.body',
			'footer' => 'ques.data.ntcse_tea.footer'
		),
		'endView' => 'ques.data.ntcse_tea.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntcse106_2.dbo.ntcse106tea_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id')->first();

                Ques\Answerer::login('ntcse_tea', $user->newcid);

                if($user->sch_id=='014795'){
					// 同榮國小只填校長向度
                	
					$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13,14,15,16));
					DB::table('ntcse106_2.dbo.ntcse106tea_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '100'));
					
				}
				else
				{
					//以下其勳加入
					/*
					1	3,4,6,7,8,9,10,11,12,13,15,16
					2	2,3,4,5,6,7,12,13,14,15,16
					3	2,3,5,8,9,10,11,12,13,14,15
					4	2,3,4,5,6,7,8,9,10,11,14,16
					*/
					switch($user->ques){
					case '1':
						if (substr($user->sch_id,2,1)=='1'){
							//私立
							$controller->skip_page(array(4,6,7,8,9,10,11,12,13,15,16));
						}else{
							//公立
							$controller->skip_page(array(3,4,6,7,8,9,10,11,12,13,15,16));
						}
						break;
					case '2':
						$controller->skip_page(array(2,3,4,5,6,7,12,13,14,15,16));
						break;
					case '3':
						$controller->skip_page(array(2,3,5,8,9,10,11,12,13,14,15));
						break;
					case '4':
						$controller->skip_page(array(2,3,4,5,6,7,8,9,10,11,14,16));
						break;
					default:
						break;
					}
					//以上其勳加入
				}



			}else{
				$validator->getMessageBag()->add('identity_id','帳號錯誤');
			}

		}
	),
	//存檔後執行
	'update' => function($page,$controller,$insert){
		if( $page=='1' ){
			if( Input::get('p1q9c1','') =='' && Input::get('p1q9c2','') =='' && Input::get('p1q9c3') =='1' ){
				//未教國小 且 未教國中 且 有教高中 則結束問卷
				$controller->skip_page(array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17));
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