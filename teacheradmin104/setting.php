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
            'token' => 'required|alpha_dash',
        ),
        'input_rull_message' => array(
            'token.required' =>'網址連結有誤',
            'token.alpha_dash' =>'網址連結有誤',
        ),
        'checker' => function(&$validator, $controller) {
            try {
                if (DB::table('rows.dbo.row_20160121_182751_kljan_token')->where('token', Input::get('token'))->exists()) {
                    $user = DB::table('rows.dbo.row_20160121_182751_kljan_token')->where('token', Input::get('token'))->first();
                    Answerer::login('teacheradmin104', $user->token);
                } else {
                    $validator->getMessageBag()->add('key','網址連結有誤');
                } 
            } catch (Exception $e) {
                $validator->getMessageBag()->add('key','網址連結有誤');
                // echo $e->getMessage();exit();
            }
        }
    ),

    'update' => function($page, $controller){

    },

    'blade' => function($page, &$init) {
        $stdschoolstage = [1 => '大學', 2 => '碩士', 3 => '博士'];
        $stdschoolsys = [1 => '一般日間', 2 => '進修部、在職專班'];
        
        if ($page=='3') {
            $user = DB::table('rows.dbo.row_20160121_182751_kljan_token AS userinfo')->where('userinfo.token', Answerer::newcid())
                ->leftJoin('plat_public.dbo.university_school AS school', 'userinfo.school_id', '=', 'school.id')
                ->orderBy('school.year', 'desc')
                ->select('school.name AS schoolname', 'userinfo.name')
                ->first();
            return array(
                'name' => $user->name,
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