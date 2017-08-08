<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/106grade10',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.106grade10.intro',
            'head' => 'ques.data.106grade10.head',
            'body' => 'ques.data.106grade10.body',
            'footer' => 'ques.data.106grade10.footer'
        ),
        'endView' => 'ques.data.106grade10.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'identity_id' => 'required|alpha_num|size:10',
            'year' => 'required',
            'month' => 'required',
        ),
        'input_rull_message' => array(
            'identity_id.required' =>'身分證字號必填',
            'identity_id.alpha_num' =>'身分證字號格式錯誤',
            'identity_id.size' =>'身分證字號必需是10個字',
            'year.required' =>'出生年必填',
            'month.required' =>'出生月必填',
        ),
        'checker' => function(&$validator,$controller){
            $checkid = check_id_number(Input::get('identity_id'));
            if($checkid != true) {
                $validator->getMessageBag()->add('identity_id','身分證字號錯誤');
            } else {
                $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = createnewcid($identity_id);
                $year = Input::get('year');
                $month = Input::get('month');

                if (!DB::table('use_106.dbo.seniorOne106_id')->where('newcid', $pcreate_newcid)->exists()) {
                    if ($year > 86 || ($year == 86 && $month >= 8)) {
                        $countEnglish = DB::table('use_106.dbo.seniorOne106_id')->where('type', '=', 1)->count();
                        $countMath    = DB::table('use_106.dbo.seniorOne106_id')->where('type', '=', 2)->count();
                        $type = ($countEnglish <= $countMath) ? 1 : 2;
                        DB::table('use_106.dbo.seniorOne106_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid, 'year' => $year, 'month' => $month, 'type' => $type]);
                    } else {
                        DB::table('use_106.dbo.seniorOne106_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid, 'year' => $year, 'month' => $month, 'type' => ($year != 75) ? 3 : 4]);
                    }
                } else {
                    $user = DB::table('use_106.dbo.seniorOne106_id')->where('newcid', $pcreate_newcid)->first();
                    if ($user->year != $year) {
                        $validator->getMessageBag()->add('year','出生年錯誤');
                    }
                    if ($user->month != $month) {
                        $validator->getMessageBag()->add('month','出生月錯誤');
                    }
                }
                Ques\Answerer::login('106grade10', $pcreate_newcid);
            }
        }
    ),

    'update' => function($page, $controller){
        $type = DB::table('use_106.dbo.seniorOne106_id')->where('newcid', Ques\Answerer::newcid())->select('type')->first()->type;
        switch ($type) {
        case '1': // under 20 years old (English)
            $controller->skip_page(array(9,10,11,12,13));
            break;
        case '2': // under 20 years old (Math)
            $controller->skip_page(array(14,15,16,17,18));
            break;
        case '3': // between 20-30 years old
            $controller->skip_page(array(4,5,6,7,9,10,11,12,13,14,15,16,17,18,19));
            break;
        case '4': // above 30 years old
            $controller->skip_page(array(4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24));
            break;
        default:
            //$controller->skip_page(array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20));
            break;
        }
    },
    'blade' => function($page, &$init){

    },

    'hide' => function($page){
        if ($page == '22') {
            $page19 = DB::table('use_106.dbo.seniorOne106_page19')->where('newcid', Ques\Answerer::newcid())->select('p19q1')->first();
            if (!is_null($page19->p19q1) && $page19->p19q1 == '8') {
                return ['QID_594wk910', 'QID_klhq4ane', 'QID_1v2cy1l9'];
            }
        }

        $agree = DB::table('use_106.dbo.seniorOne106_page2')->where('newcid', Ques\Answerer::newcid())->select('p2q1')->first();
        if (isset($agree) && $agree->p2q1) {
            return ['QID_jrj4ffvc', 'QID_fteyeoq0', 'QID_38ngm3o5', 'QID_6z92pn3c', 'QID_3lxws41a'];
        }
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