<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/105parent_short',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.105parent_short.head',
            'body' => 'ques.data.105parent_short.body',
            'footer' => 'ques.data.105parent_short.footer'
        ),
        'endView' => 'ques.data.105parent_short.end',
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

                $user_table = DB::table('rows.dbo.row_20160822_094434_qkbtr')->where('C1191', $identity_id)->select('id');

                if ($user_table->exists()) {
                    if (!DB::table('use_105.dbo.parentTwo105_id')->where('newcid', $pcreate_newcid)->exists()) {
                        DB::table('use_105.dbo.parentTwo105_id')->insert(['stdidnumber' => $identity_id, 'newcid' => $pcreate_newcid]);
                        Answerer::login('105parent_short', $pcreate_newcid);
                        $controller->skip_page(array(6,8,9,14));
                    }
                    else
                    {
                        $survey_type = DB::table('use_105.dbo.parentTwo105_pstat')->where('newcid', $pcreate_newcid)->select('survey_type')->first();
                        $done_pages = DB::table('use_105.dbo.parentTwo105_pstat')->where('newcid', $pcreate_newcid)->select('page')->first();
                        if ($survey_type->survey_type == 1){
                            if ($done_pages->page == 15){
                                $validator->getMessageBag()->add('identity_id','您已填寫完網路問卷');
                            }
                            else{
                                $validator->getMessageBag()->add('identity_id','您已填寫過網路問卷請繼續完成');
                            }
                        }
                        else
                        {
                            Answerer::login('105parent_short', $pcreate_newcid);
                        }
                    }
                   
                }
                else
                {
                    $validator->getMessageBag()->add('identity_id','您不是調查對象');
                }
            }
        }
    ),

    'update' => function($page, $controller){
      
    },
    'blade' => function($page, &$init){
        if( is_null(Answerer::newcid()) )
            return false;
        if( !is_null(Answerer::newcid()) ){
            DB::table('use_105.dbo.parentTwo105_pstat')->where('newcid', Answerer::newcid())->update(['survey_type' => 2]);
        }
       
        if ($page=='3') {
            $id = DB::table('use_105.dbo.parentTwo105_id')
                ->where('newcid', Answerer::newcid())
                ->select('stdidnumber')
                ->first();
            $name = '';
            $school = '';
            $user = DB::table('rows.dbo.row_20160822_094434_qkbtr')
                ->where('C1191', $id->stdidnumber)
                ->select('C1186','C1190')
                ->first();
            if (!empty($user->C1186)) {
                $school = DB::table('plat_public.dbo.secondary_school')
                        ->where('year', '105')
                        ->where('id', $user->C1186)
                        ->select('name')
                        ->first();
            }
            if (!empty($user->C1190)) {
                $name = $user->C1190;
            }
            if (empty($school)) {
                $school->name = '';
            }
            return array(
                'name' => $name,
                'school' => $school->name,
            );
        }
    },

    'hide' => function($page){
        if( is_null(Answerer::newcid()) )
            return false;

         if( $page == '3' ) {
              return ['QID_27jo3439','QID_a55ft983','QID_s57b6nls','QID_u0qh1w6u','QID_7ru9i5oz','QID_jvbk4nmp','QID_iww5dmfx','QID_lhfhykmo','QID_e04xi1m0'];
         }

         if( $page == '4' ) {
              return ['QID_l44c3ybk','QID_4pkwd62i','QID_vfvusfhe'];
         }

         if( $page == '5' ) {
              return ['QID_4zmebrkn','QID_9x6j0q63','QID_4zmebrkn','QID_gp11saka'];
         }

         if( $page == '7' ) {
              return ['QID_ys8ollvr','QID_ldkyh8mt'];
         }

         if( $page == '10' ) {
              return ['QID_s0fxh1r6','QID_wzppym58','QID_t61vq34p','QID_471rmapm'];
         }

         if( $page == '11' ) {
              return ['QID_xrrk68ob','QID_ecgo4pjm'];
         }

         if( $page == '12' ) {
              return ['QID_lck7z9nv','QID_9bkshx8o','QID_hbrk1wox','QID_vtwrhani','QID_wpodz9qr'];
         }

        if( $page == '12' ) {
            $page3 = DB::table('use_105.dbo.parentTwo105_page3')
                    ->where('newcid', Answerer::newcid())
                    ->select('p3q2')
                    ->first();
            if ($page3->p3q2 != '1') {
                return ['QID_vtwrhani','QID_wpodz9qr'];
            }
        }

        if( $page == '13' ) {
              return ['QID_xoxok4df','QID_zeqj80gx'];
         }
    },

    'publicData' => function($data){
        switch($data){
            case 'school':
                $schoolId =
                $school = DB::table('plat_public.dbo.secondary_school')
                        ->where('year', '105')
                        ->whereIn('citycode', isset($citycode_map[$citycode]) ? $citycode_map[$citycode] : array($citycode) )
                        ->whereIn('category', $category_map[$category])
                        ->orderBy('name')
                        ->lists('name', 'id');

                return Response::json($school);

            case 'city':

                $citys = DB::table('plat_public.dbo.lists')
                        ->where('type', 'city')
                        ->orderBy('sort')
                        ->select('name', 'code')
                        ->get();
                return Response::json($citys);

            case 'area':

                $areas = DB::table('plat_public.dbo.list_area')
                        ->where('city', Input::get('citycode', ''))
                        ->lists('cname', 'area');
                return Response::json($areas);

            case 'care':

                $care = DB::table('use_105.dbo.parentTwo105_page3')
                        ->where('newcid', Answerer::newcid())
                        ->select('p3q2')
                        ->first();
                return Response::json($care);

            case 'name':
                $id = DB::table('use_105.dbo.parentTwo105_id')
                    ->where('newcid', Answerer::newcid())
                    ->select('stdidnumber')
                    ->first();
                $name = '';
                $user = DB::table('rows.dbo.row_20160822_094434_qkbtr')
                    ->where('C1191', $id->stdidnumber)
                    ->select('C1186','C1190')
                    ->first();
                if (!empty($user->C1190)) {
                    $name = $user->C1190;
                }
                return Response::json($name);

            default :
            break;
        }
    }
);