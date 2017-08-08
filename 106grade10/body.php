<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">

    <div class="eight wide field">
        <label>請輸入出生年月：</label>
        <md-input-container>
            <label>出生年</label>
            <md-select ng-model="year">
                <md-option ng-value="75">76以前</md-option>
                <md-option ng-repeat="year in years" ng-value="year">{{year}}</md-option>
            </md-select>
        </md-input-container>
        <md-input-container>
            <label>出生月</label>
            <md-select ng-model="month">
                <md-option ng-repeat="month in months" ng-value="month">{{month}}</md-option>
            </md-select>
        </md-input-container>
    </div>
    <div class="eight wide field">
        <label>請輸入身分證字號：</label>
        <input type="text" ng-model="identity_id" placeholder="身分證字號" />
    </div>
    <div class="ui error message">
        <div class="header">資料錯誤</div>
        <div class="ui horizontal list">
        <span class="item" ng-repeat="error in errors">{{ error }}</span>
        </div>
    </div>
    <div>
        <md-button class="md-raised md-primary" ng-click="login()">登入</md-button>
    </div>
</from>

<script>
app.constant("CSRF_TOKEN", '<?=csrf_token()?>');
app.controller('loginController', function($scope, $http, $location, CSRF_TOKEN) {
    $scope.years = [];
    $scope.months = [];
    for (i = 1; i <= 12; i += 1) {
        $scope.months.push(i);
    }
    for (i = 76; i <= 92; i += 1) {
        $scope.years.push(i);
    }
    $scope.login = function() {
        $http({method: 'POST', url: '/<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, identity_id: $scope.identity_id, year: $scope.year, month: $scope.month}})
        .success(function(data, status, headers, config) {
            if (data.errors) {
                $scope.errors = data.errors;
            } else {
                window.location = '/<?=$doc->dir?>/page';
            }
        }).error(function(e) {
            console.log(e);
        });
    };
});
</script>