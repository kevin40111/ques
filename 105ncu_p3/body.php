<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="eight wide field">
        <label>請選擇就讀科系：</label>
        <select ng-model="dep_name" ng-change="getDegrees()">
            <option value="">請選擇科系</option>
            <option ng-repeat="department in departments" ng-value="department.dep_name">{{department.department_name}}</option>
        </select>

        <label>請輸入身分證號碼：</label>
        <input type="text" ng-model="stu_id" placeholder="身分證號碼" />
        
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
    $scope.dep_name = '';
    $scope.stu_id = '';
    $scope.recommend = window.location.search.slice(1).split('=')[1];

    $scope.getDepartments = function() {
        //$scope.school_id = '';
        $scope.loading = true;
        $http({method: 'POST', url: '105ncu_p3/public/departments', data:{}})
        .success(function(data, status, headers, config) {
            $scope.departments = data.departments;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.getDepartments();

    $scope.login = function() {
        if (!$scope.dep_name) {
            $mdToast.show(
                $mdToast.simple()
                .textContent('科系未選擇!')
                .hideDelay(1000)
            );
        } else if ($scope.stu_id == '') {
            $mdToast.show(
                $mdToast.simple()
                .textContent('未輸入身分證字號!')
                .hideDelay(1000)
            );
        } else {
            $http({method: 'POST', url: '/<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, dep_name: $scope.dep_name, stu_id: $scope.stu_id, recommend: $scope.recommend}})
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