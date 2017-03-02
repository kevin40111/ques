<?php
return array(
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/u0016ma',
    'skip' => false,

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.u0016ma.intro',
            'head' => 'ques.data.u0016ma.head',
            'body' => 'ques.data.u0016ma.body',
            'footer' => 'ques.data.u0016ma.footer'
        ),
        'endView' => 'ques.data.u0016ma.end',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'stdnumber' => 'required|alpha_num|size:8',
            'stdidnumber_last5' => 'required|alpha_num|size:5'
        ),
        'input_rull_message' => array(
            'stdnumber.required' =>'學號必填',
            'stdnumber.alpha_num' =>'學號格式錯誤',
            'stdnumber.size' =>'學號必需是8個字',
            'stdidnumber_last5.required' =>'身分證字號末五碼必填',
            'stdidnumber_last5.alpha_num' =>'身分證字號末五碼格式錯誤',
            'stdidnumber_last5.size' =>'身分證字號末五碼必需是5個字',
        ),
        'checker' => function(&$validator, $controller){

            $stdnumber = strtoupper(Input::get('stdnumber'));
            $stdidnumber_last5 = strtoupper(Input::get('stdidnumber_last5'));

            $user_table = DB::table('rows.dbo.row_20160128_155439_s6wq7')->whereIn('C549', ['碩士班', '碩士在職專班'])->where('C547', $stdnumber)->where('C550', $stdidnumber_last5);

            if ($user_table->exists()) {
                Ques\Answerer::login('u0016ma', $user_table->first()->id);
            }
            else
            {
                $validator->getMessageBag()->add('identity_id','您不是調查對象');
            }

        }
    ),

    'afterUpdate' => function($page, $controller) {

    },

    'blade' => function($page, &$init) {

    },

    'hide' => function($page) {

    },

    'publicData' => function($data) {

        switch($data){

        }

    }
);