app.controller('reportCtrl', function($scope, DTOptionsBuilder, urlService, $filter) {
    $('body').tooltip({
        selector: '.current-div1',
        trigger: 'hover'
    });


    $scope.currentPage = 1;
    $scope.pageSize = 100;
    $scope.TotalRecords = 0;

    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers').withOption('stateSave', true).withOption('lengthMenu', [100]);


    $scope.currentModule = localStorage.getItem("reportBackModule") == null ? 'Bookings' : localStorage.getItem("reportBackModule");
    window.localStorage.removeItem('reportBackModule');


    $scope.searchGroups = [
        [{ column: null, operator: null, value: null }]
    ];
    $scope.originalColumns = [];
    $scope.myReports = {};
    $scope.selectedColumns = [];
    $scope.originalGroupedColumns = [];
    $scope.groupedColumns = [];
    $scope.params = '';
    $scope.initialColumns = [];
    $scope.initialGroupedColumns = [];
    $scope.shareReportForm = {};
    $scope.shareReportForm.shareWith = true;
    $scope.shareReportForm.edit = false;
    $scope.getModules = function() {
        $scope.ajaxGet('getModules', {}, true)
            .then(function(response) {
                // console.log(response);
                $scope.modules = response;
            });
    }
    $scope.getRoles = function() {
        ShowLoaderTb();

        $scope.ajaxGet('getRoles', {}, true)
            .then(function(response) {
                // console.log(response);
                HideLoaderTb();
                $scope.roles = response.payload;
            });
    }


    $scope.getSavedReports = function() {
        window.localStorage.removeItem("url_previous");
        $('body').tooltip({
            selector: '.current-div1',
            trigger: 'hover'
        });
        $scope.getModules();
        $scope.getRoles();
        setTimeout(() => {

            $scope.ajaxGet('getSavedReports', {}, true)
                .then(function(response) {
                    $scope.myReports = response.reports;
                })
                // console.log($scope.modules);
        }, 500);
    }

    //refresh date after selecting timespan from dropdown
    $scope.refreshDate = function(colcriteria) {
        if (colcriteria.operator && colcriteria.operator != '==') {
            // if ($('#colInput').pickatime()) {
            //     $('#colInput').pickatime('picker').clear();
            // }

            // $('.pickadatereport').pickadate('picker').set({});
            colcriteria.value = '';
            setTimeout(() => {

                $('.pickadatereport').pickadate({
                    format: 'mm/dd/yyyy',
                    selectMonths: true,
                    selectYears: 80,
                });
                // $('.pickadatereport').val('');
            }, 500);
        }
    }


    $scope.check = function(colcriteria) {
        if (colcriteria.column.type == 'date') {
            // if ($('#colInput').pickatime()) {
            //     $('#colInput').pickatime('picker').clear();
            // }

            // $('.pickadatereport').pickadate('picker').set({});
            setTimeout(() => {

                $('.pickadatereport').pickadate({
                    format: 'mm/dd/yyyy',
                    selectMonths: true,
                    selectYears: 80,
                });
                // $('.pickadatereport').val('');
            }, 500);
        } else if (colcriteria.column.type == 'time') {
            // if ($('#colInput').pickadate()) {
            //     $('#colInput').pickadate('picker').stop();
            // }
            setTimeout(() => {
                // $('.pickatime').val('');
                $('.pickatime').pickatime({});
            }, 500);
        } else {
            if ($('#colInput').pickatime()) {
                if ($('#colInput').pickatime('picker') != undefined)
                    $('#colInput').pickatime('picker').stop();
            } else {
                if ($('#colInput').pickatime('picker') != undefined)
                    $('#colInput').pickadate('picker').stop();

            }
            // $('#colInput').pickadate('picker').stop();
        }
        if (event.type == 'click') {
            colcriteria.operator = '';
            colcriteria.value = '';
        }

    }

    $scope.loadConfigAndRunReport = function(report, previous_url = false) {
        // console.log('in loadConfigAndRunReport');
        // console.log($scope.urlParams);
        // console.log(report);
        // return;

        localStorage.setItem("selectedColumns" + report.report_name, report.columns);
        localStorage.setItem("searchGroups" + report.report_name, report.criteria);
        localStorage.setItem("groupedColumns" + report.report_name, report.grouped_columns);
        //localStorage.setItem("groupedColumns" + $scope.reportName, angular.toJson($scope.groupedColumns));//JSON.stringify($scope.selectedColumns) );
        if ($scope.urlParams)
            window.location.href = "report?" + $scope.urlParams;
        else {

            if (previous_url) {

                window.location.href = "report?module=" + report.module + "&title=" + report.name + "&report=" + report.report_name + "&previous_url=My%20Reports";
            } else {

                window.location.href = "report?module=" + report.module + "&title=" + report.name + "&report=" + report.report_name;
            }
        }

    }
    $scope.loadDynamicReport = function(report) {

        localStorage.setItem("url_previous", report.module.name);

        window.localStorage.removeItem("selectedColumns" + report.report_name);
        window.localStorage.removeItem("searchGroups" + report.report_name);
        window.localStorage.removeItem("groupedColumns" + report.report_name);
        if (report.columns)
            localStorage.setItem("selectedColumns" + report.report_name, report.columns);
        if (report.criteria)
            localStorage.setItem("searchGroups" + report.report_name, report.criteria);
        if (report.grouped_columns)
            localStorage.setItem("groupedColumns" + report.report_name, report.grouped_columns);
        //localStorage.setItem("groupedColumns" + $scope.reportName, angular.toJson($scope.groupedColumns));//JSON.stringify($scope.selectedColumns) );
        window.location.href = "criteria?module=" + report.module.name + "&title=" + report.name + "&report=" + report.report_name;
        // window.location.href = "report?module=" + report.module.name + "&report=" + report.report_name;

    }

    $scope.deleteReport = function(report) {

        bootbox.confirm({
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete ' + report.name + ' report?',
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
                if (result) {
                    $scope.ajaxPost('deleteReport', { report_id: report.id })
                        .then(function(response) {
                            // console.log(response);
                            if (!response.errors) {
                                $scope.getSavedReports();
                            }

                        })
                }
            }
        });

    }
    $scope.shareReportForm.edit = false;

    $scope.editReport = function(report) {

        $scope.shareReportForm.module_report = false;
        $scope.shareReportForm.edit = true;
        $scope.shareReportForm.name = report.name;

        $scope.shareReportForm.description = report.description;
        $scope.shareReportForm.report_name = report.report_name;
        $scope.shareReportForm.save_report_id = report.id;
        $('#shareReport').modal('show');

    }

    $scope.editSharedReport = function(report) {
        $scope.shareReportForm.module_report = true;
        $scope.shareReportForm.edit = true;
        $scope.shareReportForm.name = report.name;
        $scope.shareReportForm.description = report.description;
        $scope.shareReportForm.report_name = report.report_name;
        $scope.shareReportForm.save_report_id = report.id;
        $('#shareReport').modal('show');

    }

    $scope.moveReportForm = {};
    $scope.moveReport = function(report) {
        $scope.moveReportForm.save_report_id = report.id;
        $('#moveReport').modal('show');
    }

    $scope.moveReportConfig = function() {
        if ($scope.moveReportForm.module_id == undefined) {
            toastr.error('Module is required to share report.');
            return;
        }
        $scope.ajaxPost('moveReport', $scope.moveReportForm).then(function(response) {

            if (!response.errors) {
                $scope.moveReportForm = {};
                $scope.getModules();
                //toastr.success('Report Configuration saved successfully!.');
                $('#moveReport').modal('hide');
            }

        })

    }

    $scope.deleteSharedReport = function(report) {

        bootbox.confirm({
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete ' + report.name + ' report?',
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
                if (result) {
                    $scope.ajaxPost('deleteSharedReport', { report_id: report.id })
                        .then(function(response) {
                            // console.log(response);
                            if (!response.errors) {
                                $scope.getModules();
                            }

                        })
                }
            }
        });

    }

    $scope.activeModule = function(module_name) {
        // console.log(module_name);

        $scope.currentModule = module_name;
    }
    $scope.sortColumn = {}
    $scope.pagination = [{ page: 1 }];
    $scope.pageChanged = function(num) {

        $scope.pagination[0].page = num;
        $scope.ajaxParameters.pageSort = $scope.pagination;
        $scope.CustomPagingAndSort();

    };

    $scope.sort = function(col, order) {
        dir = 'asc';
        if (!order) {
            $scope.sortColumn[col.Name] = "sorting_asc";
        } else if (order == "sorting_asc") {
            $scope.sortColumn[col.Name] = "sorting_desc";
            dir = 'desc';
        } else {
            $scope.sortColumn[col.Name] = "sorting_asc";
        }
        $scope.pagination[0].colName = col.Name;
        $scope.pagination[0].direction = dir;
        //$scope.pagination["column"] = { name: col.Name, direction: dir };
        $scope.ajaxParameters.pageSort = $scope.pagination;
        $scope.resetSortSigns(col.Name);
        $scope.CustomPagingAndSort();

    }

    $scope.resetSortSigns = function(Name) {
        Object.keys($scope.sortColumn)
            .filter(function(k) { if (k != Name) $scope.sortColumn[k] = "sorting" })
    }


    $scope.refresh = function() {
        $scope.selectedColumnsP = angular.copy($scope.selectedColumns);
        $scope.groupedColumnsP = angular.copy($scope.groupedColumns);
    }

    $scope.init = function() {
        $scope.params = urlService.getUrlParams();
        $scope.reportName = $scope.params.report;
        $scope.title = $scope.params.title;
        $scope.module = $scope.params.module;
        $scope.urlParams = '?';
        for (const property in $scope.params) {
            $scope.urlParams = $scope.urlParams + property + "=" + $scope.params[property] + "&";
        }
        $scope.urlParams = $scope.urlParams.slice(0, -1); //remove ending &
        //console.log($scope.urlParams);
        $scope.ajaxGet('getReportColumns', $scope.params, true)
            .then(function(response) {

                $scope.initialColumns = Object.values(response.reportColumns).filter(function(obj) {
                    return true;
                }).map(function(obj) { return { Name: obj.name, Alias: obj.alias, Type: obj.type }; });
                $scope.initialGroupedColumns = Object.values(response.reportColumns).filter(function(obj) {
                    return obj.group; //group property defined then it means this column can be grouped
                }).map(function(obj) { return { Name: obj.name, Alias: obj.alias, Type: obj.type }; });

                $scope.datatypes = response.dataTypes;
                $scope.columns = response.reportColumns;
                //console.log(localStorage.getItem("selectedColumns" + $scope.reportName));
                var abc = $.parseJSON(localStorage.getItem("selectedColumns" + $scope.reportName));
                //console.log('abc');
                //console.log(abc);

                $scope.selectedColumns = Object.values(response.reportColumns).filter(function(obj) {
                    return obj.isDefault == "1"
                }).map(function(obj) { return { Name: obj.name, Alias: obj.alias, Type: obj.type, Aggregation: obj.aggregation }; });


                //console.log($scope.selectedColumns);


                $scope.originalColumns = Object.values(response.reportColumns).filter(function(obj) {
                    // return obj.isDefault == "0"
                    return true; //we want all columns to show in originalColumns
                }).map(function(obj) { return { Name: obj.name, Alias: obj.alias, Type: obj.type }; });

                if (abc !== null) {
                    $scope.selectedColumns = abc;
                    $scope.originalColumns = $scope.originalColumns.filter(function(value) {
                        return $scope.selectedColumns.filter(e => e.Name.toLowerCase() == value.Name.toLowerCase()).length !== 1;
                    });
                }

                $scope.groupedColumns = Object.values(response.reportColumns).filter(function(obj) {
                    return obj.group == "1";
                }).map(function(obj) { return { Name: obj.name, Alias: obj.alias, Type: obj.type }; });
                // console.log('groupedColumns');
                // console.log($scope.groupedColumns);

                $scope.originalGroupedColumns = Object.values(response.reportColumns).filter(function(obj) {
                    return obj.group; //group property defined then it means this column can be grouped
                }).map(function(obj) { return { Name: obj.name, Alias: obj.alias, Type: obj.type }; });
                // console.log('originalGroupedColumns');
                // console.log($scope.originalGroupedColumns);

                var groupedColumns = $.parseJSON(localStorage.getItem("groupedColumns" + $scope.reportName));
                if (groupedColumns !== null) {
                    $scope.groupedColumns = groupedColumns;

                    // console.log('groupedColumns');
                    // console.log($scope.groupedColumns);
                    $scope.originalGroupedColumns = $scope.originalGroupedColumns.filter(function(value) {
                        return $scope.groupedColumns.filter(e => e.Name.toLowerCase() == value.Name.toLowerCase()).length !== 1;
                    });

                }
                // console.log('groupedColumns');
                // console.log($scope.groupedColumns);
                //console.log($scope.originalGroupedColumns);

                //console.log($scope.selectedColumns);
                //console.log(localStorage.getItem("searchGroups" + $scope.reportName));
                var searchGroups = $.parseJSON(localStorage.getItem("searchGroups" + $scope.reportName));
                // var searchGroups = $.parseJSON(localStorage.getItem("searchGroups" + $scope.params.title ? $scope.params.title : $scope.params.report));
                if (searchGroups !== null) {
                    $scope.searchGroups = searchGroups;
                } else
                    $scope.searchGroups = Object.values(response.searchGroups);


                //$scope.selectedColumns = Object.values(response.reportColumns).map( function(obj){return obj.name;} );
                localStorage.setItem("selectedColumns" + $scope.reportName, JSON.stringify($scope.selectedColumns));
                //localStorage.setItem("originalColumns" + $scope.reportName, JSON.stringify($scope.originalColumns));
                localStorage.setItem("groupedColumns" + $scope.reportName, JSON.stringify($scope.groupedColumns));
                //localStorage.setItem("originalGroupedColumns" + $scope.reportName, JSON.stringify($scope.originalGroupedColumns));

                localStorage.setItem("searchGroups" + $scope.reportName, JSON.stringify($scope.searchGroups));

                $scope.originalColumns = $scope.originalColumns.filter(function(value) {
                    return $scope.selectedColumns.filter(e => e.Name.toLowerCase() == value.Name.toLowerCase()).length !== 1;
                });
                $scope.originalGroupedColumns = $scope.originalGroupedColumns.filter(function(value) {
                    return $scope.groupedColumns.filter(e => e.Name == value.Name).length !== 1;
                });

                DragAndDrop.init($scope);
                setTimeout(() => {
                    $('.pickadatereport').pickadate({
                        format: 'mm/dd/yyyy',
                        selectMonths: true,
                        selectYears: 80,
                    });
                    $('.pickatime').pickatime({});
                }, 500);

            })
    }



    $scope.addSearchGroup = function() {
        $scope.searchGroups.push([{ column: null, operator: null, value: null }]);
    }

    $scope.resetSearchGroup = function() {
        $scope.searchGroups = [
            [{ column: null, operator: null, value: null }]
        ];
        localStorage.setItem("searchGroups" + $scope.reportName, JSON.stringify($scope.searchGroups));
        $('#EditCriteria').modal('hide');
    }

    $scope.availablecolumnclick = function(alias, flag) {
        if (flag) {
            $('.previewSection input[name!="' + alias + '"]').hide();
            $('.previewSection span[name!="' + alias + '"]').show();
            $('.previewSection input[name="' + alias + '"]').show();
            $('.previewSection input[name="' + alias + '"]').focus();
            $('.previewSection span[name="' + alias + '"]').hide();
            this.col.Alias = $('input[name="' + alias + '"]').val();
        } else {
            $('.previewSection input[name="' + alias + '"]').hide();
            $('.previewSection span[name="' + alias + '"]').show();
            $('.previewSection input[name="' + alias + '"]').focus();
            this.col.Alias = $('.previewSection input[name="' + alias + '"]').val();
        }
        $scope.selectedColumns = angular.copy($scope.selectedColumnsP);
        //console.log($scope.selectedColumnsP);
        //$scope.saveSelectedCols();
    }

    $scope.addColumnCriteria = function(index) {

        for (let i = 0; i < $scope.searchGroups[index].length; i++) {
            const criteria = $scope.searchGroups[index][i];
            if (!criteria || !criteria.column || !criteria.operator || !criteria.value) {
                toastr.error("Populate empty criteria fields before adding new criteria!");
                return;
            }
        }

        $scope.searchGroups[index].push({ column: null, operator: null, value: null });
    }


    $scope.addSelectedColumn = function(column, target, source) {
        console.log(column, target);
        column = $.parseJSON(column);
        if (target == 'selected' && source == 'selected') {
            $scope.addSelectedColumnRefresh(target);
        } else if (target == 'selected') { //means move to selected columns
            for (let i = 0; i < $scope.originalColumns.length; i++) {
                const col1 = $scope.originalColumns[i];
                if (col1.Name == column.Name) {
                    $scope.originalColumns.splice(i, 1);
                    //$scope.selectedColumns.push({ Name: column.Name, Alias: column.Alias, Type: column.Type });
                    $scope.addSelectedColumnRefresh(target);
                    break;
                }
            }
        } else { //means move to available columns
            for (let i = 0; i < $scope.selectedColumns.length; i++) {
                const col1 = $scope.selectedColumns[i];
                if (col1.Name == column.Name) {
                    $scope.selectedColumns.splice(i, 1);
                    $scope.originalColumns.push({ Name: column.Name, Alias: column.Alias, Type: column.Type });
                    break;
                }
            }
        }

        console.log($scope.selectedColumns);
        console.log($scope.originalColumns);
        //$scope.$apply();
        //$scope.saveSelectedCols();
    }


    $scope.addGroupedColumn = function(column, target) {
        column = $.parseJSON(column);
        if (target == 'selected') { //means move to selected columns
            for (let i = 0; i < $scope.originalGroupedColumns.length; i++) {
                const col1 = $scope.originalGroupedColumns[i];
                if (col1.Name == column.Name) {
                    $scope.originalGroupedColumns.splice(i, 1);
                    $scope.groupedColumns.push({ Name: column.Name, Alias: column.Alias, Type: column.Type });
                    break;
                }
            }
        } else { //means move to available columns
            for (let i = 0; i < $scope.groupedColumns.length; i++) {
                const col1 = $scope.groupedColumns[i];
                if (col1.Name == column.Name) {
                    $scope.groupedColumns.splice(i, 1);
                    $scope.originalGroupedColumns.push({ Name: column.Name, Alias: column.Alias, Type: column.Type });
                    break;
                }
            }
        }
        //$scope.saveGroupedCols();
    }


    $scope.addSelectedColumnRefresh = function(target) {
        $scope.selectedColumns = [];
        $('#' + target).children().each(function() {
            column = $.parseJSON(this.id);
            $scope.selectedColumns.push(column);

        })
    }


    $scope.getSelectedColumns = function() {
        // $scope.$apply();
        // console.log($scope.selectedColumns);
        // console.log($scope.originalColumns);
    }

    $scope.getSelectedColumnsForAggregate = function() {
        // $scope.$apply();
        //console.log($scope.selectedColumns);
        //console.log($scope.originalColumns);
    }

    $scope.getGroupedColumns = function() {
        // $scope.$apply();
        //console.log($scope.groupedColumns);
        //console.log($scope.originalGroupedColumns);
    }

    $scope.saveSelectedCols = function() {

        localStorage.setItem("selectedColumns" + $scope.reportName, angular.toJson($scope.selectedColumnsP)); //JSON.stringify($scope.selectedColumns) );
        //$('#EditColumns').modal('hide');
    }

    $scope.saveGroupedCols = function() {

        localStorage.setItem("groupedColumns" + $scope.reportName, angular.toJson($scope.groupedColumns)); //JSON.stringify($scope.selectedColumns) );
        //console.log('in savedGroupedCols');
        //console.log($scope.groupedColumns);
        //$('#EditGroupedColumns').modal('hide');
    }

    $scope.loadCriteria = function() {
        angular.forEach($scope.searchGroups, function(searchGroup) {
            angular.forEach(searchGroup, function(value, option) {
                if (value['column']['type'] == 'number' || value['column']['type'] == 'float' || value['column']['type'] == 'amount' || value['column']['type'] == 'int') {
                    searchGroup[0]['value'] = parseFloat(searchGroup[0]['value']);
                }
            })
        })

        //   console.log($scope.searchGroups);

        localStorage.setItem("searchGroups" + $scope.reportName, JSON.stringify($scope.searchGroups));
        $('#EditCriteria').modal('hide');
    }

    $scope.saveAggregates = function() {
        $scope.selectedColumns = $scope.selectedColumnsP;
        //localStorage.setItem("selectedColumns" + $scope.reportName, JSON.stringify($scope.selectedColumnsP));
        $('#EditColumnsAggregate').modal('hide');
    }


    $scope.ajaxParameters = {};
    $scope.runReport = function() {
        $scope.first_time = true;
        $scope.params = urlService.getUrlParams();
        $scope.reportName = $scope.params.report;
        $scope.title = $scope.params.title;
        $scope.module = $scope.params.module;
        $scope.urlParams = '?';
        for (const property in $scope.params) {
            //if (property == "report" || property == "period")
            $scope.urlParams = $scope.urlParams + property + "=" + $scope.params[property] + "&";
        }
        $scope.urlParams = $scope.urlParams.slice(0, -1); //remove ending &
        //console.log($scope.urlParams);
        var defaultConfig = 1;

        if (document.referrer && (document.referrer.includes('criteria?') || document.referrer.includes('reports'))) {
            defaultConfig = 0; //use custom configuration
        } else if (localStorage.getItem("searchGroups" + $scope.reportName) != null && $scope.params.d != 1 && !document.referrer.includes('dashboard')) {
            defaultConfig = 0; //use custom configuration
        }
        if (defaultConfig == 0) {
            $scope.ajaxParameters = {
                report: $scope.params.report,
                defaultConfig: defaultConfig,
                searchGroups: localStorage.getItem("searchGroups" + $scope.reportName),
                period: $scope.params._period_ ? $scope.params._period_ : 'Month',
                selectedColumns: localStorage.getItem("selectedColumns" + $scope.reportName),
                groupedColumns: localStorage.getItem("groupedColumns" + $scope.reportName)
            }
            ShowLoaderTb();
            $scope.ajaxGet('getReport',
                    //{
                    $scope.ajaxParameters
                    // report: $scope.params.report,
                    // defaultConfig: defaultConfig,
                    // searchGroups: localStorage.getItem("searchGroups" + $scope.reportName),
                    // period: $scope.params._period_ ? $scope.params._period_ : 'Month',
                    // selectedColumns: localStorage.getItem("selectedColumns" + $scope.reportName),
                    // groupedColumns: localStorage.getItem("groupedColumns" + $scope.reportName)
                    //}
                    , true)
                .then(function(response) {
                    HideLoaderTb();
                    $scope.reportData = response.result;
                    if (response.result.length > 0)
                        $scope.TotalRecords = response.totalRecords;
                    $scope.reportCols = response.selectedColumns;
                });
        } else { //means default config is to be loaded from the constants
            //get the search criteria
            console.log('loading default config...');
            searchCriteria = []; //search attributes coming from query string params
            searchGroups = []; //search attributes coming from searchGroupsTemp
            criteria = [];
            counter = 0;
            for (const property in $scope.params) {
                if (property == "module" || property == "report" || property == "_period_" || property == "_year_" || property == "title" || property == "previous_url" || property == "d")
                    continue; //no need to process these query string params
                criteria[counter] = { column: property, value: $scope.params[property] };
                counter++;
            }
            searchCriteria[0] = criteria;
            //console.log('loading searchCriteriaTemp');
            //now check if searchGroupsTemp is defined in local storage. If yes then add to the searchCriteria
            searchCriteriaTemp = localStorage.getItem("searchGroupsTemp");
            // if ($scope.params.title == undefined) {
            //     if (searchCriteriaTemp) {
            //         //console.log('searchCriteriaTemp');
            //         //console.log(searchCriteriaTemp);
            //         searchGroups.push(searchCriteriaTemp);
            //         localStorage.removeItem("searchGroupsTemp");
            //     }
            // } else {
            //New way to retain search criteria coming from dashboard
            if ($scope.params.title) {
                if (searchCriteriaTemp) {
                    searchGroups.push(searchCriteriaTemp);
                    // localStorage.removeItem("searchGroupsTemp");
                } else
                    searchGroups.push(localStorage.getItem("searchGroups" + $scope.params.title));
                localStorage.setItem("searchGroups" + $scope.params.title, searchGroups);
            }
            // if (searchCriteriaTemp) {
            //     searchGroups = []; //search attributes coming from searchGroupsTemp

            //     //console.log('searchCriteriaTemp');
            //     //console.log(searchCriteriaTemp);
            //     searchGroups.push(searchCriteriaTemp);
            //     localStorage.removeItem("searchGroupsTemp");
            // } else {
            //     if ($scope.title == 'Overall Revenue Collection') {
            //         searchGroups = [];
            //     } else {

            //         searchGroups = localStorage.getItem("searchGroups" + $scope.params.title ? $scope.params.title : $scope.params.report);
            //     }
            //     // searchGroups = []; //search attributes coming from searchGroupsTemp
            //     // searchGroups.push(searchGroupsNew);

            // }
            //console.log(searchCriteria[0]);

            $scope.ajaxParameters = {
                defaultConfig: defaultConfig,
                report: $scope.params.report,
                period: $scope.params._period_ ? $scope.params._period_ : 'Month',
                searchCriteria: searchCriteria[0].length > 0 ? searchCriteria : null,
                searchGroups: searchGroups
            }
            ShowLoaderTb();
            $scope.ajaxGet('getReport',
                    // {
                    //     defaultConfig: defaultConfig,
                    //     report: $scope.params.report,
                    //     period: $scope.params._period_ ? $scope.params._period_ : 'Month',
                    //     searchCriteria: searchCriteria[0].length > 0 ? searchCriteria : null,
                    //     searchGroups: searchGroups
                    // }
                    $scope.ajaxParameters, true)
                .then(function(response) {
                    HideLoaderTb();
                    $scope.reportData = response.result;
                    $scope.TotalRecords = response.totalRecords;
                    // $scope.reportCols = Object.keys(response.selectedColumns);
                    $scope.reportCols = response.selectedColumns;

                    if (!response.searchGroups) {
                        response.searchGroups = [
                            []
                        ];
                    }
                    localStorage.setItem("searchGroups" + $scope.reportName, JSON.stringify(response.searchGroups));
                    localStorage.setItem("selectedColumns" + $scope.reportName, JSON.stringify(response.selectedColumns));
                    localStorage.setItem("groupedColumns" + $scope.reportName, JSON.stringify(response.groupedColumns));

                });
        }
        //console.log($scope.reportCols);
    }


    //Dracarys
    $scope.CustomPagingAndSort = function() {
        if ($scope.first_time) {
            $scope.first_time = false;
            return;
        }
        ShowLoaderTb();
        $scope.ajaxGet('getReport', $scope.ajaxParameters, true)
            .then(function(response) {
                HideLoaderTb();
                if ($scope.ajaxParameters.defaultConfig == 0) {
                    $scope.reportData = response.result;
                    if (response.result.length > 0)
                        $scope.TotalRecords = response.totalRecords;
                    $scope.reportCols = response.selectedColumns;
                } else {
                    $scope.reportData = response.result;
                    $scope.TotalRecords = response.totalRecords;
                    $scope.reportCols = response.selectedColumns;
                    if (!response.searchGroups) {
                        response.searchGroups = [
                            []
                        ];
                    }
                    localStorage.setItem("searchGroups" + $scope.reportName, JSON.stringify(response.searchGroups));
                    localStorage.setItem("selectedColumns" + $scope.reportName, JSON.stringify(response.selectedColumns));
                    localStorage.setItem("groupedColumns" + $scope.reportName, JSON.stringify(response.groupedColumns));
                }
            });
    }
    block = $('.card.admin-form-section');

    function ShowLoaderTb() {
        // if (first == false)
        //     return;





        $(block).block({
            message: '<span class="font-weight-semibold"><i class="icon-spinner4 spinner mr-2"></i>&nbsp; Fetching Data</span>',
            // timeout: 2000, //unblock after 2 seconds
            centerX: 0,
            centerY: 0,
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                width: 200,
                top: '15px',
                //left: '',
                right: '',
                left: '45%',
                border: 0,
                color: '#fff',
                //padding: 0,
                padding: '10px 15px',
                '-webkit-border-radius': 3,
                '-moz-border-radius': 3,
                backgroundColor: '#333'
            }
        });


    }

    function HideLoaderTb() {
        setTimeout(() => {
            block.unblock();
        }, 1300);


    }


    $scope.saveReportForm = {};
    //added by Shahmeer
    $scope.saveReportConfig = function() {
        $scope.saveReportForm.criteria = localStorage.getItem("searchGroups" + $scope.reportName);
        $scope.saveReportForm.columns = localStorage.getItem("selectedColumns" + $scope.reportName);
        $scope.saveReportForm.grouped_columns = localStorage.getItem("groupedColumns" + $scope.reportName);
        $scope.saveReportForm.module = $scope.module;
        $scope.saveReportForm.report_name = $scope.reportName;


        $scope.ajaxPost('saveReportConfig', $scope.saveReportForm).then(function(response) {

            if (!response.errors) {
                if (response.success) {
                    $scope.saveReportForm = {};
                    //toastr.success('Report Configuration saved successfully!.');
                    $('#SaveReport').modal('hide');
                }
            }

        })

    }

    $scope.openShareModal = function(report) {
        $scope.shareReportForm.edit = false;

        $scope.shareReportForm.name = report.name;
        $scope.shareReportForm.description = report.description;
        $scope.shareReportForm.report_name = report.report_name;
        $scope.shareReportForm.save_report_id = report.id;
        $('#shareReport').modal('show');

    }

    $scope.shareReportConfig = function() {
        if ($scope.shareReportForm.name == undefined || $scope.shareReportForm.name == null || $scope.shareReportForm.name == '') {
            toastr.error('Report name field is required to share report.');
            return;
        }
        if ($scope.shareReportForm.module_id == undefined) {
            toastr.error('Select your module to share report.');
            return;
        }
        $scope.shareReportForm.criteria = localStorage.getItem("searchGroups" + $scope.reportName);
        $scope.shareReportForm.columns = localStorage.getItem("selectedColumns" + $scope.reportName);
        $scope.shareReportForm.grouped_columns = localStorage.getItem("groupedColumns" + $scope.reportName);



        $scope.ajaxPost('shareReportConfig', $scope.shareReportForm).then(function(response) {

            if (!response.errors) {
                $scope.shareReportForm = {};
                $scope.getModules();
                //toastr.success('Report Configuration saved successfully!.');
                $('#shareReport').modal('hide');
            }

        })

    }

    $scope.editReportConfig = function() {

        $scope.ajaxPost('editReport', $scope.shareReportForm).then(function(response) {

            if (!response.errors) {
                if (response.success) {

                    $scope.shareReportForm = {};
                    $scope.getModules();
                    $scope.getSavedReports();
                    //toastr.success('Report Configuration saved successfully!.');
                    $('#shareReport').modal('hide');
                }
            }

        })

    }


    $scope.exportPdf = function() {
        // alert('in');
        $scope.pdfForm = {};
        $scope.pdfForm.criteria = localStorage.getItem("searchGroups" + $scope.reportName);
        $scope.pdfForm.columns = localStorage.getItem("selectedColumns" + $scope.reportName);
        $scope.pdfForm.grouped_columns = localStorage.getItem("groupedColumns" + $scope.reportName);
        $scope.pdfForm.module = $scope.module;
        $scope.pdfForm.report_name = $scope.reportName;

        $scope.ajaxPost('exportPdf', {
            report: $scope.params.report,
            title: $scope.params.title,
            defaultConfig: 0,
            searchGroups: localStorage.getItem("searchGroups" + $scope.reportName),
            period: $scope.params._period_ ? $scope.params._period_ : 'Month',
            selectedColumns: localStorage.getItem("selectedColumns" + $scope.reportName),
            groupedColumns: localStorage.getItem("groupedColumns" + $scope.reportName)
        }, true).then(function(response) {

            if (!response.errors)
                window.open('pdf/' + response.filename + '.pdf');
        });

    }

    $scope.renderValue = function(key, value) {
        //console.log(key);
        // console.log(value);
        for (let index = 0; index < $scope.reportCols.length; index++) {
            const col = $scope.reportCols[index];
            if (col.Alias == key) {
                if (col.Type == "amount") {
                    value = "<span class='float-right'>" + new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PKR', minimumFractionDigits: 2 }).format(value) + "</span>";
                    value = value.replace('PKR', 'Rs. ');

                } else if (col.Type == "number") {
                    value = new Intl.NumberFormat().format(value);
                } else if (col.Type == "date") {
                    if (!value) return '-';
                    //console.log($scope.params);
                    if ($scope.params._period_ && ($scope.params._period_ == 'Month' || $scope.params._period_ == 'Quarter'))
                        return value; //no change

                    value = moment(value).format("MM/DD/YYYY");
                    // value1 = new Date(value);
                    // value = new Intl.DateTimeFormat('en-US').format(value1);
                    // console.log(value);
                } else if (col.Type == "time") {

                    if (!value) return '-';
                    //console.log(col.Type);
                    if ($scope.params._period_ && ($scope.params._period_ == 'Month' || $scope.params._period_ == 'Quarter'))
                        return value; //no change
                    value = $scope.tConvert(value);
                    //console.log(value);
                }
            }

        }
        return value;
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

    $scope.convert12Hours = function(time) {
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }


    $scope.resetReport = function() {
        localStorage.removeItem("selectedColumns" + $scope.reportName);
        localStorage.removeItem("groupedColumns" + $scope.reportName);
        localStorage.removeItem("searchGroups" + $scope.reportName);
        $scope.init();
        //location.reload();
    }

    $scope.goBack = function() {
        localStorage.setItem("reportBackModule", $scope.params.module);
        window.history.back();
    }

    $scope.removeSearchCriteria = function(searchCritIndex, searchGrpIndex) {
        $scope.searchGroups[searchGrpIndex].splice(searchCritIndex, 1);
        $('.tooltip').tooltip('hide');
    }

    $scope.removeSearchGrp = function(searchGrpIndex) {
        $scope.searchGroups.splice(searchGrpIndex, 1);
        $('.tooltip').tooltip('hide');
    }

    $scope.resetColumns = function() {
        $scope.selectedColumns = $scope.initialColumns.filter(function(obj) { return true; });
    }

    $scope.resetGrpColumns = function() {
        $scope.groupedColumns = $scope.initialGroupedColumns.filter(function(obj) { return true; });
    }

    $scope.toCsv = function(filename) {
        console.log(filename);
        $("#report-tbl").tableHTMLExport({
            type: 'csv',
            filename: filename + '.csv'


        });
    }

    $scope.toPdf = function(filename) {
        console.log(filename);

        $("#report-tbl").tableHTMLExport({
            type: 'pdf',
            filename: filename + '.pdf'


        });
    }
    $scope.goToFilter = function() {
        $('.nav-item #a1').click();
    }
    $scope.goToColumn = function() {
        $('.nav-item #a2').click();
    }
    $scope.goToGroup = function() {
        $('.nav-item #a3').click();
    }
    $scope.run = function(navLink) {
        $scope.refresh();
        $scope.loadCriteria();
        $scope.saveSelectedCols();
        $scope.saveGroupedCols();
        params = urlService.getUrlParams();
        if (!params.previous_url) {
            var url = localStorage.getItem("url_previous")
            if (url)
                navLink = navLink.concat("&previous_url=" + url);
        }

        console.log(navLink);
        // console.log(url);



        window.location.href = "report" + navLink;
        // console.log(navLink);
    }

});