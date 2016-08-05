<div ng-cloak ng-controller="loginController" class="ui form <?=($errors->isEmpty() ? '' : 'error')?>">

    <h4 class="ui dividing header"><?=$doc->title?></h4>

    <div class="ui message">
        <p>調查時間：<?=date("Y-m-d",strtotime($doc->start_at))?>~<?=date("Y-m-d",strtotime($doc->close_at))?></p>
    </div>

    <div class="field">    
        <label>建案/社區名稱：</label> 
        <select ng-model="community" name="community">
            <option ng-value="room" ng-repeat="room in (rooms | groupBy: 'community')">{{ room }}</option>
        </select>
    </div>

    <div class="field">    
        <label>地址：</label> 
        <select ng-model="address" name="address">
            <option ng-value="room" ng-repeat="room in (rooms | filter: {community: community} | groupBy: 'address')">{{ room }}</option>
        </select>
    </div>

    <div class="two fields">

        <div class="field">    
            <label>樓層：</label> 
            <select ng-model="floor" name="floor">
                <option ng-value="room" ng-repeat="room in (rooms | filter: {community: community, address: address} | groupBy: 'floor')">{{ room }}</option>
            </select>
        </div>

        <div class="field">    
            <label>門牌號碼：</label> 
            <select ng-model="doornumber" name="doornumber">
                <option ng-value="room" ng-repeat="room in (rooms | filter: {community: community, address: address, floor: floor} | groupBy: 'doornumber')">{{ room }}</option>
            </select>
        </div>

    </div>

    <div class="eight wide field">
        <label>登入代碼：</label>
        <input type="text" name="identity_id" placeholder="登入代碼" />
    </div>

    <div class="ui error message">
        <div class="header">資料錯誤</div>
        <p><?=implode('、', array_filter($errors->all()))?></p>
    </div>

    <div class="ui positive button" onclick="document.forms[0].submit()">登入</div>

</div>

<script>
app.controller('loginController', function($scope, $filter, $http) {
    $http({method: 'POST', url: '/kindom_app/public/rooms', data:{} })
    .success(function(data, status, headers, config) {
        $scope.rooms = data.rooms;
    }).error(function(e){
        console.log(e);
    });
})
.filter('groupBy', function () {
    var results = {};
    return function (data, key) {
        if (!(data && key)) return;

        var result;

        if (!this.$id) {
            result = {};
        } else {
            var scopeId = this.$id;
            if (!results[scopeId]) {
                results[scopeId] = {};
                this.$on("$destroy", function() {
                    delete results[scopeId];
                });
            }
            result = results[scopeId];
        }

        for (var i in data) {
            result[data[i][key]] = '';
        }

        return Object.keys(result);
    };
});
</script>