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
            'intro' => 'ques.data.p30016.intro',
            'head' => 'ques.data.p30016.head',
            'body' => 'ques.data.p30016.body',
            'footer' => 'ques.data.p30016.footer'
        ),
        'endView' => 'ques.data.p30016.end',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'department_name' => 'required',
            'set_degree' => 'required',
            'stdidnumber_last5' => 'required|alpha_num'
        ),
        'input_rull_message' => array(
            'department_name.required'  =>'就讀系所必填',
            'set_degree' => '學制必填',
            'stdidnumber_last5.required' =>'身分證字號末五碼必填',
            'stdidnumber_last5.alpha_num' =>'身分證字號末五碼格式錯誤',
        ),
        'checker' => function(&$validator, $controller) {

            $department_name = Input::get('department_name');
            $set_degree = Input::get('set_degree');
            $stdidnumber_last5 = strtoupper(Input::get('stdidnumber_last5'));

            $user_table = DB::table('rows.dbo.row_20170518_150111_rkm25')->where('C3269', 102)->where('C3270', $department_name)->where('C3271', $set_degree)->where('C3274', $stdidnumber_last5)->select('id');

            if ($user_table->exists()) {
                $user = $user_table->first();

                if (!DB::table('tiped_105_0016.dbo.tiped_105_0016_p3_network')->where('newcid', $user->id)->exists()) {
                    $commend = DB::table('tiped_105_0016.dbo.tiped_105_0016_p3_network')->where('id', Input::get('recommend'))->select('newcid')->first();
                    $newcid_commend = isset($commend) ? $commend->newcid : 0;
                    DB::table('tiped_105_0016.dbo.tiped_105_0016_p3_network')->insert([
                        'newcid' => $user->id,
                        'newcid_commend' => $newcid_commend,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString()
                    ]);
                }
                Ques\Answerer::login('p30016', $user->id);
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
            case 'departments':
                $departments = DB::table('rows.dbo.row_20170518_150111_rkm25')->where('C3269', 102)->groupBy('C3270')->select('C3270 AS department_name')->get();

                return ['departments' =>  $departments];
                break;

            case 'degrees':
                $degrees = DB::table('rows.dbo.row_20170518_150111_rkm25')->where('C3269', 102)->where('C3270',Input::get('department_name'))->groupBy('C3271')->select('C3271 AS degree')->get();

                return ['degrees' =>  $degrees];
                break;
        }

    }
);