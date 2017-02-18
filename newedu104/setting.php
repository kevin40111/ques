<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => storage_path().'/ques/logs/newedu104',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.newedu104.head',
            'body' => 'ques.data.newedu104.body',
            'footer' => 'ques.data.newedu104.footer'
        ),
        'endView' => 'ques.data.newedu104.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            // 'identity_id' => 'required_without:passport_id|alpha_num|size:10',
            // 'passport_id' => 'required_without:identity_id|alpha_num|max:15'
        ),
        'input_rull_message' => array(
            // 'identity_id.required_without' =>'身分證字號必填',
            // 'identity_id.alpha_num' =>'身分證字號格式錯誤',
            // 'identity_id.size' =>'身分證字號必需是10個字',

            // 'passport_id.required_without' =>'居留證、護照號碼必填',
            // 'passport_id.alpha_num' =>'居留證、護照號碼格式錯誤',
            // 'passport_id.max' =>'居留證、護照號碼不能超過15個字',
        ),
        'checker' => function(&$validator, $controller) {
            if (Input::has('identity_id')) {
                $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = !check_id_number($identity_id) ? md5($identity_id) : createnewcid($identity_id);
                $user_table = DB::table('rows.dbo.row_20161003_093922_nqshr')->where('C1238', $identity_id)->select('id');
                if ($user_table->exists()) {
                    if (!DB::table('tted_105.dbo.newedu104_id')->where('newcid', $pcreate_newcid)->exists()) {
                        DB::table('tted_105.dbo.newedu104_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                    }
                    Ques\Answerer::login('newedu104', $pcreate_newcid);
                }
                else
                {
                    $validator->getMessageBag()->add('identity_id','身分證字號或居留證、護照號碼錯誤');
                }
            } else {
                $validator->getMessageBag()->add('identity_id','請輸入身分證字號或居留證、護照號碼');
            }
        }
    ),

    'update' => function($page, $controller){
        if ($page == '2') {
            $inputs = Input::only('p2q1');
            $pages = [];
            foreach ($inputs as $key => $value) {
                if ($key == 'p2q1' && $value == '2') {
                    for ($i = 3; $i <= 9 ; $i++) {
                        $pages[] = $i;
                    }
                }
            }
            $controller->skip_page($pages);
        }
    },

    'blade' => function($page, &$init) {
        if ($page == '1') {
            $user = DB::table('rows.dbo.row_20161003_093922_nqshr AS userinfo')
                ->leftJoin('tted_105.dbo.newedu104_id AS map', 'userinfo.C1238', '=', 'map.stdidnumber')
                ->where('map.newcid', Ques\Answerer::newcid())
                ->select('userinfo.C1236 AS name')
                ->first();
            $name = !empty($user->name) ? $user->name : '';
            return array(
                'name' => $name,
            );
        }

        if ($page == '4' || $page == '5') {
            $class = [];
            $page3 = DB::table('tted_105.dbo.newedu104_page3')
                ->where('newcid', Ques\Answerer::newcid())
                ->select('p3q2c1', 'p3q2c2', 'p3q2c3', 'p3q2c4')
                ->first();
            $page3->p3q2c1 == 1 ? array_push($class, '幼兒園') : null;
            $page3->p3q2c2 == 1 ? array_push($class, '國民小學') : null;
            $page3->p3q2c3 == 1 ? array_push($class, '中等學校') : null;
            $page3->p3q2c4 == 1 ? array_push($class, '特殊教育學校（班）') : null;
            return array(
                'class' => implode('、', $class),
            );
        }
    },

    'hide' => function($page){
        if( is_null(Ques\Answerer::newcid()) )
            return false;

        if( $page == '3' ) {
            $user = DB::table('rows.dbo.row_20161003_093922_nqshr AS userinfo')
                    ->leftJoin('tted_105.dbo.newedu104_id AS map', 'userinfo.C1238', '=', 'map.stdidnumber')
                    ->where('map.newcid', Ques\Answerer::newcid())
                    ->select('userinfo.C1234 AS grade')
                    ->first();
        $hides = [];
            if ($user->grade != '3') {
                array_push($hides, 'QID_gbv4cb7d');
                if ($user->grade != '2') {
                    array_push($hides, 'QID_ifi56qb4');
                }
            }
            return $hides;
        }
    },

    'publicData' => function($data){
        switch ($data) {
            case 'school':
                $school_query = DB::table('plat.dbo.organization_details');
                $school = $school_query->where('grade','0')
                    ->where('year','<=','104')
                    ->where('syscode','1')
                    ->select('id', 'name')
                    ->orderBy('type')
                    ->orderBy('year')
                    ->get();
                return Response::json($school);
                break;
            case 'class':
                $class = [];
                $page3 = DB::table('tted_105.dbo.newedu104_page3')
                    ->where('newcid', Ques\Answerer::newcid())
                    ->select('p3q2c1', 'p3q2c2', 'p3q2c3', 'p3q2c4')
                    ->first();
                return Response::json($page3);
                break;
            default:
                # code...
                break;
        }
    }
);