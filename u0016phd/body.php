
<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="eight wide field">
		<label>學號</label>
		<input type="text" ng-model="stdnumber" placeholder="學號" />
    </div>
	<div class="five wide field">
		<label>身分證字號末五碼</label>
		<input type="text" ng-model="stdidnumber_last5" placeholder="" maxlength="5" />
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
        $http({method: 'POST', url: '<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, stdnumber: $scope.stdnumber, stdidnumber_last5: $scope.stdidnumber_last5}})
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