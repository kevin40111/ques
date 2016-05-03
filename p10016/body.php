<?php
$udeps = DB::table('rows.dbo.row_20160429_153119_mbwud')->groupBy('C1082')->orderBy('C1082')->select('C1082 AS udepname')->get();
?>

<h4 class="ui dividing header"><?=$doc->title?></h4>
<div class="ui message">
    <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
    <h5 class="ui blue header">問卷來分享！排名拿大獎！<div class="sub header">填完問卷後將您的專屬網址分享給其他人，累積人氣領獎券！</div></h5>
</div>
<div class="fields">
    <div class="eight wide field">
        <label>系所</label>
        <select name="udepname">
            <?php
                foreach($udeps as $udep) {
                    echo '<option value="' . $udep->udepname . '">' . $udep->udepname . '</option>';
                }
            ?>
        </select>
    </div>
    <div class="five wide field">
        <label>身分證字號末五碼</label>
        <input type="text" name="stdidnumber_last5" placeholder="" maxlength="5" />
        <input type="hidden" name="id" value="<?=Input::get('id', 0)?>" />
    </div>
</div>

<div class="ui error message">
    <div class="header">資料錯誤</div>
    <p><?=implode('、', array_filter($errors->all()))?></p>
</div>

<div class="ui positive button" onclick="document.forms[0].submit()">登入</div>