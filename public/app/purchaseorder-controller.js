app.controller('purchaseorderCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.details = [];
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

    $scope.getPurchaseDate = function(purchase_date) {
        $scope.purchase_order.purchase_date = moment(purchase_date).format('MM/DD/YYYY');
    }

    $scope.getPurchaseOrders = function(searchFields = {}) {
        $scope.ajaxPost('getPurchaseOrders', searchFields, true)
            .then(function(response) {
                $scope.purchase_orders = response.purchase_orders;
                $scope.user = response.user;
                $scope.is_admin = response.is_admin;
                // for dropdown
                $scope.hotels = response.hotels;
                $scope.inventories = response.inventories;
                $scope.inventories.forEach(element => {
                    delete element.hotel;
                });
                $scope.vendors = response.vendors;
            })
            .catch(function(e) {

            })
    }

    $scope.createPurchaseOrder = function() {
        $scope.purchase_orderForm.$setPristine();
        $scope.purchase_orderForm.$setUntouched();
        window.scrollTop();
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewPurchaseOrder').show('slow');
        $scope.purchase_order = {};

        if (!$scope.is_admin) {
            $scope.purchase_order.hotel_id = $scope.user.hotel_id;
        }
        $scope.details = [{
            inventory_id: '',
            Description: '',
            quantity: 0,
            Rate: 0,
            Total: 0,
        }];
        $scope.purchase_order.Status = "Pending";
        $("#demo2").removeClass('show');
    }

    $scope.addProduct = function() {

        $scope.purchase_orderForm.$setPristine();
        $scope.purchase_orderForm.$setUntouched();
        $scope.details.push({
            inventory_id: '',
            Description: '',
            quantity: 0,
            Rate: 0,
            Total: 0,
        });
        $('#add-more-product-btn').attr("disabled", true);
    }

    $scope.getProDetail = function(inv_id, i) {
        console.log(i);
        $('#mySelect').attr("readonly", false);
        $scope.inventory = angular.copy(Object.values($scope.inventories).find(i => i.id == inv_id));
        console.log($scope.inventory);


        // populate values in td of selected dropdown row
        $scope.details[i].Total = 0;
        $scope.details[i].Quantity = 0;
        $scope.details[i].Description = $scope.inventory.Description;
        $scope.details[i].Rate = $scope.inventory.Rate;
        $scope.calculateGrandTotal();
    }


    $scope.calculateUnitPrice = function(pro_quan, i) {
        if (pro_quan != undefined) {
            pro_quan = parseInt(pro_quan);
            if (pro_quan > 0) {
                $('#add-more-product-btn').attr("disabled", false);
            } else {
                $('#add-more-product-btn').attr("disabled", true);
            }
        } else {
            $('#add-more-product-btn').attr("disabled", true);
        }
        $scope.details[i].quantity = parseInt(pro_quan);
        $scope.details[i].Total = parseInt($scope.details[i].quantity) * parseInt($scope.details[i].Rate);

        $scope.calculateGrandTotal();
    }

    $scope.calculateGrandTotal = function() {
        gTotal = 0;
        $scope.details.forEach(element => {
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
        $scope.purchase_order.details = [];
        $scope.purchase_order.details.push($scope.details);

        console.log($scope.purchase_order);

        let temp_purchase_order = angular.copy($scope.purchase_order);

        temp_purchase_order.purchase_date = moment(temp_purchase_order.purchase_date).format("YYYY-MM-DD");
        let formUrl = $scope.formType == "save" ? 'PurchaseOrder' : 'PurchaseOrder/' + temp_purchase_order.id;

        $scope.ajaxPost(formUrl, {
                purchase_order: temp_purchase_order
            }, false)
            .then(function(response) {
                console.log(response.purchase_order);
                if (response.success) {
                    $('#addNewPurchaseOrder').hide('slow');
                    $scope.init();
                    // $scope.purchase_orders.push(response.purchase_order);
                }
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
        $scope.details = $scope.purchase_order.details;
        console.log($scope.details);
        window.scrollTop();
        $("#demo2").addClass('show');
        $scope.formType = "edit";
        window.scrollTop();
        $('#addNewPurchaseOrder').show('slow');
        $('#add-more-product-btn').attr("disabled", false);
    }


    $scope.revert = function() {
        $('#addNewPurchaseOrder').hide('slow');
    }

    $scope.deletePurchaseOrder = function(p) {
        $('#addNewPurchaseOrder').hide('slow');
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + p.PurchaseOrderNumber + "?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-link'
                }
            },
            callback: function(result) {
                if (!result)
                    return;
                $scope.ajaxPost('delete_purchase_order', { id: p.id }, false).then(function(response) {
                    $scope.purchase_orders = $scope.purchase_orders.filter((p) => p.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        })

    }

    $scope.getPoStatus = function(s) {
        switch (s) {
            case 'Pending':
                return 'badge-warning';
            case 'Approved':
                return 'badge-success';
            case 'Rejected':
                return 'badge-danger';
        }
    }

});