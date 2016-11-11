
<form ng-controller="loginController" class="ui form" ng-class="{error: errors}">
    <div class="field">
        <label>請選擇學校</label>
        <select name="school" ng-model="school_code" ng-change="getDepartments()">
            <option value="">請選擇學校</option>
            <option ng-repeat="school in schools" ng-value="school.code">{{school.name}}</option>
        </select>
    </div>
    <div class="disabled field" ng-class="{disabled: loading}">
        <label>請選擇系所</label>
        <select name="department" ng-model="department_id">
            <option value="">請選擇系所</option>
            <option ng-repeat="department in departments" ng-value="department.id">{{department.name}}</option>
        </select>
    </div>
    <div class="field">
        <label>請輸入身分證末四碼<br/></label>
        <input type="text" ng-model="id4" placeholder="請輸入身分證後四碼">

    </div>
    <div class="field">
        為什麼要填身分證末四碼？<br/>
        若您未於本次填寫完畢，下次可重新登入身分證後四碼，繼續填寫未完成之題項，而您所填寫的資料將不會做其他用途。請正確填寫身份證後四碼，以免與他人資料混淆，或您可選擇不填寫直接登入本系統。
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

    $http({method: 'POST', url: 'adulthood/public/schools', data:{} })
    .success(function(data, status, headers, config) {
        $scope.schools = data.schools;
        $scope.loading = false;
    }).error(function(e) {
        console.log(e);
    });

    $scope.getDepartments = function() {
        $scope.loading = true;
        $http({method: 'POST', url: 'adulthood/public/departments', data:{school_code: $scope.school_code}})
        .success(function(data, status, headers, config) {
            $scope.departments = data.departments;
            $scope.loading = false;
        }).error(function(e) {
            console.log(e);
        });
    };

    $scope.login = function() {
        $scope.loading = true;
        $http({method: 'POST', url: 'adulthood/qlogin', data:{department_id: $scope.department_id, id4: $scope.id4, _token: CSRF_TOKEN}})
        .success(function(data, status, headers, config) {
            console.log(data);
            if (data.errors) {
                $scope.errors = data.errors;
                $scope.loading = false;
            } else {
                window.location = 'adulthood/page';
            }
        }).error(function(e) {
            console.log(e);
        });
    };
});
</script>