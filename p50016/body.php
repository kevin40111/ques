<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="eight wide field">
        <label>請選擇系所：</label>
        <select ng-model="department_name" ng-change="getDegree()">
            <option value="">請選擇系所</option>
            <option ng-repeat="department in departments" ng-value="department.department_name">{{department.department_name}}</option>
        </select>

        <label>請選擇學制：</label>
        <select ng-model="set_degree">
            <option value="">請選擇學制</option>
            <option ng-repeat="degree in degrees" ng-value="degree.degree">{{degree.degree}}</option>
        </select>

        <label>請輸入身分證字號末五碼：</label>
        <input type="text" ng-model="stdidnumber_last5" placeholder="身分證字號末五碼" />
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
app.controller('loginController', function($scope, $http, $location, CSRF_TOKEN, $q, $mdToast) {
    $scope.set_degree = '';
    $scope.department_name = '';
    $scope.recommend = window.location.search.slice(1).split('=')[1];
    $scope.stdidnumber_last5 = '';

    $scope.getDeparment = function() {
        $scope.loading = true;
        $http({method: 'POST', url: 'p50016/public/departments', data:{}})
        .success(function(data, status, headers, config) {
            $scope.departments = data.departments;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.getDeparment();

    $scope.getDegree = function() {
        $scope.loading = true;
        $http({method: 'POST', url: 'p50016/public/degrees', data:{department_name: $scope.department_name}})
        .success(function(data, status, headers, config) {
            $scope.degrees = data.degrees;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.login = function() {
        if (!$scope.department_name) {
            $mdToast.show(
                $mdToast.simple()
                .textContent('系所未選擇!')
                .hideDelay(1000)
            );
        } else if (!$scope.set_degree) {
            $mdToast.show(
                $mdToast.simple()
                .textContent('學制未選擇!')
                .hideDelay(1000)
            );
        } else if ($scope.stdidnumber_last5 == '') {
            $mdToast.show(
                $mdToast.simple()
                .textContent('未輸入身分證字號末五碼!')
                .hideDelay(1000)
            );
        } else {
            $http({method: 'POST', url: '/<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, department_name: $scope.department_name, set_degree: $scope.set_degree, stdidnumber_last5: $scope.stdidnumber_last5, recommend: $scope.recommend}})
            .success(function(data, status, headers, config) {
                if (data.errors) {
                    $scope.errors = data.errors;
                } else {
                    window.location = '/<?=$doc->dir?>/page';
                }
            }).error(function(e) {
                console.log(e);
            });
        }

    };
});
</script>