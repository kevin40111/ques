<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => storage_path().'/ques/logs/fieldwork105',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.fieldwork105.head',
            'body' => 'ques.data.fieldwork105.body',
            'footer' => 'ques.data.fieldwork105.footer'
        ),
        'endView' => 'ques.data.fieldwork105.end',
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
                $user_table = DB::table('rows.dbo.row_20161003_094948_fuaiq')->where('C1258', $identity_id)->select('id');
                if ($user_table->exists()) {
                    if (!DB::table('tted_105.dbo.fieldwork105_id')->where('newcid', $pcreate_newcid)->exists()) {
                        DB::table('tted_105.dbo.fieldwork105_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                    }
                    Ques\Answerer::login('fieldwork105', $pcreate_newcid);
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
                    for ($i=3; $i <=11 ; $i++) {
                        $pages[] = $i;
                    }
                }
            }
            $controller->skip_page($pages);
        }
    },

    'blade' => function($page, &$init) {
        if ($page == '1') {
            $user = DB::table('rows.dbo.row_20161003_094948_fuaiq AS userinfo')
                ->leftJoin('tted_105.dbo.fieldwork105_id AS map', 'userinfo.C1258', '=', 'map.stdidnumber')
                ->leftJoin('plat.dbo.organization_details AS organization', 'userinfo.C1250', '=', 'organization.id')
                ->where('map.newcid', Ques\Answerer::newcid())
                ->select('organization.name AS schoolname')
                ->first();
            return array(
                'school' => $user->schoolname,
            );
        }

        if ($page == '4') {
            $stage = ['1' => '大學', '2' => '碩士', '3' => '博士'];
            $user = DB::table('rows.dbo.row_20161003_094948_fuaiq AS userinfo')
                ->leftJoin('tted_105.dbo.fieldwork105_id AS map', 'userinfo.C1258', '=', 'map.stdidnumber')
                ->where('map.newcid', Ques\Answerer::newcid())
                ->select('userinfo.C1254 AS stage')
                ->first();
            return array(
                'stage' => $stage[$user->stage],
            );
        }
    },

    'hide' => function($page){

    },

    'publicData' => function($data){
        switch ($data) {
            case 'area':
                return DB::table('rows.dbo.row_20161121_145744_f0q1p')->where('C1301', Input::get('city'))->lists('C1304', 'C1303');
                break;
            case 'school':
                $city   = Input::get('city', '');
                $area   = Input::get('area', '');
                $ps     = Input::get('ps', '');
                $stage  = Input::get('stage', '');
                $school_query = DB::table('rows.dbo.row_20161121_145744_f0q1p')->distinct();
                $city!='' && $school_query->where('C1301', $city);
                $area!='' && $school_query->where('C1303', $area);
                $ps!='' && $school_query->where('C1307', $ps);
                $stage!='' && $school_query->where('C1305', $stage);
                $school = $school_query->select('C1309', 'C1310')->lists('C1310', 'C1309');
                return Response::json($school);
                break;
            default:
                # code...
                break;
        }
    }
);