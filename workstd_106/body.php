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

        <label>您最近一次參與的建教合作機構名稱：</label>
        <md-autocomplete
          md-selected-item="organization_name"
          md-search-text="searchText"
          md-selected-item-change="getOrganization(searchText)"
          md-items="item in getOrganization(searchText)"
          md-item-text="item.organization_name"
          md-min-length="0"
          md-delay="500"
          md-no-cache
          placeholder="搜尋建教合作的機構">
        <md-item-template>


          <span md-highlight-text="searchText" md-highlight-flags="^i">{{item.organization_name}}</span>
        </md-item-template>
        <md-not-found>
          沒有找到與 "{{searchText}}" 相關的機構
        </md-not-found>

        </md-autocomplete>
        <div ng-show="test.length == 0">
            <label>若無搜尋結果，請直接輸入建教合作的機構：</label>
            <input type="text" ng-model="organization_name_add" placeholder="輸入建教合作的機構"/>
        </div>

        <label>請輸入學號：</label>
        <input type="text" ng-model="stu_id" placeholder="學號" />
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
    $scope.organization_name = '';
    $scope.organization_name_add = '';
    $scope.stu_id = '';
    $scope.test = '';

    $scope.getSchools = function() {
        $scope.school_id = '';
        $scope.loading = true;
        $http({method: 'POST', url: 'workstd_106/public/schools', data:{}})
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
        $http({method: 'POST', url: 'workstd_106/public/departments', data:{sch_name: $scope.sch_name}})
        .success(function(data, status, headers, config) {
            $scope.departments = data.departments;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.getOrganization = function(searchText) {
        $scope.school_id = '';
        $scope.loading = true;
        deferred = $q.defer();
        $http({method: 'POST', url: 'workstd_106/public/organizations', data:{searchText: searchText, sch_name: $scope.sch_name, department_name: $scope.department_name}})
        .success(function(data, status, headers, config) {
            deferred.resolve(data.organizations);
            $scope.test = data.organizations;
        }).error(function(e) {
            console.log(e);
        });
        return deferred.promise;
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
        } else if ($scope.organization_name_add == '' && $scope.organization_name == '') {
            $mdToast.show(
                $mdToast.simple()
                .textContent('未輸入合作機構!')
                .hideDelay(1000)
            );
        } else if ($scope.stu_id == '') {
            $mdToast.show(
                $mdToast.simple()
                .textContent('未輸入學號!')
                .hideDelay(1000)
            );
        } else {
            $scope.organization_name_login = $scope.test.length == 0 ? $scope.organization_name_add : $scope.organization_name['organization_name'];

            $http({method: 'POST', url: '/<?=$doc->dir?>/qlogin', data:{_token: CSRF_TOKEN, sch_name: $scope.sch_name, department_name: $scope.department_name , organization_name: $scope.organization_name_login, stu_id: $scope.stu_id}})
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