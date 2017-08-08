<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/106grade10f',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.106grade10f.intro',
            'head' => 'ques.data.106grade10f.head',
            'body' => 'ques.data.106grade10f.body',
            'footer' => 'ques.data.106grade10f.footer'
        ),
        'endView' => 'ques.data.106grade10f.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'identity_id' => 'required|alpha_num|size:10',
            'year' => 'required',
            'month' => 'required',
        ),
        'input_rull_message' => array(
            'identity_id.required' =>'居留證號碼必填',
            'identity_id.alpha_num' =>'居留證號碼格式錯誤',
            'identity_id.size' =>'居留證號碼必需是10個字',
            'year.required' =>'出生年必填',
            'month.required' =>'出生月必填',
        ),
        'checker' => function(&$validator,$controller){
            $checkid = check_resident_number(Input::get('identity_id'));
            if($checkid != true) {
                $validator->getMessageBag()->add('identity_id','居留證號碼錯誤');
            } else {
                $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = createnewcid_resident($identity_id);
                $year = Input::get('year');
                $month = Input::get('month');

                if (!DB::table('use_106.dbo.seniorOne106f_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('use_106.dbo.seniorOne106f_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid, 'year' => $year, 'month' => $month]);
                } else {
                    $user = DB::table('use_106.dbo.seniorOne106f_id')->where('newcid', $pcreate_newcid)->first();
                    if ($user->year != $year) {
                        $validator->getMessageBag()->add('year','出生年錯誤');
                    }
                    if ($user->month != $month) {
                        $validator->getMessageBag()->add('month','出生月錯誤');
                    }
                }
                Ques\Answerer::login('106grade10f', $pcreate_newcid);
            }
        }
    ),

    'update' => function($page, $controller){

    },
    'blade' => function($page, &$init){

    },

    'hide' => function($page){

    },

    'publicData' => function($data){
        switch($data){
            case 'school':
                $citycode = Input::get('citycode');
                $category = Input::get('category');

                $schools = DB::table('use_106.dbo.schools')->where('citycode',$citycode)->where('category',$category)->orderBy('name')->lists('name', 'id');
                return Response::json($schools);

            case 'area':
                $areas = DB::table('use_106.dbo.area')->where('citycode', Input::get('citycode'))->lists('townname', 'zipcode');
                return Response::json($areas);

            default :
            break;
        }
    }
);