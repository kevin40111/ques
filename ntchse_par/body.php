<div class="ui segment" style="max-width:450px;margin:20px auto">

    <h4 class="ui dividing header"><?=$doc->title?></h4>

    <div class="ui message">
        <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
    </div>

    <div style="color:#0000FF">若您沒有家長帳號，請參考《<a href="http://ntchse.cher.ntnu.edu.tw/news/per_login/2/" target="_blank">家長帳號申請教學</a>》</div>


    <?php
        if( isset($dddos_error) && $dddos_error )
            echo '登入次數過多,請等待30秒後再進行登入';
        if( isset($csrf_error) && $csrf_error )
            echo '畫面過期，請重新登入';
        echo implode('、',array_filter($errors->all()));
    ?>
    <?php
        switch (Input::get('error')){
        case '1':
            $errmsg = "<div align=\"center\" style=\"color:#FF0000\">您的身分無法填寫此份問卷</div>";
            break;  
        case '2':
            $errmsg = "<div align=\"center\" style=\"color:#FF0000\">您的學校並非本學期評鑑對象</div>";
            break;  
        case '3':
            $errmsg = "<div align=\"center\" style=\"color:#FF0000\">您的學校並非高級中等學校校務評鑑評鑑對象</div>";
            break;  
        case '4':
            $errmsg = "<div align=\"center\" style=\"color:#FF0000\">身份驗證發生問題，請稍後在試</div>";
            break;              
        default:
            $errmsg = "";
            break;
        }
         echo $errmsg; 
    ?>
    
    <form action="https://ntchse.cher.ntnu.edu.tw/news/per_login/1?token=<?=csrf_token()?>" method="post">
    <input type="submit" class="ui positive fluid button" title="使用子女資料登入" value="使用子女資料登入" />
    </form>
    <br/>
    <form action="https://sso.ntpc.edu.tw/login.aspx" method="get">
        <input type="hidden" name="ReturnUrl" value="http://ntcse.ntpc.edu.tw/ques_hs?type=par__<?=csrf_token()?>__ntchse_par">
        <input type="submit" class="ui positive fluid button" title="使用新北市家長帳號登入" value="使用新北市家長帳號登入(須經申請並經學校審核通過)" />
        <br/>   
    </form>

    <a target="_blank" href="/<?=$doc->id?>/report">需要協助嗎?</a>
    <a target="_blank" href="/<?=$doc->dir?>/qa">問卷調查 Q &amp; A</a>

</div>