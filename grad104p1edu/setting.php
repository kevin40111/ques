<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/grad104p1edu',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.grad104p1edu.intro',
            'head' => 'ques.data.grad104p1edu.head',
            'body' => 'ques.data.grad104p1edu.body',
            'footer' => 'ques.data.grad104p1edu.footer'
        ),
        'endView' => 'ques.data.grad104p1edu.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'stu_id' => 'required'
        ),
        'input_rull_message' => array(
            'stu_id.required' =>'未輸入身分證字號末五碼'
        ),
        'checker' => function(&$validator,$controller){
            $sch_name = Input::get('sch_name');
            $department_name = Input::get('department_name');
            $stu_id = Input::get('stu_id');
            $user_table = DB::table('rows.dbo.row_20170607_190730_zoldv')->where('C3293',$sch_name)->where('C3295',$department_name)->where('C3299',$stu_id)->select('id');

            if ($user_table->exists()) {
                $sch_id = DB::table('rows.dbo.row_20170607_194651_rroan')->where('C3306',$sch_name)->select('C3305 AS sch_id')->first()->sch_id;
                $dep_id = DB::table('rows.dbo.row_20170607_194651_rroan')->where('C3306',$sch_name)->where('C3308',$department_name)->select('C3307 AS dep_id')->first()->dep_id;
                $sha1_newcid = SHA1($sch_id.$dep_id.$stu_id);

                if (!DB::table('grad104p1edu.dbo.grad104p1edu_id')->where('newcid', $sha1_newcid)->exists()) {
                    DB::table('grad104p1edu.dbo.grad104p1edu_id')->insert(['sch_id' => $sch_id, 'department_id' => $dep_id, 'stu_id' => $stu_id, 'newcid' => $sha1_newcid]);
                }
                Ques\Answerer::login('grad104p1edu', $sha1_newcid);
            }else{
                $validator->getMessageBag()->add('stu_id','您不是調查對象');
            }
        }
    ),

    'update' => function($page, $controller){
        if ($page=='2') {
            $inputs  = Input::get('p2q1');
            
            if ($inputs == 3 || $inputs == 4) {
                $pages = array(3, 4);
                $controller->skip_page($pages);                
            }
        }
    },
    'blade' => function($page, &$init){

    },

    'hide' => function($page){

    },

    'publicData' => function($data){
        switch ($data) {
            case 'schools':
                $schools = DB::table('rows.dbo.row_20170607_194651_rroan')->groupBy('C3306')->select('C3306 AS sch_name')->get();

                return ['schools' =>  $schools];
                break;

            case 'departments':
                $departments = DB::table('rows.dbo.row_20170607_194651_rroan')->where('C3306',Input::get('sch_name'))->groupBy('C3308')->select('C3308 AS department_name')->get();

                return ['departments' =>  $departments];
                break;
        }
    }
);