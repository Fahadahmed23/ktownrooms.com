app.controller('goodsreceivenotesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.good_receive_notes = [];
    $scope.good_receive_note = {};
    $scope.formType = "";
    $scope.errors = [];

    $scope.searchTitle = "";
    $scope.searchRate = "";
    $scope.searchHotel = "";
    $scope.searchDescription = "";

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
        $scope.getGoodsReceiveNotes();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getGoodsReceiveNotes = function(searchFields = {}) {
        $scope.ajaxPost('getGoodsReceiveNotes', searchFields, true)
            .then(function(response) {
                $scope.user = response.user;
                $scope.is_admin = response.is_admin;
                $scope.goods_receive_notes = response.goods_receive_notes;
                // data format set
                for (let i = 0; i < $scope.goods_receive_notes; i++) {
                    $scope.goods_receive_notes[i].GRN_Date = moment($scope.goods_receive_notes[i].GRN_Date).format('YYYY-MM-DD');
                }


                // for dropdown
                $scope.purchase_orders = response.purchase_orders;
                $scope.inventories = response.inventories;
                $scope.hotels = response.hotels;
            })
            .catch(function(e) {
                // console.log(e);
            })
    }

    $scope.createGoodsReceiveNotes = function() {
        window.scrollTop();
        $scope.good_receive_noteForm.$setPristine();
        $scope.good_receive_noteForm.$setUntouched();
        $scope.good_receive_note = {};
        if (!$scope.is_admin) {
            $scope.good_receive_note.hotel_id = $scope.user.hotel_id;
        }
        $scope.formType = "save";
        window.scrollTop();
        var today = new Date();
        $scope.good_receive_note.GRN_Date = moment(today).format("YYYY-MM-DD");
        $('#addNewGoodReceiveNote').show('slow');
    }
    $scope.getHotel = function(hid) {
        $scope.purchase_orders = $scope.purchase_orders.filter((p) => p.hotel_id == hid);
    }

    $scope.getPurchaseOrderDetails = function(purchase_order_id) {
        $scope.po = angular.copy(Object.values($scope.purchase_orders).find(purchase_order => purchase_order.id == purchase_order_id));
        $("#demo2").addClass('show');
        console.log($scope.po);
        console.log($scope.po.details);
        $scope.products = $scope.po.details;
        console.log($scope.products);

        $scope.good_receive_note.gTotal = $scope.po.gTotal;
        $scope.good_receive_note.Status = $scope.po.Status;
    }

    $scope.calculateUnitPrice = function(pro_quan, i) {
        $scope.products[i].quantity = parseInt(pro_quan);
        $scope.products[i].Total = parseInt($scope.products[i].quantity) * parseInt($scope.products[i].Rate);
        console.log($scope.products[i].Total);
        $scope.calculateGrandTotal();
    }
    $scope.calculateGrandTotal = function() {
        gTotal = 0;
        $scope.products.forEach(element => {
            console.log(element);
            gTotal += parseInt(element.Total);
        });
        $scope.good_receive_note.gTotal = gTotal;
    }

    $scope.showgrnDetail = function(grn_id) {
        console.log(grn_id);

        // get purchase order detail of general note
        $scope.ajaxPost('po_grn/get', {
                id: grn_id
            }, true)
            .then(function(response) {
                if (response.success) {
                    console.log(response);
                    $scope.grn = response.grn
                    $("#grnDetail").modal();
                }
            })
            .catch(function(e) {
                console.log(e);
            })

    }

    $scope.saveGoodRecieve = function() {
        $scope.good_receive_noteForm.$submitted = true;
        if (!$scope.good_receive_noteForm.$valid) {
            window.scrollTop();
            return;
        }
        $scope.good_receive_note.products = [];
        $scope.a = Object.assign({}, $scope.products); // {0:"a", 1:"b", 2:"c"}
        console.log($scope.a);
        $scope.good_receive_note.products.push($scope.a);

        console.log($scope.good_receive_note);

        let formUrl = $scope.formType == "save" ? 'goods_receive_notes' : 'goods_receive_notes/' + $scope.good_receive_note.id;
        $scope.ajaxPost(formUrl, {
                good_receive_note: $scope.good_receive_note
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.init();
                }
            }).catch(function(e) {
                console.log(response);
            })
    }


    $scope.searchFilter = function(searchFields) {
        $scope.getInventories(searchFields);
    }

    $scope.revert = function() {
        $('#addNewGoodReceiveNote').hide('slow');
    }

    $scope.deleteGrn = function(grn) {
        console.log(grn);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + grn.GRN_Number + "?",
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
                $scope.ajaxPost('delete_gnr', { id: grn.id }, false).then(function(response) {
                    $scope.goods_receive_notes = $scope.goods_receive_notes.filter((g) => g.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        })

    }

});