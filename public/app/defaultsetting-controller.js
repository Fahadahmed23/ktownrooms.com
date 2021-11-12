app.controller('adminDefaultCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables


    $scope.formType = "save";
    $scope.defaultSettingsKey = {};

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    //********************************** FUNCTIONS *******************************// 
    // $scope.TokenButton = function(context) {
    //     var ui = $.summernote.ui;
    //     var button = ui.button({
    //         className: 'note-btn-bold',
    //         contents: '<i class="icon-diamond"/> Insert Token',
    //         tooltip: 'Insert Token',
    //         click: function() {
    //             $('#InsertTokenModal').modal('show');
    //         }
    //     });

    //     return button.render(); // return button as jquery object
    // }

    $scope.init = function() {
        $scope.getDefaultSetting();
        $('#summernote_confirm,#summernote_cancel,#summernote_amendment,#summernote_checkin,#summernote_checkout,#summernote_reminder').summernote({
            toolbar: [
                ['mybuttons', ['btn']]
            ],
            buttons: {
                btn: TokenButton
            }
        });
    }

    $scope.tConvert = function(time) {
        if (time == undefined)
            return "";
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time.pop();
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }

    $scope.insertToken = function(token) {
        let module = $('#module').val()
        $('#summernote_' + module).summernote('insertText', token);
        $('#InsertTokenModal').modal('hide');
    }

    $scope.editKeys = function() {
        $scope.defaultSettingsKey.key_exist = false;
        $scope.defaultSettingsKey.client_key = null;
        $scope.defaultSettingsKey.secret_key = null;
    }

    $scope.getDefaultSetting = function() {
        $scope.ajaxGet('getDefaultSetting', {}, true)
            .then(function(response) {
                $scope.defaultSettingsForm = response.default_setting;

                $scope.defaultSettingsKey.client_key = response.default_setting.client_key;
                $scope.defaultSettingsKey.secret_key = response.default_setting.secret_key;
                $scope.defaultSettingsKey.key_exist = false;
                if ($scope.defaultSettingsKey.client_key && $scope.defaultSettingsKey.secret_key)
                    $scope.defaultSettingsKey.key_exist = true;

                delete $scope.defaultSettingsForm.client_key;
                delete $scope.defaultSettingsForm.secret_key;
                if ($scope.defaultSettingsForm.checkin_time) {
                    $scope.defaultSettingsForm.checkin_time = $scope.tConvert($scope.defaultSettingsForm.checkin_time)
                }

                if ($scope.defaultSettingsForm.checkout_time) {
                    $scope.defaultSettingsForm.checkout_time = $scope.tConvert($scope.defaultSettingsForm.checkout_time)
                }
                // $('#summernote_confirm').summernote('insertText', null);
                $('#summernote_confirm').summernote('insertText', $scope.defaultSettingsForm.confirm_message);
                $('#summernote_cancel').summernote('insertText', $scope.defaultSettingsForm.cancel_message);
                $('#summernote_amendment').summernote('insertText', $scope.defaultSettingsForm.amendment_message);
                $('#summernote_checkin').summernote('insertText', $scope.defaultSettingsForm.checkin_message);
                $('#summernote_checkout').summernote('insertText', $scope.defaultSettingsForm.checkout_message);
                $('#summernote_reminder').summernote('insertText', $scope.defaultSettingsForm.reminder_message);
                console.log(response);

            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.saveDefaultKeys = function() {
        $scope.ajaxPost('saveDefaultKeys', $scope.defaultSettingsKey, true).then(function(response) {
            if (response.success) {
                $scope.defaultSettingsKey.key_exist = true;
                $scope.defaultSettingsKey.client_key = response.default_rule.client_key;
                $scope.defaultSettingsKey.secret_key = response.default_rule.secret_key;
                toastr.success('Keys updated successfully');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }


    $scope.saveDefaultSetting = function() {
        $scope.myForm.$submitted = true;
        if (!$scope.myForm.$valid) {
            window.scrollTop();
            return;
        }
        if (!$scope.defaultSettingsForm.picture) {
            toastr.error("Please upload logo image!");
            return;
        }

        $scope.defaultSettingsForm.confirm_message = $($('#summernote_confirm').summernote('code')).text();
        $scope.defaultSettingsForm.cancel_message = $($('#summernote_cancel').summernote('code')).text();
        $scope.defaultSettingsForm.amendment_message = $($('#summernote_amendment').summernote('code')).text();
        $scope.defaultSettingsForm.checkin_message = $($('#summernote_checkin').summernote('code')).text();
        $scope.defaultSettingsForm.checkout_message = $($('#summernote_checkout').summernote('code')).text();
        $scope.defaultSettingsForm.reminder_message = $($('#summernote_reminder').summernote('code')).text();
        $scope.ajaxPost('saveDefaultSetting', $scope.defaultSettingsForm, true).then(function(response) {
            if (response.success) {
                toastr.success('Default settings updated successfully');
                // $scope.init();
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.clearPicture = function(s) {
        document.getElementById('fileLabel').innerHTML = "";
        if (s == "logo") {
            $scope.defaultSettingsForm.picture = null;
        } else {
            $scope.service.picture = null;
        }
    }


});