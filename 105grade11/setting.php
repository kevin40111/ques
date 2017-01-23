<?php
return array(
    'logInput' => false,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/105grade11',
    'skip' => false,

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.105grade11.intro',
            'head' => 'ques.data.105grade11.head',
            'body' => 'ques.data.105grade11.body',
            'footer' => 'ques.data.105grade11.footer'
        ),
        'endView' => 'ques.data.105grade11.end',
        'primaryID' => 'newcid',
        'input_rull' => array(
			'identity_id' => 'required|alpha_num|size:10'
        ),
        'input_rull_message' => array(
			'identity_id.required' =>'身分證字號必填',
			'identity_id.alpha_num' =>'身分證字號格式錯誤',
			'identity_id.size' =>'身分證字號必需是10個字'
        ),
        'checker' => function(&$validator, $controller) {
			$checkid = check_id_number(Input::get('identity_id'));
			if ($checkid != true) {
				$validator->getMessageBag()->add('identity_id','身分證字號錯誤');
			} else {
                $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = createnewcid($identity_id);
                if (!DB::table('use_105.dbo.seniorTwo105_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('use_105.dbo.seniorTwo105_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                }
                Ques\Answerer::login($controller->root, $pcreate_newcid);
			}
        }
    ),

    'update' => function($page, $controller) {
        if ($page=='3') {
            $birth_year  = Input::get('p3q1') + 1911;
            $birth_month = Input::get('p3q2');

            $birth = Carbon\Carbon::createFromDate($birth_year, $birth_month, 1);

            $months_84 = $birth->diffInMonths(Carbon\Carbon::createFromDate(1995, 8, 1), false);

            if ($userinfo = DB::table('use_105.dbo.seniorTwo105_grade10')->where('newcid', Ques\Answerer::newcid())->select('newcid')->exists()) {
                if ($months_84 > 0) {
                    $pages = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24);
                } else {
                    $pages = array(21, 22, 23, 24, 25, 26);
                }
            } else {
                if ($months_84 > 0) {
                    $pages = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21);
                } else {
                    $pages = array(25, 26);
                }
            }
            $controller->skip_page($pages);
        }
    },

    'blade' => function($page, &$init) {

    },

    'hide' => function($page) {
        if (is_null(Ques\Answerer::newcid()))
            return false;

        if ($page == '14') {
            $hideContent = [];
            $page9 = DB::table('use_105.dbo.seniorTwo105_page9')->where('newcid', Ques\Answerer::newcid())->select('p9q2')->first();
            if ($page9) {
                $hideContent[] = $page9->p9q2 == '1' ? 'QID_wd38ojse' : 'QID_ciy7qos3';
            }
            return $hideContent;
        }
    },

    'publicData' => function($data) {

    }
);