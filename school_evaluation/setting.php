<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/school_evaluation',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.school_evaluation.intro',
            'head' => 'ques.data.school_evaluation.head',
            'body' => 'ques.data.school_evaluation.body',
            'footer' => 'ques.data.school_evaluation.footer'
        ),
        'endView' => 'ques.data.school_evaluation.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'identity_id' => 'required'
        ),
        'input_rull_message' => array(
            'identity_id.required' =>'登入帳號必填'
        ),
        'checker' => function(&$validator,$controller){            
            $identity_id = strtoupper(Input::get('identity_id'));
            //$pcreate_newcid = createnewcid($identity_id);
            $pcreate_newcid = $identity_id;

            $user_table = DB::table('rows.dbo.row_20170412_174724_amp6z')->where('C1982', $identity_id)->select('id');

            if ($user_table->exists()) {
                if (!DB::table('school_evaluation.dbo.schoolEvaluation_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('school_evaluation.dbo.schoolEvaluation_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                }
                Ques\Answerer::login('school_evaluation', $pcreate_newcid);
            }
            else
            {
                $validator->getMessageBag()->add('identity_id','您不是調查對象');
            }
        }
    ),

    'update' => function($page, $controller){
        if ($page == '2') {
            $pages = array(3, 4, 5, 6, 7);
            if (in_array(Input::get('p2q10'),[1])) {
                $controller->skip_page($pages);
            }
        }
        if ($page == '5') {
            $pages = array(3, 4, 5, 6, 7);
            if (in_array(Input::get('p2q10'),[1])) {
                $controller->skip_page($pages);
            }
        }
    },
    'blade' => function($page, &$init){
        
    },

    'hide' => function($page){
        
    },

    'publicData' => function($data){
        
    }
);