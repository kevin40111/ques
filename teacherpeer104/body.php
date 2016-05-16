<h4 class="ui dividing header"><?=$doc->title?></h4>

<div class="ui message">
    <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
</div>

<div class="field" style="text-align:center">    
    只要您填答完問卷，即可參加<a href="/teacherpeer104/gift" target="_blank">抽獎活動！</a>
</div>

<div class="field">
    <?=Form::hidden('key', Input::get('key'), ['placeholder' => '身分證字號'])?>
</div>

<div class="ui error message">
    <div class="header">資料錯誤</div>
    <p><?=implode('、', array_filter($errors->all()))?></p>
</div>

<div class="ui positive fluid button" onclick="document.forms[0].submit()">登入</div>