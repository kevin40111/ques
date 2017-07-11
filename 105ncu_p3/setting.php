<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => false,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/105ncu_p3',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.105ncu_p3.intro',
            'head' => 'ques.data.105ncu_p3.head',
            'body' => 'ques.data.105ncu_p3.body',
            'footer' => 'ques.data.105ncu_p3.footer'
        ),
        'endView' => 'ques.data.105ncu_p3.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'dep_name' => 'required',
            'stu_id' => 'required|alpha_num|size:10'
        ),
        'input_rull_message' => array(
            'stu_id.required' =>'身分證字號碼必填',
            'stu_id.alpha_num' =>'身分證字號格式錯誤',
            'stu_id.size' =>'身分證字號末五碼必需是10個字',
        ),
        'checker' => function(&$validator,$controller){
            $dep_name = Input::get('dep_name');
            $stdidnumber = strtoupper(Input::get('stu_id'));

            $user_table = DB::table('rows.dbo.row_20170626_145821_l8eby')->where('C3384', $dep_name)->where('C3387', $stdidnumber)->select('id');

            if ($user_table->exists()) {
                $user = $user_table->first();
                Ques\Answerer::login('105ncu_p3', $user->id);
                if (!DB::table('ncu.dbo.ncu_102_p3_network')->where('newcid', $user->id)->exists()) {
                    $commend = DB::table('ncu.dbo.ncu_102_p3_network')->where('id', Input::get('recommend'))->select('newcid')->first();
                    $newcid_commend = isset($commend) ? $commend->newcid : 0;
                    DB::table('ncu.dbo.ncu_102_p3_network')->insert([
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

    'update' => function($page, $controller){
        if(Input::get('p2q1','') =='3' || Input::get('p2q1','') =='4'){
            $controller->skip_page(array(3,4,5));
        }

    },
    'blade' => function($page, &$init){

    },

    'hide' => function($page){
        if( $page == '6' ) {
            $page1 = DB::table('ncu.dbo.ncu_102_p3_page2')->where('newcid', Ques\Answerer::newcid())->select('p2q1')->first();
            if ($page1->p2q1 == '3' || $page1->p2q1 == '4') {
                return ['QID_hsyhb3a7','QID_426sejby'];
            }
        }
    },

    'publicData' => function($data){
        switch ($data) {
            case 'departments':
                $departments = DB::table('rows.dbo.row_20170626_145821_l8eby')->groupBy('C3384')->orderByRaw('C3384 COLLATE Chinese_PRC_Stroke_ci_as')->select('C3384 AS department_name')->get();

                return ['departments' =>  $departments];
                break;
        }
    }
);