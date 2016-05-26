<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',      
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/104principal',
    
    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.104principal.head',
            'body' => 'ques.data.104principal.body',
            'footer' => 'ques.data.104principal.footer'
        ),
        'endView' => 'ques.data.104principal.end',
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
                if (!DB::table('use_104.dbo.principal104_id')->where('newcid', $pcreate_newcid)->exists()) {
                    DB::table('use_104.dbo.principal104_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                } 
                Answerer::login('104principal', $pcreate_newcid); 
            }               
        }
    ),
            
    'update' => function($page, $controller){
        
    },
    'blade' => function($page, &$init){ 
        if( is_null(Answerer::newcid()) )
            return false;
    },
            
    'hide' => function($page){
        if( is_null(Answerer::newcid()) )
            return false;
    },
    
    'publicData' => function($data){
        switch ($data) {
            case 'school':
                $private_school = false;
                $page3 = DB::table('use_104.dbo.principal104_page3')->where('newcid', Answerer::newcid())->select('p3q8')->first();
                if ($page3->p3q8 == '2') {
                    $private_school = true;
                }
                return Response::json(['private_school'=>$private_school]);
                break;
        }
    }
);