﻿<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/newteacher104',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.newteacher104.head',
            'body' => 'ques.data.newteacher104.body',
            'footer' => 'ques.data.newteacher104.footer'
        ),
        'endView' => 'ques.data.newteacher104.end',
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
                if (DB::table('rows.dbo.row_20151120_115629_t0ixj_peer')->where('token', Input::get('token'))->exists()) {
                    $user = DB::table('rows.dbo.row_20151120_115629_t0ixj_peer')->where('token', Input::get('token'))->first();
                    Answerer::login('teacherpeer104', $user->token);
                } else {
                    $validator->getMessageBag()->add('token','網址連結有誤');
                } 
            } catch (Exception $e) {
                $validator->getMessageBag()->add('token','網址連結有誤');
                // echo $e->getMessage();exit();
            }
            /*if (Input::has('identity_id') && Input::has('passport_id')) {
                $validator->getMessageBag()->add('identity_id','不能同時輸入身分證及居留證、護照號碼');
            } else {
                if (Input::has('identity_id')) {
                    $identity_id = strtoupper(Input::get('identity_id'));

                    if (!check_id_number($identity_id)) {
                        $validator->getMessageBag()->add('identity_id','身分證字號錯誤');
                    } else {
                        if (DB::table('rows.dbo.row_20151120_115629_t0ixj')->where('C95', $identity_id)->exists()) {
                            $pcreate_newcid = createnewcid($identity_id);
                            if (!DB::table('rows.dbo.row_20151120_115629_t0ixj_map')->where('newcid', $pcreate_newcid)->exists()) {
                                DB::table('rows.dbo.row_20151120_115629_t0ixj_map')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                            }
                            Answerer::login('newteacher104', $pcreate_newcid);
                        }  
                    }
                }
            }*/
        }
    ),

    'update' => function($page, $controller){

    },

    'blade' => function($page, &$init) {
        $stdschoolstage = [1 => '大學', 2 => '碩士', 3 => '博士'];
        $stdschoolsys = [1 => '一般日間', 2 => '進修部、在職專班'];
        
        if ($page=='3') {
            $name = '';
            $user = DB::table('rows.dbo.row_20151120_115629_t0ixj AS userinfo')
                ->leftJoin('rows.dbo.row_20151120_115629_t0ixj_map AS map', 'userinfo.C95', '=', 'map.stdidnumber')
                ->where('map.newcid', Answerer::newcid())
                ->select('userinfo.C87')
                ->first();
            if (!empty($user->C87)) {
                $name = $user->C87;
            }
            return array(
                'name' => $name,
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
            case 'disableQues':     
                $page3 = DB::table('tted_104.dbo.newteacher104_page3')->where('newcid', Answerer::newcid())->select('p3q6','p3q7c1','p3q7c2','p3q8c1','p3q8c2','p3q8c3','p3q8c4','p3q8c5','p3q8c6','p3q8c7','p3q8c8','p3q8c9')->first();
                $disable = false;
                if ($page3->p3q6 == '1' || $page3->p3q6 == '3') {
                    for ($i=1; $i <= 9; $i++) {
                        if ( $i != 4 && $page3->{'p3q8c'.$i} == '1' ) {
                            $all_false = false;
                            break;
                        } else {
                            $all_false = true;
                        }
                    }
                    if ($page3->p3q8c4 == '1' && $all_false == true) {
                        $disable = true;
                    } 
                } elseif ($page3->p3q6 == '2') {
                    if ($page3->p3q7c1 == '1' && $page3->p3q7c2 == '0') {
                        $disable = true;
                    } else {
                        $disable = false;
                    }
                }
                return Response::json($disable);
                break;
            default:
                # code...
                break;
        }
    }
);