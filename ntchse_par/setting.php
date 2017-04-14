<?php
return array(
	'logInput' => true,
	'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/1061_ntchse_par',
    'login_customize' => 1,
    'skip' => false,
	'auth' => array(
		'loginView' => array(
			'intro' => 'ques.data.ntchse_par.intro',
			'head' => 'ques.data.ntchse_par.head',
			'body' => 'ques.data.ntchse_par.body',
			'footer' => 'ques.data.ntchse_par.footer'
		),
		'endView' => 'ques.data.ntchse_par.end',
		'testID' => 'A228909170',
		'primaryID' => 'newcid',
		'input_rull' => array(
			'identity_id' => 'required|alpha_dash|size:36'
		),
		//登入時執行
		'checker' => function(&$validator,$controller){
			$user_table = DB::table('ntchse106_1.dbo.ntchse106par_pstat')->where('newcid',Input::get('identity_id'));
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id','grade','pro')->first();

                Ques\Answerer::login('ntchse_par', $user->newcid);

                if(substr($user->pro,0,1)=='0' || substr($user->pro,0,1)=='1'){
                	//國高中跳過群科頁
					$controller->skip_page(array(19));
                }

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

			$user_table = DB::table('ntchse106_1.dbo.ntchse106par_pstat')->where('newcid', Ques\Answerer::newcid());
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id','grade','pro')->first();
				/*
				國小 A
				國中 B
				高中 C
				職業類科 D
				*/
				if(Input::get('p2q4','') <= '6'){
					DB::table('ntchse106_1.dbo.ntchse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('grade' => 'A'));
				}
				if(Input::get('p2q4','') > '6' && Input::get('p2q4','') < '10'){
					DB::table('ntchse106_1.dbo.ntchse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('grade' => 'B'));
				}
				if(Input::get('p2q4','') > '9'){
					if(Input::get('p2q8','') == '1' || Input::get('p2q8','') == '3' || Input::get('p2q8','') == '5'){
						DB::table('ntchse106_1.dbo.ntchse106par_pstat')
						->where('newcid', $user->newcid)
						->update(array('grade' => 'C'));
					}else{
						DB::table('ntchse106_1.dbo.ntchse106par_pstat')
						->where('newcid', $user->newcid)
						->update(array('grade' => 'D'));
					}

				}
			}
		}
		if( $page=='3' ){
			$user_table = DB::table('ntchse106_1.dbo.ntchse106par_pstat')->where('newcid', Ques\Answerer::newcid());
			if( $user_table->exists() ){
				$user = $user_table->select('newcid','ques','sch_id','grade')->first();
				//判斷填答答案決定跳頁
				/*
				1	5,6,7,8,9,10,11,12,13,14,15,17
				2	4,6,7,8,9,10,11,12,13,14,15,17
				3A	4,5,9,10,11,13,14,15,16,17,18
				3B	4,5,8,10,11,13,14,15,16,17,18
				3C	4,5,8,9,11,13,14,15,16,17,18
				3D	4,5,8,9,10,13,14,15,16,17,18
				4	4,5,6,7,8,9,10,11,12,13,16,18
				5	4,5,7,8,9,10,11,12,15,16,17,18
				6A	4,5,6,9,10,11,13,14,16,17,18
				6B	4,5,6,8,10,11,13,14,16,17,18
				6C	4,5,6,8,9,11,13,14,16,17,18
				6D	4,5,6,8,9,10,13,14,16,17,18
				7	4,5,6,7,8,9,10,11,12,14,15,16,18


				*/
				/*
				$counts = DB::table('ntchse105par_pstat')->select(DB::raw('COUNT(*) as cc'))

				->where('sch_id',  $user->sch_id)->where('page', '>', 20)->whereIn('ques',array('36', '59'))->first();

				$isShuntN = ($counts->cc % 2);

				switch ($isShuntN) {
					case '0':
						$controller->skip_page(array(13,17));
						DB::table('ntchse105par_pstat')
						->where('newcid', $user->newcid)
						->update(array('ques' => '36'));
						break;
					case '1':
						$controller->skip_page(array(6,14));
						DB::table('ntchse105par_pstat')
						->where('newcid', $user->newcid)
						->update(array('ques' => '59'));
						break;

					default:
						# code...
						break;
				}
				*/
				/*
				if($user->sch_id=='999999'){
					if(Input::get('p3q3sc1','') =='3' || Input::get('p3q3sc1','') =='4'){
						$controller->skip_page(array());
						DB::table('ntchse105par_pstat')
						->where('newcid', $user->newcid)
						->update(array('ques' => '100'));
					}else{
						$controller->skip_page(array());
						DB::table('ntchse105par_pstat')
						->where('newcid', $user->newcid)
						->update(array('ques' => '99'));
					}
				}
				*/

				if (substr($user->sch_id,2,1)!='1'){
					//公立
					$controller->skip_page(array(20));
				}

				if(Input::get('p3q1','') =='1'){
					$controller->skip_page(array(16));
				}

				if ((Input::get('p3q3sc1','') =='3' || Input::get('p3q3sc1','') =='4') && (Input::get('p3q3sc1','') =='3' || Input::get('p3q3sc1','') =='4')) {
					//當第3頁的校長跟行政都填3.4分時，則隨機分配
					$counts = DB::table('ntchse106_1.dbo.ntchse106par_pstat')->select(DB::raw('COUNT(*) as cc'))->where('sch_id',  $user->sch_id)->whereIn('ques',array('1', '2'))->first();
					if ($counts->cc <= 6){
						$isShuntN = ($counts->cc % 2) + 1;
					}else{
						$types = DB::table('ntchse106_1.dbo.ntchse106par_pstat')
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
							$controller->skip_page(array(5,6,7,8,9,10,11,12,13,14,15,17));
							break;
						case '2':
							$controller->skip_page(array(4,6,7,8,9,10,11,12,13,14,15,17));//有修正群科20170413
							break;
					}
					//更新ques值為 $isShuntN
					DB::table('ntchse106_1.dbo.ntchse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => $isShuntN));
					//}
				}
				else if((Input::get('p3q3sc1','') =='3' || Input::get('p3q3sc1','') =='4')  && (Input::get('p3q3sc2','') =='1' || Input::get('p3q3sc2','') =='2'))
				{	//ntchse105par_P2_q3sc1 填 3 或 4 者，優先填 A 卷
					$controller->skip_page(array(5,6,7,8,9,10,11,12,13,14,15,17));
					//更新ques值為 1
					DB::table('ntchse106_1.dbo.ntchse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '1'));

				}
				elseif((Input::get('p3q3sc2','') =='3' || Input::get('p3q3sc2','') =='4') && (Input::get('p3q3sc1','') =='1' || Input::get('p3q3sc1','') =='2'))
				{	//ntchse105par_P2_q3sc1 填 3 或 4 者，優先填 B 卷
					$controller->skip_page(array(4,6,7,8,9,10,11,12,13,14,15,17));//有修正群科20170413
					//更新ques值為 2
					DB::table('ntchse106_1.dbo.ntchse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => '2'));

				}
				else{
					//其他四卷平均分配
					$counts = DB::table('ntchse106_1.dbo.ntchse106par_pstat')->select(DB::raw('COUNT(*) as cc'))->where('sch_id',  $user->sch_id)->whereIn('ques',array('3A', '3B', '3C', '3D', '4', '5', '6A', '6B', '6C', '6D', '7'))->first();
					if ($counts->cc <= 15){
						$isShuntN = ($counts->cc % 5) + 3;
					}else{
						$types = DB::table('ntchse106_1.dbo.ntchse106par_pstat')
						->select(DB::raw('case ques when \'3A\' then \'3\' when \'3B\' then \'3\' when \'3C\' then \'3\' when \'3D\' then \'3\' when \'6A\' then \'6\' when \'6B\' then \'6\' when \'6C\' then \'6\' when \'6D\' then \'6\' else ques end as ques'))
						->where('sch_id',  $user->sch_id)
						->whereIn('ques',array('3A', '3B', '3C', '3D', '4', '5', '6A', '6B', '6C', '6D', '7'))
						->orderBy(DB::raw('COUNT(case ques when \'3A\' then \'3\' when \'3B\' then \'3\' when \'3C\' then \'3\' when \'3D\' then \'3\' when \'6A\' then \'6\' when \'6B\' then \'6\' when \'6C\' then \'6\' when \'6D\' then \'6\' else ques end),ques'))
						->groupBy(DB::raw('case ques when \'3A\' then \'3\' when \'3B\' then \'3\' when \'3C\' then \'3\' when \'3D\' then \'3\' when \'6A\' then \'6\' when \'6B\' then \'6\' when \'6C\' then \'6\' when \'6D\' then \'6\' else ques end'))
						->first();
						$isShuntN = $types->ques;
					}



					switch($isShuntN){
						case '3':
							//第三份問卷還分成 A B C D 卷
							switch ($user->grade) {
								case 'A':
									$isShuntN='3A';
									$controller->skip_page(array(4,5,9,10,11,13,14,15,16,17,18));
									break;
								case 'B':
									$isShuntN='3B';
									$controller->skip_page(array(4,5,8,10,11,13,14,15,16,17,18));
									break;
								case 'C':
									$isShuntN='3C';
									$controller->skip_page(array(4,5,8,9,11,13,14,15,16,17,18));
									break;
								case 'D':
									$isShuntN='3D';
									$controller->skip_page(array(4,5,8,9,10,13,14,15,16,17,18));
									break;

								default:
									$isShuntN='4';
									$controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,16,18));
									break;
							}
							break;
						case '4':
							$controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,16,18));
							break;
						case '5':
							$controller->skip_page(array(4,5,7,8,9,10,11,12,15,16,17,18));
							break;
						case '6':
							//第六份問卷還分成 A B C D 卷
							switch ($user->grade) {
								case 'A':
									$isShuntN='6A';
									$controller->skip_page(array(4,5,6,9,10,11,13,14,16,17,18));
									break;
								case 'B':
									$isShuntN='6B';
									$controller->skip_page(array(4,5,6,8,10,11,13,14,16,17,18));
									break;
								case 'C':
									$isShuntN='6C';
									$controller->skip_page(array(4,5,6,8,9,11,13,14,16,17,18));
									break;
								case 'D':
									$isShuntN='6D';
									$controller->skip_page(array(4,5,6,8,9,10,13,14,16,17,18));
									break;

								default:
									$isShuntN='7';
									$controller->skip_page(array(4,5,6,7,8,9,10,11,12,14,15,16,18));
									break;
							}
							break;
						case '7':
							$controller->skip_page(array(4,5,6,7,8,9,10,11,12,14,15,16,18));
							break;
					}

					//更新ques值為 $isShuntN
					DB::table('ntchse106_1.dbo.ntchse106par_pstat')
					->where('newcid', $user->newcid)
					->update(array('ques' => $isShuntN));
				}

			}
		}
		if( $page=='7' ){
			if( Input::get('p7q4','') =='1' || Input::get('p7q4','') =='2'){
				$controller->skip_page(array(8,9,10,11));
			}
		}
	},

	'hide' => function($page){
		if( !Ques\Answerer::newcid() )
			return false;
		/*
		if( $page=='13' ){
			$hide_array = array();
			$pageanswer = DB::table('ntchse105par_pstat')->where('newcid', Answerer::newcid())->select('grade')->first();
			if( $pageanswer->grade < '6' ){
				array_push($hide_array,'QID_csyop0h1');
				return $hide_array;
			}else{
				return false;
			}
		}
		*/
	},

	'publicData' => function($data){
		switch($data){
			case 'area':
			break;
		}
	}


);