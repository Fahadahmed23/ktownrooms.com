<div id="EditColumnsAggregate" class="modal fade" tabindex="-1">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Aggregates</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>

         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th>Column</th>
                     <th>Aggregation</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-cloak ng-if="col.Type == 'number' || col.Type == 'amount'" ng-repeat="col in selectedColumnsP">
                     <td>[[col.Alias]]</td>
                     <td>
                        <select ng-model="col.Aggregation" class="form-control">
                           <option value="">None</option>
                           <option value="sum">sum</option>
                           <option value="min">minimum</option>
                           <option value="max">maximum</option>
                           <option value="avg">average</option>
                           <option value="count">count</option>
                        </select>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline bg-slate-600 text-slate-600 border-slate" ng-click="saveAggregates()">Save</button>
         </div>
      </div>
   </div>
</div>