app.controller('purchaseorderCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.products = [];
    $scope.formType = "";
    $scope.errors = [];
    $scope.purchase_order = {};
    $scope.searchTitle = "";
    $scope.searchRate = "";
    $scope.searchHotel = "";
    $scope.searchDescription = "";
    $scope.purchase_order.gTotal = 0;

    // $scope.addmoreproductbtn = true;

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0'<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {
        $scope.getPurchaseOrders();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getPurchaseOrders = function(searchFields = {}) {
        $scope.ajaxPost('getPurchaseOrders', searchFields, true)
            .then(function(response) {
                $scope.purchase_orders = response.purchase_orders;
                // for dropdown
                $scope.hotels = response.hotels;
                $scope.inventories = response.inventories;
                $scope.vendors = response.vendors;
            })
            .catch(function(e) {

            })
    }

    $scope.createPurchaseOrder = function() {
        window.scrollTop();
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewPurchaseOrder').show('slow');
    }


    $scope.purchase_order.Status = "Pending";
    $scope.products = [{
        inventory_id: '',
        Description: '',
        quantity: 0,
        Rate: 0,
        Total: 0,
    }];



    $scope.addProduct = function() {

        $scope.purchase_orderForm.$setPristine();
        $scope.purchase_orderForm.$setUntouched();
        $scope.products.push({
            inventory_id: '',
            Description: '',
            quantity: 0,
            Rate: 0,
            Total: 0,
        });
        $('#add-more-product-btn').attr("disabled", true);
    }

    $scope.getProDetail = function(inv_id, inv, i) {
        console.log(i);
        $('#mySelect').attr("readonly", false);
        $scope.inventory = $scope.inventories.filter((i) => i.id == inv_id);
        console.log($scope.inventory);


        // populate values in td of selected dropdown row
        $scope.products[i].Total = 0;
        $scope.products[i].Quantity = 0;
        $scope.products[i].Description = $scope.inventory[0].Description;
        $scope.products[i].Rate = $scope.inventory[0].Rate;
        $scope.calculateGrandTotal();
    }


    $scope.calculateUnitPrice = function(pro_quan, i) {
        if (pro_quan != undefined) {
            pro_quan = parseInt(pro_quan);
            if (pro_quan > 0)
                $('#add-more-product-btn').attr("disabled", false);
        } else {
            $('#add-more-product-btn').attr("disabled", true);
        }
        $scope.products[i].quantity = parseInt(pro_quan);
        // $scope.products[i].Rate = parseInt($scope.inventory[0].Rate);
        $scope.products[i].Total = parseInt($scope.products[i].quantity) * parseInt($scope.products[i].Rate);

        $scope.calculateGrandTotal();
    }

    $scope.calculateGrandTotal = function() {
        gTotal = 0;
        $scope.products.forEach(element => {
            console.log(element);
            gTotal += parseInt(element.Total);
        });
        $scope.purchase_order.gTotal = gTotal;
    }

    $scope.savePurchaseOrder = function() {
        $scope.purchase_orderForm.$submitted = true;
        if (!$scope.purchase_orderForm.$valid) {
            window.scrollTop();
            return;
        }
        $scope.purchase_order.products = [];
        $scope.purchase_order.products.push($scope.products);

        console.log($scope.purchase_order);

        $scope.purchase_order.purchase_date = moment($scope.purchase_order.purchase_date).format("YYYY-MM-DD");

        let formUrl = $scope.formType == "save" ? 'PurchaseOrder' : 'PurchaseOrder/' + $scope.purchase_order.id;

        $scope.ajaxPost(formUrl, {
                purchase_order: $scope.purchase_order
            }, false)
            .then(function(response) {
                if (response.success) {}
            }).catch(function(e) {
                console.log(response);
            })
    }


    $scope.showPoDetail = function(po) {
        $scope.pod = angular.copy(po);
        console.log($scope.pod);
        $("#poDetail").modal();
    }


    $scope.editPurchaseOrder = function(p) {
        console.log(p);
        delete p.hotel;
        delete p.vendor;
        $scope.purchase_order = angular.copy(p);
        $scope.purchase_order.purchase_date = moment($scope.purchase_order.purchase_date).format("YYYY-MM-DD");
        $scope.products = $scope.purchase_order.details;
        window.scrollTop();
        $("#demo2").addClass('show');
        $scope.formType = "edit";
        window.scrollTop();
        $('#addNewPurchaseOrder').show('slow');
    }

});