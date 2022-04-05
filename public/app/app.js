
// Mr Optimist 5 April 2022
//var app = angular.module('ktown', ['ngMaterial','datatables','ngPatternRestrict', 'ngMessages', 'ngSanitize', 'angularUtils.directives.dirPagination'])

var app = angular.module('ktown', ['ngMaterial','datatables','datatables.buttons','ngPatternRestrict', 'ngMessages', 'ngSanitize', 'angularUtils.directives.dirPagination'])
    // .config(function ($mdThemingProvider) {
    //     $mdThemingProvider.theme('default')
    //         .primaryPalette('blue')
    //         .accentPalette('blue');
    //     // .warnPalette('red')
    //     // .backgroundPalette('blue');
    // })


.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})


.factory('ajaxService', function($http, $q) {
    return {
        GetPromise: function(url, data, baseScope, isBackground) {
            if (isBackground !== true) {
                baseScope.activeService++;
            }
            url = site_url(url)
            return this.CreatePromise(url, data, baseScope, isBackground);
        },
        PostPromise: function(url, data, baseScope, isBackground) {
            if (isBackground !== true)
                baseScope.activeService++;
            url = site_url(url);
            return this.CreatePromise(url, data, baseScope, isBackground, 'Post');
        },
        CreatePromise: function(url, data, baseScope, isBackground, type) {
            var deferred = $q.defer();
            var promise;
            if (type == 'Post')
                promise = $http.post(url, $.param(data), { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } });
            else
                promise = $http.get(url, { params: data });

            promise.then(
                function(response) {
                    if (isBackground !== true) {
                        baseScope.activeService--;

                        if (!response.data.success && response.data.errors) {
                            baseScope.errors = response.data.errors;
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth',
                            })
                            HideLoader();
                            return;
                        }

                        if (response.data.msgtype == undefined) {
                            HideLoader();
                            return;
                        }

                        if (response.data.msgtype == 'success') {
                            response.data.message.forEach((msg) => {
                                toastr.success(msg);
                            })
                            baseScope.successMsg = response.data.message;
                        } else {
                            response.data.message.forEach((msg) => {
                                toastr.error(msg);
                            })
                            baseScope.dangerMsg = response.data.message;
                        }


                    }

                    //errors: array of arrays
                    if (response.data.errors) {
                        baseScope.errors = response.data.errors;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth',
                        })

                    }

                    HideLoader();
                    deferred.resolve(response.data);

                },
                function(response) {
                    if (response.status == 403) {
                        toastr.error("You are not allowed to perform this operation. Access denied!")
                    }

                    if (isBackground !== true) {
                        baseScope.activeService--;

                        if (response.data.errors) {
                            baseScope.errors = response.data.errors;
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth',
                            })

                        }
                    }
                    //deferred.reject(response);
                    HideLoader();
                    deferred.resolve(response.data);
                }
            )

            return deferred.promise;
        }
    }
})

.factory('urlService', function() {
        var LocalServiceUrl = '/';
        return {
            compose: function(url) {
                return LocalServiceUrl + url;
            },
            getUrlParams: function() {
                // This function is anonymous, is executed immediately and 
                // the return value is assigned to QueryString!
                var query_string = {};
                var query = window.location.search.substring(1);

                if (query == '') {
                    return {};
                }

                var vars = query.split("&");
                for (var i = 0; i < vars.length; i++) {
                    var pair = vars[i].split("=");

                    //skip the autologin token
                    if (pair[0] == 'token')
                        return;

                    // If first entry with this name
                    if (typeof query_string[pair[0]] === "undefined") {
                        query_string[pair[0]] = decodeURIComponent(pair[1]);
                        // If second entry with this name
                    } else if (typeof query_string[pair[0]] === "string") {
                        var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
                        query_string[pair[0]] = arr;
                        // If third or later entry with this name
                    } else {
                        query_string[pair[0]].push(decodeURIComponent(pair[1]));
                    }
                }
                return query_string;
            }
        }
    })
    .directive('currency', ['$filter', function($filter) {
        return {
            require: 'ngModel',
            link: function(elem, $scope, attrs, ngModel) {
                ngModel.$formatters.push(function(val) {
                    return $filter('currency')(val, '', 2)
                });
                ngModel.$parsers.push(function(val) {
                    return val.replace(/[\$,]/, '')
                });
            }
        }
    }])
    .directive('date', ['$filter', function($filter) {
        return {
            require: 'ngModel',
            link: function(elem, $scope, attrs, ngModel) {
                // when received from server
                ngModel.$formatters.push(function(val) {
                    return $filter('date')(val, 'M/d/yyyy')
                });
                // when sent to server
                ngModel.$parsers.push(function(val) {
                    return $filter('date')(val, 'yyyy-M-d')
                });
            }
        }
    }])
    .directive('number', ['$filter', function($filter) {
        return {
            require: 'ngModel',
            link: function(elem, $scope, attrs, ngModel) {
                ngModel.$formatters.push(function(val) {
                    return $filter('number')(val, '', 2)
                });

                ngModel.$parsers.push(function(val) {
                    return val.replace(/[\$,]/, '')
                });
            }
        }
    }])
    .directive('confirmOnExit', [function() {
        return {
            link: function($scope, elem, attrs) {
                window.onbeforeunload = function() {
                    if ($scope.myForm.$dirty) {

                        return "Hello testing";
                    }
                }
                $scope.$on('$locationChangeStart', function(event, next, current) {
                    if ($scope.myForm.$dirty) {
                        if (!confirm("The form is dirty, do you want to stay on the page?")) {
                            event.preventDefault();
                        }
                    }
                });
            }
        }
    }]).directive('ngFiles', ['$parse', function($parse) {

        function file_links(scope, element, attrs) {
            var onChange = $parse(attrs.ngFiles);
            element.on('change', function(event) {
                onChange(scope, { $files: event.target.files });
            });
        }

        return {
            link: file_links
        }
    }])
    .directive("imgUpload", function($http, $compile) {
        return {
            template: '<input class="fileUpload" type="file" multiple />' +
                '<div class="droppzone">' +
                '<p class="msg text-muted"><i class="fa fa-plus"></i></p>' +
                '</div>' +
                '<div class="preview clearfix">' +
                '<div class="previewData clearfix" ng-repeat="data in previewData track by $index">' +
                '<div class="imgbx"><img ng-src={{data.src}}></img></div>' +
                '<div class="previewDetails">' +
                '<div class="detail"><b>Name : </b>{{data.name}}</div>' +
                '</div>' +
                '<div class="previewControls">' +
                '<span ng-click="upload(data)" class="circle upload">' +
                '<i class="fa fa-check"></i>' +
                '</span>' +
                '<span ng-click="remove(data)" class="circle remove">' +
                '<i class="fa fa-close"></i>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '</div>',
            link: function($scope, elem) {
                var formData = new FormData();
                $scope.previewData = [];

                function previewFile(file) {
                    var reader = new FileReader();
                    var obj = new FormData().append('file', file);
                    reader.onload = function(data) {
                        var src = data.target.result;
                        // console.log(src);
                        var size = ((file.size / (1024 * 1024)) > 1) ? (file.size / (1024 * 1024)) + ' mB' : (file.size / 1024) + ' kB';
                        $scope.$apply(function() {
                            $scope.previewData.push({
                                'name': file.name,
                                'size': size,
                                'type': file.type,
                                'src': src,
                            });
                        });
                        console.log($scope.previewData);
                    }
                    reader.readAsDataURL(file);
                }

                function uploadFile(e, type) {
                    e.preventDefault();
                    var files = "";
                    if (type == "formControl") {
                        files = e.target.files;
                    } else if (type === "drop") {
                        files = e.originalEvent.dataTransfer.files;
                    }
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        if (file.type.indexOf("image") !== -1) {
                            previewFile(file);
                        } else {
                            alert(file.name + " is not supported");
                        }
                    }
                }
                elem.find('.fileUpload').bind('change', function(e) {
                    uploadFile(e, 'formControl');
                });

                elem.find('.droppzone').bind("click", function(e) {
                    $compile(elem.find('.fileUpload'))($scope).trigger('click');
                });

                elem.find('.droppzone').bind("dragover", function(e) {
                    e.preventDefault();
                });

                elem.find('.droppzone').bind("drop", function(e) {
                    uploadFile(e, 'drop');
                });

                $scope.upload = function(obj) {
                    data = {};
                    $scope.ajaxPost('saveImages', { data: obj }, false).then(function(response) {


                    }).catch(function(e) {
                        console.log(e);
                    });
                }

                $scope.remove = function(data) {
                    var index = $scope.previewData.indexOf(data);
                    $scope.previewData.splice(index, 1);
                    console.log($scope.previewData);
                }
            }
        }
    })
    .filter('camelCase', function() {
        var camelCaseFilter = function(input) {
            if (input == undefined || input == '' || input == null)
                return '';
            var words = input.split(' ');
            for (var i = 0, len = words.length; i < len; i++)
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
            return words.join(' ');
        };
        return camelCaseFilter;
    })
    .controller('baseCtrl', function($scope, $rootScope, ajaxService, $location) {
        $scope.loc = $location;
        $rootScope.loadHousekeeping = function(booking_id, room_id) {
            $rootScope.bookingId = booking_id;
            $rootScope.roomId = room_id;

            $rootScope.$broadcast('service_modal', 'init');
        }


        $scope.showToast = function(msg) {
            $("#error_msg").html(msg);
            $("#error_msg").parent().removeClass('d-none');

            setTimeout(() => {
                $("#error_msg").parent().addClass('d-none');
            }, 2000);
        }
        $scope.color_range = [{
                rangefrom: 100,
                rangeto: 100,
                color: "#4caf50"
            },
            {
                rangefrom: 60,
                rangeto: 99,
                color: "#82b43a"
            },
            {
                rangefrom: 36,
                rangeto: 59,
                color: "#a6b82c"
            },
            {
                rangefrom: 11,
                rangeto: 35,
                color: "#f99922"
            },
            {
                rangefrom: 5,
                rangeto: 10,
                color: "#f6852f"
            },
            {
                rangefrom: 3,
                rangeto: 4,
                color: "#f3713c"
            },
            {
                rangefrom: 0,
                rangeto: 2,
                color: "#ef5350"
            }
        ]
        $scope.getcolorCode = function(total, number) {
            let range = Math.round(number * (100) / total);
            abc = $scope.color_range.filter((cr) => cr.rangefrom <= range && cr.rangeto >= range);
            // console.log(abc[0].color);
            return abc[0].color;
        }



        $scope.activeService = 0;
        $scope.ajaxGet = function(url, data, isBackground) {
            ShowLoader();
            return ajaxService.GetPromise(url, data, $scope, isBackground);
        }
        $scope.ajaxPost = function(url, data, isBackground, headers) {
            ShowLoader();
            $scope.successMsg = null;
            $scope.dangerMsg = null;
            $scope.errors = null;
            return ajaxService.PostPromise(url, data, $scope, isBackground, headers);
        }
        $scope.colVis = [];
        $scope.getStates = function() {
            $scope.ajaxGet('getStates', {}, true)
                .then(function(response) {
                    if (response.success) {
                        $scope.statesddl = response.payload;
                    }
                })
        }

        $scope.applyMasking = function() {
            setTimeout(() => {
                $('.cardnumber').mask('0000 0000 0000 0000');
                $('.cvc').mask('0000');
                $('.expiry_date').mask('00/00');
                $('.chequenumber').mask('0000000000000000000000000');
            }, 100);
        }

        // $scope.toggleColumns = function (index) {

        //     $('.ColVis_MasterButton').click();
        //     $('.ColVis_collection li :checkbox').eq(index).click();
        //     //$scope.dtColumnDefs[0].visible = false;
        //     //$scope.dtColumnDefs[index].setVisible(false);

        // }
        // setTimeout(() => {
        //     $('.ColVis_MasterButton').click();
        //     storageName = dUrl + location.pathname;
        //     storage = localStorage.getItem(storageName);
        //     if (storage == null) {
        //         for (let index = 0; index < 3; index++) {
        //             storageName = dUrl.replace('_0_', '_' + (index + 1) + '_') + location.pathname;
        //             storage = localStorage.getItem(storageName);
        //             if (storage != null)
        //                 break;
        //         }
        //     }
        //     if (storage != null) {
        //         sJson = $.parseJSON(storage);
        //         sJson.columns.forEach(function (value, index) {
        //             $scope.colVis[index] = value.visible;
        //         })

        //         $scope.$apply();
        //     }

        // }, 700);
    });


toastr.options = {

    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}