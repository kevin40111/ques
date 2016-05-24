<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/teacheradmin104',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.teacheradmin104.head',
            'body' => 'ques.data.teacheradmin104.body',
            'footer' => 'ques.data.teacheradmin104.footer'
        ),
        'endView' => 'ques.data.teacheradmin104.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'identity_id' => 'required_without:passport_id|alpha_num|size:10',
            'passport_id' => 'required_without:identity_id|alpha_num|max:15'
        ),
        'input_rull_message' => array(
            'identity_id.required_without' =>'身分證字號必填',
            'identity_id.alpha_num' =>'身分證字號格式錯誤',
            'identity_id.size' =>'身分證字號必需是10個字',

            'passport_id.required_without' =>'居留證、護照號碼必填',
            'passport_id.alpha_num' =>'居留證、護照號碼格式錯誤',
            'passport_id.max' =>'居留證、護照號碼不能超過15個字',
        ),
        'checker' => function(&$validator, $controller) {
            try {
                if (DB::table('rows_import.dbo.row_20151120_115629_t0ixj_peer')->where('token', Input::get('key'))->exists()) {
                    $user = DB::table('rows_import.dbo.row_20151120_115629_t0ixj_peer')->where('token', Input::get('key'))->first();
                    Answerer::login('teacherpeer104', $user->token);
                } else {
                    $validator->getMessageBag()->add('key','網址連結有誤');
                } 
            } catch (Exception $e) {
                $validator->getMessageBag()->add('key','網址連結有誤');
                // echo $e->getMessage();exit();
            }
            
            /*if (Input::has('identity_id') && Input::has('passport_id')) {
                $validator->getMessageBag()->add('identity_id','不能同時輸入身分證及居留證、護照號碼');
            } else {
                if (Input::has('identity_id')) {
                    $identity_id = strtoupper(Input::get('identity_id'));

                    if (!check_id_number(Input::get('identity_id'))) {
                        $validator->getMessageBag()->add('identity_id','身分證字號錯誤');
                    } else {
                        if (DB::table('rows_import.dbo.row_20150925_121612_tsttf')->where('C31', $identity_id)->exists()) {
                            $user = DB::table('rows_import.dbo.row_20150925_121612_tsttf')->where('C31', $identity_id)->first();
                            Answerer::login('teacheradmin104', $user->id);
                        }  
                    }
                }
                if (Input::has('passport_id')) {
                    $passport_id = strtoupper(Input::get('passport_id'));
                    if (DB::table('rows_import.dbo.row_20150925_121612_tsttf')->where('C32', $passport_id)->exists()) {
                        $user = DB::table('rows_import.dbo.row_20150925_121612_tsttf')->where('C32', $passport_id)->first();
                        Answerer::login('teacheradmin104', $user->id);
                    }
                }
            }*/
        }
    ),

    'update' => function($page, $controller){

    },

    'blade' => function($page, &$init) {
        $stdschoolstage = [1 => '大學', 2 => '碩士', 3 => '博士'];
        $stdschoolsys = [1 => '一般日間', 2 => '進修部、在職專班'];
        
        if ($page=='3') {
            $user = DB::table('rows_import.dbo.row_20150925_121612_tsttf AS userinfo')->where('userinfo.id', Answerer::newcid())
                ->leftJoin('plat_public.dbo.university_school AS school', 'userinfo.C23', '=', 'school.id')
                ->orderBy('school.year', 'desc')
                ->select('school.name AS schoolname', 'userinfo.C26', 'userinfo.C28', 'userinfo.C29', 'userinfo.C30')
                ->first();
            return array(
                'name' => $user->C30,              
            );
        }
    },

    'hide' => function($page){
       
    },

    'publicData' => function($data){
        switch ($data) {
            case 'school':
                $school_query = DB::table('plat_public.dbo.university_school');
                $school = $school_query->where('edu','True')->select('id', 'name')->orderBy('type')->get();
                return Response::json($school);
                break;
            default:
                # code...
                break;
        }
    }
);