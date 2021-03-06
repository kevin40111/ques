<h4 class="ui dividing header"><?=$doc->title?></h4>

<div class="ui message">
    <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
</div>

<div class="field">
    <?=Form::hidden('token', Input::get('token'), ['placeholder' => '身分證字號'])?>
</div>

<div class="ui error message">
    <div class="header">資料錯誤</div>
    <p><?=implode('、', array_filter($errors->all()))?></p>
</div>

<div class="ui positive fluid button" onclick="document.forms[0].submit()">登入</div>