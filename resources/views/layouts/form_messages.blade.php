<!-- display errors -->
<div class="alert alert-danger" ng-if="errors" ng-cloak>
	<button type="button" class="close" data-dismiss="alert" ng-model="errors" ng-click="refreshErrors()" aria-hidden="true">×</button>
    <ul ng-cloak ng-repeat="field in errors" style="margin-bottom:0">
        <!-- <li>[[field]]</li> -->
        <li ng-cloak ng-repeat="err in field">[[err]]</li>
    </ul>
</div>