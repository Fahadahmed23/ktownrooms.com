<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Promotion Id #</th>
                <th>Promotion Name</th>
                <th>Promotion Code</th>
                <th>Is Percentage</th>
                <th>Discount </th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="promotion in promotions | filter :{PromoName:searchName, Code:searchCode }" class="unread">
                <td style="display:none;">[[promotion.id]]</td>
                <td><span class="letter-icon-title text-default">[[promotion.PromoName]]</span></td>
                <td><span class="letter-icon-title text-default">[[promotion.Code]]</span></td>
                <td><span class="letter-icon-title text-default">[[promotion.IsPercentage == 1?'Yes':'No']]</span></td>
                <td><span class="letter-icon-title text-default">[[promotion.DiscountValue]][[promotion.IsPercentage == 1?'%':'']]</span></td>
                <td><span class="letter-icon-title text-default">[[promotion.ValidFrom | date]]</span></td>
                <td><span class="letter-icon-title text-default">[[promotion.ValidTo | date]]</span></td>
                
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-romotion" ng-click="editPromotion(promotion)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-romotion" ng-click="deletePromotion(promotion)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>