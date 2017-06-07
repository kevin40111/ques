<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="eight wide field">
        <label>請選擇就讀學校：</label>
        <select ng-model="sch_name" ng-change="getDeparment()">
            <option value="">請選擇學校</option>
            <option ng-repeat="school in schools" ng-value="school.sch_id">{{school.sch_name}}</option>
        </select>

        <label>請選擇科別：</label>
        <select ng-model="department_name">
            <option value="">請選擇科別</option>
            <option ng-repeat="department in departments" ng-value="department.department_id">{{department.department_name}}</option>
        </select>

        <label>請輸入身分證字號末五碼：</label>
        <input type="text" ng-model="stu_id" placeholder="身分證字號末五碼" />
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
    $scope.sch_name = '';
    $scope.department_name = '';

    $scope.stu_id = '';

    $scope.getSchools = function() {
        $scope.school_id = '';
        $scope.loading = true;
        $http({method: 'POST', url: 'grad104p1edu/public/schools', data:{}})
        .success(function(data, status, headers, config) {
            $scope.schools = data.schools;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.getSchools();

    $scope.getDeparment = function() {
        $scope.school_id = '';
        $scope.loading = true;
        $http({method: 'POST', url: 'grad104p1edu/public/departments', data:{sch_name: $scope.sch_name}})
        .success(function(data, status, headers, config) {
            $scope.departments = data.departments;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.login = function() {
        if (!$scope.sch_name) {
            $mdToast.show(
                $mdToast.simple()
                .textContent('學校未選擇!')
                .hideDelay(1000)
            );
        } else if (!$scope.department_name) {
            $mdToast.show(
                $mdToast.simple()
                .textContent('科別未選擇!')
                .hideDelay(1000)
            );
        } else if ($scope.stu_id == '') {
            $mdToast.show(
                $mdToast.simple()
                .textContent('未輸入身分證字號末五碼!')
                .hideDelay(1000)
            );
        } else {
            $http({method: 'POST', url: '/ques/<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, sch_name: $scope.sch_name, department_name: $scope.department_name , stu_id: $scope.stu_id}})
            .success(function(data, status, headers, config) {
                if (data.errors) {
                    $scope.errors = data.errors;
                } else {
                    window.location = '/ques/<?=$doc->dir?>/page';
                }
            }).error(function(e) {
                console.log(e);
            });
        }

    };
});
</script>