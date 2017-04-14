<div class="ui segment" style="max-width:450px;margin:20px auto">

    <h4 class="ui dividing header"><?=$doc->title?></h4>

    <div class="ui message">
        <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
    </div>


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
    <input type="submit" class="ui positive fluid button" title="登入" value="登入" />
    <a target="_blank" href="/<?=$doc->id?>/report">需要協助嗎?</a>

</div>