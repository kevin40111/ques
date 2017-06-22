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
                <p  class="md-headline"><?=$doc->title?></p>
                <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
                <h5 class="ui blue header"><早鳥好康><div class="sub header">每屆前50名填答者可獲100元超商禮券</div></h5>
                <h5 class="ui blue header"><推薦有賞><div class="sub header"> 每屆推薦連結超過3位的前10名可獲500元超商禮券</div></h5>
                <h5 class="ui blue header"><摸彩好禮> <div class="sub header"> 膠囊咖啡機、2TB行動硬碟、小米智慧手環、藍芽無線運動耳機、陽明小書包等豐富好禮等你試手氣!!!</div></h5>
                </md-card-title-text>
            </md-card-title>
            <md-card-content>
                <?=$child_body?>
            </md-card-content>
        </md-card>
    </md-content>
    <md-content layout-align="start center">
    </md-content>
</body>
</html>