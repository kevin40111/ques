
<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="field">
        <label>請選擇學校所屬縣市</label>
        <select ng-model="city_code" ng-change="getSchools()">
            <option value="">請選擇縣市</option>
            <option ng-repeat="city in citys" ng-value="city.code">{{city.name}}</option>
        </select>
    </div>
    <div class="disabled field" ng-class="{disabled: loading}">
        <label>請選擇學校</label>
        <select ng-model="school_id">
            <option value="">請選擇學校</option>
            <option ng-repeat="school in schools" ng-value="school.id">{{school.name}}</option>
        </select>
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

    $scope.schools = [];
    $scope.loading = true;

    $http({method: 'POST', url: 'wish_junior/public/citys', data:{}})
    .success(function(data, status, headers, config) {
        $scope.citys = data.citys;
        $scope.loading = false;
    }).error(function(e) {
        console.log(e);
    });

    $scope.getSchools = function() {
        $scope.school_id = '';
        $scope.loading = true;
        $http({method: 'POST', url: 'wish_junior/public/schools', data:{city_code: $scope.city_code}})
        .success(function(data, status, headers, config) {
            $scope.schools = data.schools;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.login = function() {
        $scope.loading = true;
        $http({method: 'POST', url: 'wish_junior/qlogin', data:{school_id: $scope.school_id, _token: CSRF_TOKEN}})
        .success(function(data, status, headers, config) {
            console.log(data);
            if (data.errors) {
                $scope.errors = data.errors;
                $scope.loading = false;
            } else {
                window.location = 'wish_junior/page';
            }
        }).error(function(e) {
            console.log(e);
        });
    };
});
</script>