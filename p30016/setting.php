<?php
return array(

    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/p30016',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.p30016.head',
            'body' => 'ques.data.p30016.body',
            'footer' => 'ques.data.p30016.footer'
        ),
        'endView' => 'ques.data.p30016.end',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'udepname' => 'required',
            'stdidnumber_last5' => 'required|alpha_num|size:5'
        ),
        'input_rull_message' => array(
            'udepname.required'  =>'就讀系所必填',
            'stdidnumber_last5.required' =>'身分證字號末五碼必填',
            'stdidnumber_last5.alpha_num' =>'身分證字號末五碼格式錯誤',
            'stdidnumber_last5.size' =>'身分證字號末五碼必需是5個字',
        ),
        'checker' => function(&$validator, $controller) {

            $udepname = Input::get('udepname');
            $stdidnumber_last5 = strtoupper(Input::get('stdidnumber_last5'));

            $user_table = DB::table('rows.dbo.row_20160429_154625_zbd7l')->where('C1088', $udepname)->where('C1090', $stdidnumber_last5)->select('id');

            if ($user_table->exists()) {
                $user = $user_table->first();
                Answerer::login('p30016', $user->id);
                if (!DB::table('tiped_104_0016.dbo.tiped_104_0016_p3_network')->where('newcid', $user->id)->exists()) {
                    $commend = DB::table('tiped_104_0016.dbo.tiped_104_0016_p3_network')->where('id', Input::get('id'))->select('newcid')->first();
                    $newcid_commend = isset($commend) ? $commend->newcid : 0;
                    DB::table('tiped_104_0016.dbo.tiped_104_0016_p3_network')->insert([
                        'newcid' => $user->id,
                        'newcid_commend' => $newcid_commend,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString()
                    ]);
                }
            }
            else
            {
                $validator->getMessageBag()->add('identity_id','您不是調查對象');
            }

        }
    ),

    'update' => function($page, $controller) {
        if ($page=='3') {
            $pages = array(4, 5, 6, 7);
            if (in_array(Input::get('p3q1'),[3,4,5,7,8,9,10])) {
                $controller->skip_page($pages);
            }
        }
    },

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