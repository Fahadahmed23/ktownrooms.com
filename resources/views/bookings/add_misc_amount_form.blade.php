<fieldset>
    <div class="form-group row" ng-hide="">
        <div class="col-lg-4">
            <label class="col-form-label">Name <span class="text-danger">*</span></label>
            <input aria-invalid="true"  ng-model="Addmislisoin.Name" type="text" placeholder="Name" class="form-control alphabets">
        </div>
        <div class="col-lg-4">
            <label class="col-form-label">Amount <span class="text-danger">*</span></label>
            <input aria-invalid="true"  ng-model="Addmislisoin.Amount" type="number" placeholder="1000" class="form-control">
        </div>
        <div class="col-lg-4">
        	<label class="col-form-label">Is BTC<span class="text-danger">*</span></label>
            <select name="is_complementary" id="is_complementary"  ng-model="Addmislisoin.is_complementary" class="form-control" aria-invalid="true">
                <option value="">Select an Option</option>
                <option value="1">Yes / True</option>
                <option value="0">No / False</option>
            </select>
        </div>
        <div class="col-lg-4">
        	<label class="col-form-label">Status<span class="text-danger">*</span></label>
            <select name="status" id="status"  ng-model="Addmislisoin.status" class="form-control" aria-invalid="true">
                <option value="">Select an Option</option>
                <option value="1">Yes / True</option>
                <option value="0">No / False</option>
            </select>
        </div>
    </div>
</fieldset>