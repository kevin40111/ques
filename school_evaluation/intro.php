<!DOCTYPE html>
<html xml:lang="zh-TW" lang="zh-TW" ng-app="app">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?=$doc->title?></title>

<!--[if lt IE 9]><script src="js/html5shiv.js"></script><![endif]-->
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/angular/1.5.3/angular.min.js"></script>
<script src="/js/angular/1.5.3/angular-sanitize.min.js"></script>
<script src="/js/angular/1.5.3/angular-animate.min.js"></script>
<script src="/js/angular/1.5.3/angular-aria.min.js"></script>
<script src="/js/angular/1.5.3/angular-messages.min.js"></script>
<script src="/js/angular_material/1.1.1/angular-material.min.js"></script>

<link rel="stylesheet" href="/css/Semantic-UI/2.1.8/semantic.min.css" />
<link rel="stylesheet" href="/js/angular_material/1.1.1/angular-material.min.css">

<script>
var app = angular.module('app', ['ngSanitize', 'ngMaterial']);

app.config(function ($compileProvider, $mdIconProvider, $mdThemingProvider, $locationProvider) {
    $compileProvider.debugInfoEnabled(false);
    $mdThemingProvider.theme('default').warnPalette('green');
    $locationProvider.html5Mode(false);
});
</script>
</head>

<body ng-cloak>
    <md-content layout="column" layout-padding layout-align="start center" style="min-height:100%">
        <md-card style="width:800px">
            <?=$child_head?>
            <md-card-title>
                <md-card-title-text>
                <span class="md-headline">行政院科技部補助專題研究案</span>
                <p  class="md-headline">&lceil;<?=$doc->title?>&rfloor;</p>
                <p>計畫主持人：國立臺灣師範大學教育學系教授 王麗雲</p>
                <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
                </md-card-title-text>
            </md-card-title>
            <md-card-content>
                <?=$child_body?>
            </md-card-content>
        </md-card>
    </md-content>
    <md-content layout-align="start center">
        <div style="float:left;width:250px"><img class="ui centered image" src="/resource/<?=$doc->dir?>/images/1.png"></div>
        <div style="float:left;width:250px"><img class="ui centered image" src="/resource/<?=$doc->dir?>/images/2.png"></div>
        <div style="float:left;width:250px"><img class="ui centered image" src="/resource/<?=$doc->dir?>/images/3.jpg"></div>
    </md-content>
</body>
</html>