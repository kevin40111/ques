<?php
return array(
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/adulthood',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.adulthood.intro',
            'head' => 'ques.data.adulthood.head',
            'body' => 'ques.data.adulthood.body',
            'footer' => 'ques.data.adulthood.footer'
        ),
        'endView' => 'ques.data.adulthood.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'department_id' => 'required'
        ),
        'input_rull_message' => array(
            'department_id.required' =>'科系必填',
        ),
        'checker' => function(&$validator, $controller) {
            if (Input::has('id4')) {
                $writer = DB::table($controller->doc->database . '.dbo.' . $controller->doc->table)->where('department_id', Input::get('department_id'))->where('id4', Input::get('id4'))->first();
            }

            if (isset($writer)) {
                Ques\Answerer::login($controller->root, $writer->id);
            } else {
                $amount = DB::table('rows.dbo.row_20161103_151909_t3oxc')->where('id', Input::get('department_id'))->select('C1365 AS sch_code', 'C1367 AS dep_code', 'C1369 AS value')->first();

                $count = DB::table($controller->doc->database . '.dbo.' . $controller->doc->table)->where('department_id', Input::get('department_id'))->count();

                if ($count >= $amount->value) {
                    $validator->getMessageBag()->add('department_id', '您選擇的系所已經調查完畢');
                } else {

                    $identity_id = DB::table($controller->doc->database . '.dbo.' . $controller->doc->table)->insertGetId([
                        'department_id' => Input::get('department_id'),
                        'school_code' => $amount->sch_code,
                        'department_code' => $amount->dep_code,
                        'id4' => Input::get('id4'),
                    ]);

                    Ques\Answerer::login($controller->root, $identity_id);
                }
            }
        }
    ),

    'update' => function($page, $controller) {

    },

    'blade' => function($page, &$init) {

    },

    'hide' => function($page) {

    },

    'publicData' => function($data) {
        switch ($data) {
            case 'schools':
                $schools = DB::table('rows.dbo.row_20161103_151909_t3oxc')->groupBy(['C1365', 'C1366'])->select('C1365 AS code', 'C1366 AS name')->get();

                return ['schools' => $schools];
                break;

            case 'departments':
                $departments = DB::table('rows.dbo.row_20161103_151909_t3oxc')->where('C1365', Input::get('school_code'))->select('id', 'C1368 AS name')->get();

                return ['departments' =>  $departments];
                break;
        }
    }
);