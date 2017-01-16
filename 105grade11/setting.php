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

    },

    'blade' => function($page, &$init) {

    },

    'hide' => function($page) {

    },

    'publicData' => function($data) {
        switch ($data) {
            case 'citys':
                $citys = DB::table('plat_public.dbo.lists')->select('code', 'name')->orderBy('sort')->get();

                return ['citys' => $citys];
                break;
        }
    }
);