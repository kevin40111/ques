
<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="eight wide field">
        <label>請輸入您的身份證字號：</label>
        <input type="text" ng-model="identity_id" placeholder="身分證字號" />
    </div>
    <div class="field">
        本問卷建議採用Google Chrome瀏覽器進行填答！
    </div>
    <div class="ui error message">
        <div class="header">資料錯誤</div>
        <div class="ui horizontal list">
        <span class="item" ng-repeat="error in errors">{{ error }}</span>
        </div>
    </div>
    <md-button class="md-raised md-primary" ng-click="login()">登入</md-button>
</from>

<script>
app.constant("CSRF_TOKEN", '<?=csrf_token()?>');
app.controller('loginController', function($scope, $http, $location, CSRF_TOKEN) {

    $scope.login = function() {
        $http({method: 'POST', url: '105grade11/qlogin', data:{_token: CSRF_TOKEN, identity_id: $scope.identity_id}})
        .success(function(data, status, headers, config) {
            if (data.errors) {
                $scope.errors = data.errors;
            } else {
               window.location = '105grade11/page';
            }
        }).error(function(e) {
            console.log(e);
        });
    };
});
</script>