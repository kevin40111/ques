<?php
return array(


    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/kindom_app',

    'auth' => array(
        'loginView' => array(
            'intro' => 'ques.data.kindom_app.intro',
            'head' => 'ques.data.kindom_app.head',
            'body' => 'ques.data.kindom_app.body',
            'footer' => 'ques.data.kindom_app.footer'
        ),
        'endView' => 'ques.data.kindom_app.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(  
            'community'   => 'required|exists:rows.dbo.row_20160719_152336_bn4vu,C1166',
            'address'     => 'required|exists:rows.dbo.row_20160719_152336_bn4vu,C1167',
            'floor'       => 'required|integer|exists:rows.dbo.row_20160719_152336_bn4vu,C1168',
            'doornumber'  => 'required|exists:rows.dbo.row_20160719_152336_bn4vu,C1169',
            'identity_id' => 'required|alpha_dash|exists:rows.dbo.row_20160719_152336_bn4vu,C1170',
        ),
        'input_rull_message' => array(
            'community.required'   => '建案/社區名稱必填',
            'address.required'     => '門牌地址必填',
            'floor.required'       => '樓層必填',
            'doornumber.required'  => '門牌號碼必填',
            'identity_id.required' => '登入代碼必填',

            'floor.integer'          => '樓層必需是數字',
            'identity_id.alpha_dash' =>'登入代碼只能輸入數字',

            'community.exists' =>'沒有這個建案/社區名稱',
            'address.exists'     =>'沒有這個門牌地址',
            'floor.exists'       =>'沒有這個樓層',
            'doornumber.exists'  =>'沒有這個門牌號碼',
            'identity_id.exists' =>'沒有這個登入代碼',
        ),
        'checker' => function(&$validator, $controller){
            $identity_id = strtoupper(Input::get('identity_id'));
            $user = DB::table('rows.dbo.row_20160719_152336_bn4vu')
                ->whereNull('deleted_at')
                ->where('C1166', Input::get('community'))
                ->where('C1167', Input::get('address'))
                ->where('C1168', Input::get('floor'))
                ->where('C1169', Input::get('doornumber'))
                ->where('C1170', Input::get('identity_id'))->first();

            if ($user) {
                $newcid = $user->id;
                Answerer::login('kindom_app', $newcid);               
            } else {
                $validator->getMessageBag()->add('identity_id', '資料錯誤');
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
        if ($data == 'rooms') {
            $communitys = [];
            $rooms = DB::table('rows.dbo.row_20160719_152336_bn4vu')->whereNull('deleted_at')->select('C1166 AS community', 'C1167 AS address', 'C1168 AS floor', 'C1169 AS doornumber')->get();
            return ['rooms' => $rooms];
        }
    }
);