<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',      
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/104teacher',
    
    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.104teacher.head',
            'body' => 'ques.data.104teacher.body',
            'footer' => 'ques.data.104teacher.footer'
        ),
        'endView' => 'ques.data.104teacher.end',
        'testID' => 'A228909170',
        'primaryID' => 'newcid',
        'input_rull' => array(  
            'identity_id' => 'required|alpha_num|size:10'             
        ),
        'input_rull_message' => array(
            'identity_id.required' =>'身分證字號必填',
            'identity_id.alpha_num' =>'身分證字號格式錯誤',
            'identity_id.size' =>'身分證字號必需是10個字' 
        ),
        'checker' => function(&$validator,$controller){     
            $checkid = check_id_number(Input::get('identity_id'));
            if($checkid != true)
            {   
                $validator->getMessageBag()->add('identity_id','身分證字號錯誤');
            }
            else
            {   
                $identity_id = strtoupper(Input::get('identity_id'));
                $pcreate_newcid = createnewcid($identity_id);
                if (!DB::table('use_104.dbo.teacher104_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('use_104.dbo.teacher104_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                }   
                Answerer::login('104teacher', $pcreate_newcid); 
            }               
        }
    ),
            
    'update' => function($page, $controller){
        if ($page=='7') {
            $inputs = Input::only('p7q3c1', 'p7q3c2','p7q3c3','p7q3c4','p7q3c5','p7q3c6');
            foreach ($inputs as $key => $value) {
                if ($key == 'p7q3c1' && $value == '1') {
                    $pages = array(12);
                } else if ($value == '1'){
                    $pages = [];
                } 
            }
            $controller->skip_page($pages);
        }
    },
    'blade' => function($page, &$init){ 
        if( is_null(Answerer::newcid()) )
            return false;
    },
            
    'hide' => function($page){
        if( is_null(Answerer::newcid()) )
            return false;

        $page7 = DB::table('use_104.dbo.teacher104_page7')->where('newcid', Answerer::newcid())->select('p7q3c1','p7q3c2','p7q3c3','p7q3c4','p7q3c5','p7q3c6')->first();
        if( $page == '9' ) {
            $hide_content = [];
            foreach ($page7 as $key => $value) {
                if ($key == 'p7q3c1' && $value == '1' || $key == 'p7q3c6' && $value == '1' ) {
                    $hide_content = ['QID_0oh6zbj1'];
                } else if ($value == '1'){
                    $hide_content = [];
                } 
            }
            return $hide_content;
        }

        if ($page == '13') {
           $hide_content = [];
           foreach ($page7 as $key => $value) {
               if ($key == 'p7q3c1' && $value == '1') {
                   $hide_content = ['QID_lqqbayx7','QID_3d2ze02v'];
               } else if ($value == '1'){
                   $hide_content = [];
               } 
           }
           return $hide_content;
        }
    },
    
    'publicData' => function($data){
        switch ($data) {
            case 'school':
                $private_school = false;
                $page4 = DB::table('use_104.dbo.teacher104_page4')->where('newcid', Answerer::newcid())->select('p4q7')->first();
                if ($page4->p4q7 == '2') {
                    $private_school = true;
                }
                return Response::json(['private_school'=>$private_school]);
                break;
        }
    }
);