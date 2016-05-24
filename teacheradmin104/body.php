<h4 class="ui dividing header"><?=$doc->title?></h4>

<div class="ui message">
    <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
</div>

<div class="field" style="text-align:center">    
    只要您填答完問卷，即可參加<a href="/teacheradmin104/gift" target="_blank">抽獎活動！</a>
</div>


<!-- <div class="ui dividing header">
	<br>
	<br>
    <label>103學年度新進師資生調查原預訂於<span style="color:red">105/2/22</span>上線，<br/>延後至<span style="color:red">105/3/1</span>開放，造成您的不便敬請見諒!</label>
    <br>
    <br>
    <br>
    <br>
</div> -->

<div class="field">
    <label>請輸入您的身份證字號或居留證、護照號碼：</label>
    <?=Form::text('identity_id', Input::old('identity_id'), ['placeholder' => '身分證字號'])?>
    <div class="ui horizontal divider">或 </div>
    <?=Form::text('passport_id', Input::old('passport_id'), ['placeholder' => '居留證、護照號碼'])?>
</div>

<div class="ui error message">
    <div class="header">資料錯誤</div>
    <p><?=implode('、', array_filter($errors->all()))?></p>
</div>

<div class="ui positive fluid button" onclick="document.forms[0].submit()">登入</div>