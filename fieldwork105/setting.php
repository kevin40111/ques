<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => false,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/fieldwork105',

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
            if (Input::has('identity_id')) {
                if (!check_id_number(Input::get('identity_id'))) {
                    $validator->getMessageBag()->add('identity_id','身分證字號或居留證、護照號碼錯誤');
                } else {
                    $identity_id = strtoupper(Input::get('identity_id'));
                    $pcreate_newcid = createnewcid($identity_id);
                    $user_table = DB::table('rows.dbo.row_20160822_094434_qkbtr')->where('C1191', $identity_id)->select('id');

                    if ($user_table->exists()) {
                        if (!DB::table('tted_105.dbo.fieldwork105_id')->where('newcid', $pcreate_newcid)->exists()) {
                            DB::table('tted_105.dbo.fieldwork105_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                        }
                        Ques\Answerer::login('fieldwork105', $pcreate_newcid);
                    }
                    else
                    {
                        $validator->getMessageBag()->add('identity_id','您不是調查對象');
                    }
                }
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
        $stdschoolstage = [1 => '大學', 2 => '碩士', 3 => '博士'];
        $stdschoolsys = [1 => '一般日間', 2 => '進修部、在職專班'];

        if ($page == '1') {
            /*$user = DB::table('rows_import.dbo.row_20150925_121200_hl2sl AS userinfo')->where('userinfo.id', Ques\Answerer::newcid())
                ->leftJoin('ques_admin.dbo.pub_school_u AS school', 'userinfo.C1', '=', 'school.id')
                ->orderBy('school.year', 'desc')
                ->select('school.name AS schoolname', 'userinfo.C5', 'userinfo.C6', 'userinfo.C7', 'userinfo.C8')
                ->first();

            return array(
                'udepcode'       => '',
                'name'           => $user->C8,
                'stdschoolstage' => $stdschoolstage[$user->C6],
                'stdschoolsys'   => $stdschoolsys[$user->C7],
                'school'         => $user->schoolname . $user->C5,
            );*/
        }
    },

    'hide' => function($page){

    },

    'publicData' => function($data){
        switch ($data) {
            case 'area':
                return DB::table('plat_public.dbo.list_area')->where('city', Input::get('city'))->lists('cname', 'area');
                break;

            case 'school':
                $city   = Input::get('city', '');
                $area   = Input::get('area', '');
                $ps     = Input::get('ps', '');
                $stage  = Input::get('stage', '');
                $school_query = DB::table('rows.dbo.row_20161121_145744_f0q1p')->distinct();
                $city!='' && $school_query->where('cityid', $city);
                $area!='' && $school_query->where('areaid', $area);
                $ps!='' && $school_query->where('psid', $ps);
                $stage!='' && $school_query->where('stageid', $stage);
                $school = $school_query->select('id', 'schoolid', 'school')->orderBy('id')->lists('school', 'schoolid');
                return Response::json($school);
                break;
            default:
                # code...
                break;
        }
    }
);