<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1061_ntchse_tea',
    'login_customize' => 1,
    'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntchse_tea.intro',
			'head' => 'ques.data.ntchse_tea.head',
			'body' => 'ques.data.ntchse_tea.body',
			'footer' => 'ques.data.ntchse_tea.footer'
		),
		'endView' => 'ques.data.ntchse_tea.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntchse106_1.dbo.ntchse106tea_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id')->first();

                Ques\Answerer::login('ntchse_tea', $user->newcid);
                /*
                if($user->sch_id=='014645'){
					$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13,14,15,16));
					DB::table('ntchse105par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '99'));
				}
				*/
				//else
				//{
					//以下其勳加入
					/*
					1	4,5,7,8,9,10,11,12
					2	3,5,6,8,9,10,11,12
					3	3,4,6,7,8,9,10
					4	3,4,5,6,7,11,12
					*/

					//跳掉董事會
					if (substr($user->sch_id,2,1)!='1'){
					//公立
						$controller->skip_page(array(14));
					}

					switch($user->ques){
					case '1':
						$controller->skip_page(array(4,5,7,8,9,10,11,12));
						break;
					case '2':
						$controller->skip_page(array(3,5,6,8,9,10,11,12));
						break;
					case '3':
						$controller->skip_page(array(3,4,6,7,8,9,10));
						break;
					case '4':
						$controller->skip_page(array(3,4,5,6,7,11,12));
						break;
					default:
						//例外狀況填3卷
						$controller->skip_page(array(3,4,6,7,8,9,10));
						break;
					}
					//以上其勳加入
				//}



			}else{
				$validator->getMessageBag()->add('identity_id','帳號錯誤');
			}

		}
	),

	//存檔後執行
	'update' => function($page,$controller,$insert){

		if( $page=='2' ){
			if( Input::get('p2q6c4','0') ==''){
				//未教專業群科課程
				//跳掉專業群科
				$controller->skip_page(array(13));
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