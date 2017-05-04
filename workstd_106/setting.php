<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/workstd_106',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.workstd_106.intro',
            'head' => 'ques.data.workstd_106.head',
            'body' => 'ques.data.workstd_106.body',
            'footer' => 'ques.data.workstd_106.footer'
        ),
        'endView' => 'ques.data.workstd_106.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'sch_name' => 'required',
            'departmant_name' => 'required',
            'organization_name' => 'required',
            'stu_id' => 'required'
        ),
        'input_rull_message' => array(
            'sch_name.required' =>'學校未選擇',
            'departmant_name.required' =>'科別未選擇',
            'organization_name.required' =>'未輸入合作機構',
            'stu_id.required' =>'未輸入學號'
        ),
        'checker' => function(&$validator,$controller){            
            $sch_name = Input::get('sch_name');
            $departmant_name = Input::get('departmant_name');
            $organization_name = Input::get('organization_name');
            $stu_id = Input::get('stu_id');

            /*$sch_id = DB::table('rows.dbo.row_20170504_173723_kz7t4')->where('C2805',$sch_name)->select('C2804 AS sch_id')->get();
            $dep_id = DB::table('rows.dbo.row_20170504_173723_kz7t4')->where('C2807',$sch_name)->select('C2806 AS dep_id')->get();
            $sha1_newcid = hashbytes('SHA1',$sch_id.$dep_id.$stu_id);*/
            //dd($sha1_newcid);
            //$pcreate_newcid = createnewcid($identity_id);
            $sha1_newcid = '123';
            if (!DB::table('workstd_106.dbo.workstd_106_id')->where('newcid', $sha1_newcid)->exists()) {
                DB::table('workstd_106.dbo.workstd_106_id')->insert(['sch_id' => $sch_id, 'departmant_id' => $dep_id, 'organization' => $organization_name, 'stu_id' => $stu_id, 'newcid' => $sha1_newcid]);
            }  
            Answerer::login('workstd_106', $sha1_newcid);
            //$pcreate_newcid = createnewcid($identity_id);
           /* $pcreate_newcid = $identity_id;

            $user_table = DB::table('rows.dbo.row_20170412_174724_amp6z')->where('C1982', $identity_id)->select('id')->hashbytes('SHA1','   966623  ');

            /*if ($user_table->exists()) {
                if (!DB::table('school_evaluation.dbo.schoolEvaluation_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('school_evaluation.dbo.schoolEvaluation_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                }
                Ques\Answerer::login('school_evaluation', $pcreate_newcid);
            }
            else
            {
                $validator->getMessageBag()->add('identity_id','您不是調查對象');
            }*/
        }
    ),

    'update' => function($page, $controller){
        
    },
    'blade' => function($page, &$init){
        
    },

    'hide' => function($page){
        
    },

    'publicData' => function($data){
        switch ($data) {
            case 'schools':
                $schools = DB::table('rows.dbo.row_20170504_173723_kz7t4')->groupBy('C2805')->select('C2805 AS sch_name')->get();

                return ['schools' =>  $schools];
                break;

            case 'departments':
                $departments = DB::table('rows.dbo.row_20170504_173723_kz7t4')->where('C2805',Input::get('sch_name'))->groupBy('C2807')->select('C2807 AS department_name')->get();

                return ['departments' =>  $departments];
                break;

            case 'organizations':

                $organizations = DB::table('rows.dbo.row_20170504_173723_kz7t4')->where('C2808', 'like', '%' . Input::get('searchText') . '%')->groupBy('C2808')->select('C2808 AS organization_name')->get();

                return ['organizations' =>  $organizations];
                break;
        }
    }
);