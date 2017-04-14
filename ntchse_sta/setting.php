<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1061_ntchse_sta',
    'login_customize' => 1,
    'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntchse_sta.intro',
			'head' => 'ques.data.ntchse_sta.head',
			'body' => 'ques.data.ntchse_sta.body',
			'footer' => 'ques.data.ntchse_sta.footer'
		),
		'endView' => 'ques.data.ntchse_sta.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntchse106_1.dbo.ntchse106sta_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id')->first();

                Ques\Answerer::login('ntchse_sta', $user->newcid);
                /*
                if($user->sch_id=='014645'){
					$controller->skip_page(array(3,4,5,6,7));
					DB::table('ntchse105par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '99'));
				}
				*/
				//else{
					//以下其勳加入
					/*
					1	5,6
					2	3,4,7
					*/
					//跳掉專業群科
					$controller->skip_page(array(8));
					//跳掉董事會
					if (substr($user->sch_id,2,1)!='1'){
					//公立
						$controller->skip_page(array(9));
					}

					switch($user->ques){
					case '1':
						$controller->skip_page(array(5,6));
						break;
					case '2':
						$controller->skip_page(array(3,4,7));
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

	},

	'publicData' => function($data){
		switch($data){
			case 'area':
			break;
		}
	}


);