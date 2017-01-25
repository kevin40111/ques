
<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="eight wide field">
        <label>請輸入您的身份證字號：</label>
        <input type="text" ng-model="identity_id" placeholder="身分證字號" />
    </div>
    <div class="ui error message">
        <div class="header">資料錯誤</div>
        <div class="ui horizontal list">
        <span class="item" ng-repeat="error in errors">{{ error }}</span>
        </div>
    </div>
    <md-button class="md-raised md-primary" ng-click="login()">登入</md-button>
    <a style="margin-left:10px" target="_blank" href="<?=$doc->dir?>/qa">Q&A</a>
    <a style="margin-left:10px" target="_blank" href="<?=$doc->id?>/report">問題回報</a>
</from>

<script>
app.constant("CSRF_TOKEN", '<?=csrf_token()?>');
app.controller('loginController', function($scope, $http, $location, CSRF_TOKEN) {

    $scope.login = function() {
        $http({method: 'POST', url: '<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, identity_id: $scope.identity_id}})
        .success(function(data, status, headers, config) {
            if (data.errors) {
                $scope.errors = data.errors;
            } else {
               window.location = '<?=$doc->dir?>/page';
            }
        }).error(function(e) {
            console.log(e);
        });
    };
});
</script>