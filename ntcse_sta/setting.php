<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1062_ntcse_sta',
    'login_customize' => 1,
 	'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntcse_sta.intro',
			'head' => 'ques.data.ntcse_sta.head',
			'body' => 'ques.data.ntcse_sta.body',
			'footer' => 'ques.data.ntcse_sta.footer'
		),
		'endView' => 'ques.data.ntcse_sta.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntcse106_2.dbo.ntcse106sta_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id')->first();

                Ques\Answerer::login('ntcse_sta', $user->newcid);

                if($user->sch_id=='014795'){
                	// 同榮國小只填校長向度
					$controller->skip_page(array(3,4,5,6,7));
					DB::table('ntcse106_2.dbo.ntcse106sta_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '100'));
					
				}

				else{
					//以下其勳加入
					/*
					1	3,5,6
					2	2,3,4,7

					*/
					switch($user->ques){
					case '1':
						if (substr($user->sch_id,2,1)=='1'){
							//私立
							$controller->skip_page(array(5,6));
						}else{
							//公立
							$controller->skip_page(array(3,5,6));
						}
						break;
					case '2':
						$controller->skip_page(array(2,3,4,7));
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