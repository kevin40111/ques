<?php
$table_prefix = 'tiped_104_0016.dbo.tiped_104_0016_p1';
$newcid = Answerer::newcid();

$network = DB::table($table_prefix . '_network AS n')
	->leftJoin($table_prefix . '_pstat AS p', 'n.newcid', '=', 'p.newcid')
	->where('n.newcid', $newcid)
	->select('n.id', 'n.newcid_commend', 'n.complete', 'p.page')->first();

if (!$network->complete) {
	if ($network->page>8) {
		DB::table($table_prefix . '_network')->where('newcid', $newcid)->update(['complete' => true, 'completed_at' => \Carbon\Carbon::now()->toDateTimeString()]);
	} else {
		return '';
	}	
}

$my_commends = DB::table($table_prefix . '_network')->where('newcid_commend', $newcid)->where('complete', true)->count();

$newcid_commend = $network->newcid_commend;

$friends = DB::table('rows.dbo.row_20160429_153119_mbwud AS u')
	->leftJoin('rows.dbo.row_20160429_153119_mbwud AS um', function($join){
		$join->on('u.C1082', '=', 'um.C1082')->on('u.C1083', '=', 'um.C1083');
	})
	->leftJoin($table_prefix . '_network AS n', 'u.id', '=', 'n.newcid')
	->whereNull('n.complete')
	->where('um.id', $newcid)->select('u.C1080 AS stdname','u.id')->get();

$wait_name = '';
if (!empty($friends)) {
	foreach($friends as $friend)
		$wait_name .= '<div class="ui label">' . mb_substr($friend->stdname, 0, 1, 'UTF-8') . '&Omicron;' . mb_substr($friend->stdname, 2, 1, 'UTF-8') . '</div>';
}else{
	$wait_name .= '<div>您同系的同學都已填完問卷！謝謝您！</div>';
}

$orders = DB::table($table_prefix . '_network AS n1')
	->leftJoin('rows.dbo.row_20160429_153119_mbwud AS u', 'n1.newcid', '=', 'u.id')
	->where('n1.complete', true)
	->orderBy('n1.completed_at', 'ASC')
	->select('n1.id', 'n1.completed_at', 'u.C1082 AS dep', 'u.C1080 AS stdname')
	->distinct()
	->take(100)->get();

$completedRank = '';
foreach($orders as $i => $order){
	$completedRank .= '<tr class="center aligned "';
	if ($network->id == $order->id) {
		$completedRank .= 'style="background-color:#FFD2D2"';
	}
	$completedRank .= '>
		<td width="48">'.($i+1).'</td>
		<td style="color:blue" width="100">100元禮卷</td>
		<td width="200">'.$order->dep.'</td>
		<td width="100">'.$order->stdname.'</td>
		</tr>';
}


$commends = DB::table($table_prefix . '_network AS n1')
	->leftJoin($table_prefix . '_network AS n2', 'n1.newcid_commend', '=','n2.newcid')	
	->where('n1.newcid_commend', '<>', 0)
	->where('n1.complete', true)
	->where('n2.complete', true)
	->orderBy('count','DESC')
	->orderBy('n2.completed_at', 'ASC')
	->groupBy('n2.id', 'n2.completed_at')
	->select(DB::raw('COUNT(n2.id) AS count'), 'n2.id', 'n2.completed_at')
	->take(10)->get();

$rankstring = '';
foreach($commends as $i => $commend){
	$gift_text = '<span style="color:blue">500元禮券</span>';
	$rankstring .= '<tr class="center aligned "';
	if ($network->id == $commend->id) {
		$rankstring .= 'style="background-color:#FFD2D2"';
	}
	$rankstring .= '>
		<td>' . ($i+1).'</td>
		<td>' . $gift_text.'</td>
		<td>' . $commend->id.'</td>
		<td>' . $commend->count.'</td>
		</tr>';
}

?>

<div class="ui inverted vertical grey center aligned segment" style="min-height:300px">
	<h1 class="ui header" style="margin-top:3em">您的朋友也是本次調查對象嗎?</h1>
	
	<h1 class="ui header">邀請您的好朋友填答問卷，就有機會取得優質獎品！</h1>
</div>	

<div class="ui vertical stripe segment" style="padding:8em 0 8em 0">	

	<div class="ui middle aligned stackable grid container">
		<div class="row">
			<div class="ten wide left floated column">
				<img class="ui fluid image" src="/images/figure.png">
			</div>
			<div class="five wide column">
				<h3 class="ui header">您的推薦ID</h3>
				<p><span style="color:#00F"><?=$network->id?></span></p>
				<h3 class="ui header">個人填答網址</h3>
				<p><span style="color:#F00"><?=secure_url('', $parameters = array('p10016')) . '?id=' . $network->id?></span></p>
			</div>
		</div>
	</div>

</div>

<div class="ui vertical stripe segment">

	<div class="ui equal width stackable internally celled grid">
		<div class="center aligned row">
			<div class="column">
				<h3>"我的推薦數"</h3>
				<b>邀請朋友填完問卷<span style="color:#F00">（<?=$my_commends?>人）</span></b>
			</div>
			<div class="column">
				<h3>"還有誰沒填？"</h3>
				<h4>您可以幫助學校聯繫朋友填問卷。您可能認識的朋友有：</h4>
				<div class="ui message">
					<div><b></b></div>
					<div><?=$wait_name?></div>
					<p>註: 請朋友填問卷時，以「不造成當事人困擾」為原則。感謝您！</p>
				</div>
			</div>
		</div>
	</div>

</div>	

<div class="ui vertical stripe basic segment" style="padding:8em 0 8em 0">
	<div class="ui equal width grid">
		<div class="ui text container column">
			<h4 class="ui horizontal header divider">填答排行榜</h4>
			<table class="ui very basic table">
				<thead>
					<tr class="center aligned">
						<th width="48">名次</th>
						<th>獎項</th>
						<th width="200">系所</th>
						<th width="100">姓名</th>
					</tr>
				</thead>
				<tbody>
					<?=$completedRank?>
				</tbody>
			</table>
		</div>
		<div class="ui text container column">
			<h4 class="ui horizontal header divider">推薦排行榜</h4>
			<table class="ui very basic table">
				<thead>
					<tr class="center aligned">
						<th width="48">名次</th>
						<th>獎項</th>
						<th width="120">推薦ID</th>
						<th width="80">推薦人數</th>
					</tr>
				</thead>
				<tbody>
					<?=$rankstring?>
					<tr>
						<td colspan="4">
							<p>註1：推薦人數僅採計「完成問卷」人數。當推薦人數相同時，早填者的名次優於晚填者。</p>
							<p>註2：調查結束日時的名次才是給獎依據，獎項僅發1至10名。</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

@include('ques.data.p10016.footer')