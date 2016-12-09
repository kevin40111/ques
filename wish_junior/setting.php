<?php
return array(
    'logInput' => false,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/wish_junior',
    'skip' => false,

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.wish_junior.intro',
            'head' => 'ques.data.wish_junior.head',
            'body' => 'ques.data.wish_junior.body',
            'footer' => 'ques.data.wish_junior.footer'
        ),
        'endView' => 'ques.data.wish_junior.end',
        'primaryID' => 'newcid',
        'input_rull' => array(
            'school_id' => 'required|integer',
        ),
        'input_rull_message' => array(
            'school_id.required' =>'學校必填',
            'school_id.integer' => '學校錯誤',
        ),
        'checker' => function(&$validator, $controller) {
            $amount = DB::table('rows.dbo.row_20161208_155613_quh4a')->where('id', Input::get('school_id'))->select('C1952 AS school_code', 'C1954 AS value')->first();

            $count = DB::table($controller->doc->database . '.dbo.' . $controller->doc->table . ' AS i')
                ->leftJoin($controller->doc->database . '.dbo.' . $controller->doc->table . '_pstat AS pstat', 'i.id', '=', 'pstat.newcid')
                ->where('i.school_code', $amount->school_code)
                ->count();

            if ($count >= $amount->value) {
                $validator->getMessageBag()->add('department_id', '您選擇的學校已經調查完畢');
            } else {

                $identity_id = DB::table($controller->doc->database . '.dbo.' . $controller->doc->table)->insertGetId([
                    'school_code' => $amount->school_code,
                ]);

                Ques\Answerer::login($controller->root, $identity_id);
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
            case 'citys':
                $citys = DB::table('plat_public.dbo.lists')->select('code', 'name')->orderBy('sort')->get();

                return ['citys' => $citys];
                break;

            case 'areas':
                $areas = DB::table('plat_public.dbo.list_area')->where('city', Input::get('city_code'))->select('area AS code', 'cname AS name')->orderBy('area')->get();

                return ['areas' => $areas];
                break;

            case 'highSchools':
                $highSchools = DB::table('plat.dbo.organization_details')->whereIn('grade', ['3', '4'])->where('citycode', Input::get('city_code'))->select('id AS code', 'name')->orderBy('name')->get();

                return ['highSchools' => $highSchools];
                break;

            case 'schools':
                $schools = DB::table('rows.dbo.row_20161208_155613_quh4a')->where('C1955', Input::get('city_code'))->select('id', 'C1953 AS name')->get();

                return ['schools' =>  $schools];
                break;

            case 'categories':
                $categories = DB::table('rows.dbo.row_20161208_173038_wyps8')->groupBy('C1956', 'C1957')->select('C1956 AS code', 'C1957 AS name')->get();

                return ['categories' =>  $categories];
                break;

            case 'departments':
                $departments = DB::table('rows.dbo.row_20161208_173038_wyps8')->where('C1956', Input::get('category'))->select('C1958 AS code', 'C1959 AS name')->get();

                return ['departments' =>  $departments];
                break;
        }
    }
);