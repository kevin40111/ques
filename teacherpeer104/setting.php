<?php
return array(
    'debug' => true,
    'forceClose' => 0,
    'buildQuestion' => 'v10',
    'buildQuestionEvent' => 'buildQuestionEvent__v1.9.3.utf8.php',
    'logInput' => true,
    'logInputDir' => '//192.168.0.125/quesnlb_ap/WEB_log/QUES-DB/teacherpeer104',

    'auth' => array(
        'loginView' => array(
            'head' => 'ques.data.teacherpeer104.head',
            'body' => 'ques.data.teacherpeer104.body',
            'footer' => 'ques.data.teacherpeer104.footer'
        ),
        'endView' => 'ques.data.teacherpeer104.end',
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
                    Ques\Answerer::login('teacherpeer104', $user->token);
                } else {
                    $validator->getMessageBag()->add('token','網址連結有誤');
                } 
            } catch (Exception $e) {
                $validator->getMessageBag()->add('token','網址連結有誤');
                // echo $e->getMessage();exit();
            }
        }
    ),

    'update' => function($page, $controller){
        $peer = DB::table('rows.dbo.row_20151120_115629_t0ixj_peer')
            ->where('token', Ques\Answerer::newcid())
            ->select('token','school_id','peer_name')
            ->first();

        $peers_pstat = DB::table('rows.dbo.row_20151120_115629_t0ixj_peer as peer')
            ->leftJoin('tted_104.dbo.teacherpeer104_pstat as pstat','peer.token','=','pstat.newcid')
            ->where('peer.school_id', $peer->school_id)
            ->where('peer.peer_name', $peer->peer_name)
            ->where('peer.token','!=', $peer->token)
            ->select('pstat.page')
            ->get();

        $pages = [];
        if (!empty($peers_pstat)) {
            foreach ($peers_pstat as $peer_pstat) {
                if ($peer_pstat->page >= 6) {
                    $pages [] = 5;
                    if ($peer_pstat->page >= 7) {
                        $pages [] = 6;
                    }
                }
            }
            $pages = array_values(array_unique($pages));
        }
        $controller->skip_page($pages);
    },

    'blade' => function($page, &$init) {
        $user = DB::table('rows.dbo.row_20151120_115629_t0ixj_peer AS tokenInfo')
            ->leftJoin('rows.dbo.row_20151120_115629_t0ixj AS teacherInfo','tokenInfo.stdidnumber','=','teacherInfo.C95')
            ->select('tokenInfo.peer_name','teacherInfo.C87')
            ->where('tokenInfo.token', Ques\Answerer::newcid())
            ->first();

        if ($page=='3') {
            return array(
                'name' => $user->peer_name,          
            );
        }
        if ($page=='4') {
            return array(
                'newteacher' => $user->C87,          
            );
        }
    },

    'hide' => function($page){
        if ($page == 3) {
            $peer = DB::table('rows.dbo.row_20151120_115629_t0ixj_peer')
                ->where('token', Ques\Answerer::newcid())
                ->select('token','school_id','peer_name')
                ->first();

            $peers_pstat = DB::table('rows.dbo.row_20151120_115629_t0ixj_peer as peer')
                ->leftJoin('tted_104.dbo.teacherpeer104_pstat as pstat','peer.token','=','pstat.newcid')
                ->where('peer.school_id', $peer->school_id)
                ->where('peer.peer_name', $peer->peer_name)
                ->where('peer.token','!=', $peer->token)
                ->select('pstat.page')
                ->get();

            $hidden_content = null;
            if (!empty($peers_pstat)) {
                foreach ($peers_pstat as $peer_pstat) {
                    if ($peer_pstat->page >= 4) {
                        $hidden_content = ['QID_b9outaru','QID_bq4nxjuv','QID_lpwpu2jf','QID_tinmrevx','QID_hi3acxl9','QID_98fxdas5','QID_hx8b4dr7','QID_vdg9vpsb'];
                        break;
                    } 
                }
            }
            return $hidden_content;
        }
    },

    'publicData' => function($data){
        
    }
);