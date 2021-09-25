<?php

namespace App\Http\Controllers;

use App\Models\AdminDefaultSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Donation;
use App\Models\Module;
use App\Models\ModuleReport;
use App\Models\Role;
use App\Models\TourInvoice;
use App\Models\User;
use App\Models\UserReport;

use Auth;
use DateTime;
use Illuminate\Support\Facades\Validator;
use PDF;
use PragmaRX\Support\Environment;

class ReportController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  private $periodLabels;
  private $year;

  private function getMonthDays()
  {
    $days = [];
    $month = date('m');
    for ($i = 1; $i < date('t'); $i++) {
      $days[] = sprintf("%02d", $month) . '/' . sprintf("%02d", $i) . '/' . $this->year;
    }
    return $days;
  }

  public function __construct()
  {
    $this->middleware('auth');

    $this->year = date("Y");
    $this->setPeriodLabels();
  }

  private function setPeriodLabels()
  {
    $this->periodLabels = [
      'Year' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      'Quarter' => ['Q1', 'Q2', 'Q3', 'Q4'],
      'Month' => $this->getMonthDays()
    ];
    foreach ($this->periodLabels['Year'] as $key => $entry) {
      $this->periodLabels['Year'][$key] = $entry . ' ' . $this->year;
    }
    foreach ($this->periodLabels['Quarter'] as $key => $entry) {
      $this->periodLabels['Quarter'][$key] = $entry . ', ' . $this->year;
    }
    //dd($this->periodLabels);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    \Session::forget('breadcrumb');
    return view('report.index');
  }
  public function getModules()
  {
    $modules = Module::all();
    $data = [];
    // $data['reports'] = [];
    $user_roles = Auth::user()->roles;
    $role_ids = [];
    foreach ($user_roles as $key => $value) {
      $role_ids[] = $value->id;
    }
    // $current_roles = implode(',', $role_ids);
    // dd($role_ids);
    foreach ($modules as $key => $module) {
      $data[$key]['name'] = $module->name;
      $data[$key]['id'] = $module->id;
      $module_reports = ModuleReport::where('module_id', $module->id)->with('module')->get();
      foreach ($module_reports as $key1 => $module_report) {
        // $data['can_delete'] =false;
        // $data[$key]['reports'][$key1]['can_delete'] = false;//commented because all users can delete reports and set always true
        $data[$key]['reports'][$key1]['can_delete'] = true;
        $data[$key]['reports'][$key1]['can_edit'] = true;
        if (!isset($module_report->role_ids)) {

          $data[$key]['reports'][$key1]['name'] = $module_report->name;
          $data[$key]['reports'][$key1]['description'] = $module_report->description;
          $data[$key]['reports'][$key1]['created_by'] = $module_report->created_by;
          $data[$key]['reports'][$key1]['report'] = $module_report;
        } else {
          $existing_role_ids = explode(',', $module_report->role_ids);
          // dd($existing_role_ids,$role_ids);
          // dd($module_report->created_by,Auth::user()->id);
          $match = array_intersect($role_ids, $existing_role_ids);
          // dd($match);
          // if( $module_report->created_by == Auth::user()->id){ //commented because all users can delete reports
          // $data[$key]['reports'][$key1]['can_delete'] = true;
          // $data[$key]['reports'][$key1]['can_edit'] = true;
          // }
          if (count($match) || $module_report->created_by == Auth::user()->id) {
            $data[$key]['reports'][$key1]['name'] = $module_report->name;
            $data[$key]['reports'][$key1]['description'] = $module_report->description;
            $data[$key]['reports'][$key1]['created_by'] = $module_report->created_by;
            $data[$key]['reports'][$key1]['report'] = $module_report;
          }
        }
      }
    }
    return json_encode($data);
    // dd($data);
  }

  public function invoice(Request $request)
  {
    $breadcrumb = [];
    if (strpos(\URL::previous(), 'dashboard') !== false || (strpos(\URL::previous(), 'criteria') !== false && !$request->has('_period_')) || strpos(\URL::previous(), 'home') !== false) {
      \Session::forget('breadcrumb');
      $breadcrumb['Home'] = \URL::previous();
    } else {
      $breadcrumb = \Session::get('breadcrumb');
    }
    if (isset($breadcrumb[$request->get('report')])) {
      $reportFound = false;
      foreach ($breadcrumb as $title => $link) {

        if ($reportFound) {
          unset($breadcrumb[$title]);
        }
        if ($title == $request->get('report')) {
          $reportFound = true;
        }
      }
    } else {
      $breadcrumb[$request->get('report')] = \Request::fullUrl();
    }
    \Session::put('breadcrumb', $breadcrumb);
    $group_id = explode('-', $request->group_code);
    $tour_invoice = TourInvoice::where('group_id', $group_id[2])->with('group.user.memberships.membershipLevel' , 'group.tour.slot', 'group.cardDetails', 'group.tour.volunteer')->first();
    $admin_default_setting = AdminDefaultSetting::first();
    // dd($request->all(), $breadcrumb);
    return view('report.invoice', ['breadcrumbs' => $breadcrumb, 'tour_invoice' => $tour_invoice, 'admin_default_setting' => $admin_default_setting]);
  }

  public function report(Request $request)
  {
    // dd($request->all());
    $breadcrumb = [];
    // if (strpos(\URL::previous(), 'dashboard') !== false || (strpos(\URL::previous(), 'criteria') !== false && !$request->has('_period_')) || strpos(\URL::previous(), 'home') !== false) {
    if (strpos(\URL::previous(), 'dashboard') !== false  || strpos(\URL::previous(), 'home') !== false) {
      // dd(strpos(\URL::previous(), 'dashboard'),strpos(\URL::previous(), 'criteria'),strpos(\URL::previous(), 'home'),!$request->has('_period_'));
      \Session::forget('breadcrumb');
      $breadcrumb['Home'] = \URL::previous();
    } else {
      $breadcrumb = \Session::get('breadcrumb');
    }
    if($request->has('previous_url')){
      $breadcrumb['Home'] = \URL::to('/reports');
    }
    if(isset($breadcrumb['Home'])){

      $a = substr($breadcrumb['Home'], strrpos($breadcrumb['Home'], '/') + 1);
      if($a == 'reports'){
        $breadcrumb['Reports'] = $breadcrumb['Home'];
      } else {
        
        $breadcrumb['Dashboard'] = $breadcrumb['Home'];
      }
    }
    unset($breadcrumb['Home']);
    $breadcrumbIndex = $request->has('title') ? $request->get('title'): $request->get('report');
    if (isset($breadcrumb[$breadcrumbIndex])) {
      $reportFound = false;
      foreach ($breadcrumb as $title => $link) {

        if ($reportFound) {
          unset($breadcrumb[$title]);
        }
        if ($request->get('title')) {
          if ($title == $request->get('title')) {
            $reportFound = true;
          }
        } else {

          if ($title == $request->get('report')) {
            $reportFound = true;
          }
        }
      }
    } else {
      if ($request->get('title')) {
        $breadcrumb[$request->get('title')] = \Request::fullUrl();
      } else {
        $breadcrumb[$request->get('report')] = \Request::fullUrl();
      }
    }
    
    // dd($breadcrumb);
    \Session::put('breadcrumb', $breadcrumb);
    // dd($request->all());
    return view('report.report', ['breadcrumbs' => $breadcrumb]);
  }

  public function criteria()
  {
    $breadcrumb = \Session::get('breadcrumb');
    return view('report.criteria', ['breadcrumbs' => $breadcrumb]);
  }

  public function getReportColumns(Request $request)
  {
    $input = $request->all();
// dd($input);
    $data['reportColumns'] = config('constants.reports.' . $input['report'] . '.columns');
    $data['dataTypes'] = config('constants.reports.datatype_operators');
    $data['searchGroups'] = config('constants.reports.' . $input['report'] . '.searchGroups');
    // dd($input['report']);
    if (isset($input['_period_'])) {
      if (isset($input['_year_'])) {
        $this->year = $input['_year_'];
        $this->setPeriodLabels();
      }
      foreach ($data['reportColumns'] as &$reportColumn) {
        if ($reportColumn['alias'] == 'Period') {
          $reportColumn['type'] = 'enum';
          $reportColumn['enumArr'] = $this->periodLabels[$input['_period_']];

          break;
        }
      }
    }
    $role_names = [];
    $roles = Role::select('display_name')->get();
    foreach ($roles as $key => $value) {
      $role_names[] = $value->display_name;
    }
    // dd($user_data);
    foreach ($data['reportColumns'] as &$reportColumn) {
      if (isset($reportColumn['patron']) && $reportColumn['patron'] == 'Role') {
        $reportColumn['type'] = 'enum';
        $reportColumn['enumArr'] = $role_names;

        break;
      }
    }
    // dd($data);
    echo json_encode($data);
  }

  public function timespanConversion($timespan)
  {
    switch ($timespan) {
        // •	Today
        // •	next year today
        // •	previous year today
      case 'today':
      case 'next year today':
      case 'previous year today':
        $num = '0';
        if ($timespan == "next year today")
          $num = '+1';
        else if ($timespan == "previous year today")
          $num = '-1';
        $start_date = date('Y-m-d', strtotime($num . ' year'));
        $end_date = date('Y-m-d', strtotime($num . ' year'));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	this week
        // •	previous year this week
        // •	next year this week
        // •	next week
      case 'this week':
      case 'previous year this week':
      case 'next year this week':
      case 'next week':
        $dt = date("Y-m-d");
        $keyword = 'this';
        if ($timespan == "next week")
          $keyword = 'next';
        if ($timespan == "previous year this week")
          $dt = date("Y-m-d", strtotime('previous year'));
        if ($timespan == "next year this week")
          $dt = date("Y-m-d", strtotime('next year'));


        $start_date = date("Y-m-d", strtotime($dt . ' monday ' . $keyword . ' week'));
        $end_date = date("Y-m-d", strtotime($dt . ' sunday ' . $keyword . ' week'));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	this month
        // •	previous year this month
        // •	next year this month
        // •	next month
      case 'this month':
      case 'previous year this month':
      case 'next year this month':
      case 'next month':
        $dt = date("Y-m-d");
        $keyword = 'this';
        if ($timespan == "next month")
          $keyword = 'next';
        if ($timespan == "previous year this month")
          $dt = date("Y-m-d", strtotime('previous year'));
        if ($timespan == "next year this month")
          $dt = date("Y-m-d", strtotime('next year'));

        $start_date = date("Y-m-d", strtotime($dt . ' first day of ' . $keyword . ' month'));
        $end_date = date("Y-m-d", strtotime($dt . ' last day of ' . $keyword . ' month'));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	this quarter
        // •	previous year this quarter
        // •	next year this quarter
        // •	next quarter
      case 'this quarter':
      case 'previous year this quarter':
      case 'next year this quarter':
      case 'next quarter':
        $current_month = date('m');
        $current_year = date('Y');
        if ($timespan == "next quarter")
          $current_month = date('m', strtotime('+3 month'));
        if ($timespan == "previous year this quarter")
          $current_year = date('Y', strtotime('previous year'));
        if ($timespan == "next year this quarter")
          $current_year = date('Y', strtotime('next year'));
        if ($current_month >= 1 && $current_month <= 3) {
          $start_date = date($current_year . '-01-01');  // timestamp or 1-0Januray 12:00:00 AM
          $end_date = date($current_year . '-04-01');  // timestamp or 1-0April 12:00:00 AM means end of 31 March
        } else  if ($current_month >= 4 && $current_month <= 6) {
          $start_date = date($current_year . '-04-01');  // timestamp or 1-0April 12:00:00 AM
          $end_date = date($current_year . '-07-01');  // timestamp or 1-0July 12:00:00 AM means end of 30 June
        } else  if ($current_month >= 7 && $current_month <= 9) {
          $start_date = date($current_year . '-07-01');  // timestamp or 1-0July 12:00:00 AM
          $end_date = date($current_year . '-10-01');  // timestamp or 1-0October 12:00:00 AM means end of 30 September
        } else  if ($current_month >= 10 && $current_month <= 12) {
          $start_date = date($current_year . '-10-01');  // timestamp or 1-0October 12:00:00 AM
          $end_date = date((($current_year + 1) . '-01-01'));  // timestamp or 1-0January Next year 12:00:00 AM means end of 31 December this year
        }
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	last 3 months
        // •	previous year last 3 months
        // •	next year last 3 months
        // •	next 3 months
      case 'last 3 months':
      case 'previous year last 3 months':
      case 'next year last 3 months':
      case 'next 3 months':
        $dt = date("Y-m-d");
        $keyword = '-3';
        if ($timespan == "next 3 months")
          $keyword = '+3';
        if ($timespan == "previous year last 3 months")
          $dt = date("Y-m-d", strtotime('previous year'));
        if ($timespan == "next year last 3 months")
          $dt = date("Y-m-d", strtotime('next year'));

        $end_date = date("Y-m-d", strtotime($dt . ' ' . $keyword . ' month'));
        $start_date = date("Y-m-d", strtotime($dt));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	last 6 months
        // •	previous year last 6 months
        // •	next year last 6 months
        // •	next 6 months
      case 'last 6 months':
      case 'previous year last 6 months':
      case 'next year last 6 months':
      case 'next 6 months':
        $dt = date("Y-m-d");
        $keyword = '-6';
        if ($timespan == "next 6 months")
          $keyword = '+6';
        if ($timespan == "previous year last 6 months")
          $dt = date("Y-m-d", strtotime('previous year'));
        if ($timespan == "next year last 6 months")
          $dt = date("Y-m-d", strtotime('next year'));

        $start_date = date("Y-m-d", strtotime($dt . ' ' . $keyword . ' month'));
        $end_date = date("Y-m-d", strtotime($dt));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	this calendar year
        // •	previous calendar year
        // •	next calendar year
      case 'this calendar year':
      case 'previous calendar year':
      case 'next calendar year':
        $keyword = 'this';
        if ($timespan == "previous calendar year")
          $keyword = 'previous';
        else if ($timespan == "next calendar year")
          $keyword = 'next';
        $start_date = date("Y-m-d", strtotime('first day of january ' . $keyword . ' year'));
        $end_date = date("Y-m-d", strtotime('last day of december ' . $keyword . ' year'));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

        // •	last year (12 months)
        // •	previous year (12 months)
        // •	next year (12 months)
      case 'last year (12 months)':
      case 'previous year (12 months)':
      case 'next year (12 months)':
        $dt = date("Y-m-d");
        if ($timespan == "previous year (12 months)")
          $dt = date("Y-m-d", strtotime('previous year'));
        if ($timespan == "next year (12 months)")
          $dt = date("Y-m-d", strtotime('next year'));

        $start_date = date("Y-m-d", strtotime($dt . ''));
        $end_date = date("Y-m-d", strtotime($dt . ' -12 month'));
        return (['sd' => $start_date, 'ed' => $end_date]);
        break;

      default:
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        return (['sd' => $start_date, 'ed' => $end_date]);
    }
  }

  public function getReport(Request $request)
  {
    // dd($request->all());
    $input = $request->all();
    $defaultConfig = $input['defaultConfig'];
    $reportName = $input['report'];
    $reportQryInfo = config('constants.reports.' . $reportName);
    //variables to be used in query generation
    $selectedColumns = [];
    $groupedColumns = [];
    $searchGroups = [];




// dd($reportQryInfo);

    if ($defaultConfig == '0') { //means selectedColumns, groupedColumns, searchGroups should be taken from the request
      if (isset($input['selectedColumns']))
        $selectedColumns = json_decode($input['selectedColumns']);
      if (isset($input['groupedColumns']))
        $groupedColumns = json_decode($input['groupedColumns']);
      if (isset($input['searchGroups']))
        $searchGroups = json_decode($input['searchGroups']);
    } else { //means (defaultConfig == 1). selectedColumns, groupedColumns should be taken from the constants config 
      // if searchCriteria present in request then process that otherwise process searchGroups in constants or requests
      $selectedColumnsCounter = 0;
      $groupedColumnsCounter = 0;
      foreach ($reportQryInfo['columns'] as $column) {
        //dd($column);
        if (!isset($column['isDefault']) || $column['isDefault'] == 0)
          continue;
        //at this point code comes if column is a default column
        if (isset($column['aggregation'])) {
          $selectedColumns[$selectedColumnsCounter++] = (object)array('Name' => $column['name'], 'Alias' => $column['alias'], 'Type' => $column['type'], 'Aggregation' => $column['aggregation']);
        } else
          $selectedColumns[$selectedColumnsCounter++] = (object)array('Name' => $column['name'], 'Alias' => $column['alias'], 'Type' => $column['type']);

        if (isset($column['group']) && $column['group'] == 1)
          $groupedColumns[$groupedColumnsCounter++] = (object)array('Name' => $column['name'], 'Alias' => $column['alias'], 'Type' => $column['type']);
      }

      //setup search groups
      $searchGroupsCounter = 0;
      if (isset($input['searchCriteria'])) { //means search criteria should be processed from the incoming request parameters
        $searchCriteria = json_decode($input['searchCriteria']);
        //dd($searchCriteria);

        $searchGroupsCounter = 0;
        $searchCounter = 0;
        foreach ($searchCriteria as $criteria) {
          //dd($criteria);
          $constCol = null;
          foreach ($reportQryInfo['columns'] as $col) {
            if (strtolower($col['alias']) == strtolower($criteria->column) || strtolower($col['name']) == strtolower($criteria->column)) {
              $constCol = $col;
              break;
            }
          }
          if ($constCol != null) {
            $searchGroups[$searchGroupsCounter][$searchCounter++] = (object)array(
              'column' => (object)array('name' => $criteria->column, 'type' => $constCol['type'], 'alias' => $constCol['alias']),
              'operator' => '=',
              'value' => $criteria->value
            );
          } else {
            $searchGroups[$searchGroupsCounter][$searchCounter++] = (object)array(
              'column' => (object)array('name' => $criteria->column),
              'operator' => '=',
              'value' => $criteria->value
            );
          }
          //dd($searchGroups);
          //print_r($searchGroups);
          //also add searchGroups coming from the request...
        } //there will always be one search group in case search criteria coming from query string
        $searchGroupsCounter++;
        if (isset($input['searchGroups']) && sizeof($searchCriteria) == 0)
          $searchGroups = json_decode($input['searchGroups']);
        //dd($searchGroups);
      } else if (isset($reportQryInfo['searchGroups'])) { //means searchCriteria is not there in request. Process searchGroups in constants (if any)
        foreach ($reportQryInfo['searchGroups'] as $searchGroup) {
          $searchCounter = 0;
          foreach ($searchGroup as $search) {
            $searchGroups[$searchGroupsCounter][$searchCounter++] = (object)array(
              'column' => (object)array('name' => $search['column']['name'], 'alias' => $search['column']['alias'], 'type' => $search['column']['type']),
              'operator' => $search['operator'],
              'value' => $search['value']
            );
          }
          $searchGroupsCounter++;
        }
      }
    }

    //Now start making the query...
    $query = \DB::table($reportQryInfo['base_table']);

    // dd($selectedColumns);
    //dd($groupedColumns);
    //dd($searchGroups);

    /* Section added to check whether dependent columns are being included or not */
    foreach ($selectedColumns as $column) {
      //dd('in dependent columns 1');
      $constColumn = null;
      foreach ($reportQryInfo['columns'] as $struct) {
        if ($column->Name == $struct['name']) {
          $constColumn = $struct;
          break;
        }
      }
      if ($constColumn == null)
        continue; // cant proceed further if constants column match is not found.
      if (isset($constColumn['dependent_columns'])) {
        //dd('in dependent columns');
        $dependentColumns = $constColumn['dependent_columns'];
        //at this time we are assuming only one dependent column.
        //check whether this column is in the selection list, if not then add it to $selectedColumns
        $dependentColumnsArr = explode(':', $dependentColumns);
        $dependentColumnName = $dependentColumnsArr[0];
        $dependentColumnAlias = $dependentColumnsArr[1];
        if (!$this->find_key_value($selectedColumns, 'Name', $dependentColumnName)) {
          array_push($selectedColumns, (object) (['Name' => $dependentColumnName, 'Alias' => $dependentColumnAlias, 'Type' => 'number', 'Display' => '0'])); //assuming all dependent columns to be of type number
          //dd($selectedColumns);
        }
      }
    }


    //Add the selected columns to the query...
    foreach ($selectedColumns as $column) {
      //get corresponding report column entry from constants...
      $constColumn = null;
      if (is_array($column))
        $column = $column[0]; //needed to avoid change in all references below.
      //if ($column->Type == 'date')
      //dd($selectedColumns);
      //dd($column);
      foreach ($reportQryInfo['columns'] as $struct) {
        if ($column->Name == $struct['name']) {
          $constColumn = $struct;
          break;
        }
      }

      // print_r($constColumn->group);
      // if ($column->Type == 'date' && isset($constColumn->group))
      //   print_r('hello date');
      //print_r('hello'. && $constColumn->group == 1 && isset($input['period']));

        if (isset($constColumn['custom'])) {
          $query = $query->selectRaw($constColumn['custom'] . ' as \'' . $column->Alias . '\'');
        } else if (isset($column->Aggregation))
          $query = $query->selectRaw($column->Aggregation . '(' . $column->Name . ') as \'' . $column->Alias . '\'');
        else if ($column->Type == 'date' && isset($constColumn['group']) && $constColumn['group'] == 1 && isset($input['period'])) { //if type is date and group is 1 and period is defined in query string
          $query = $query->selectRaw($this->getRawSelectForPeriod($column->Name, $input['period']) . ' as \'' . $column->Alias . '\'');
        } else {
          $query = $query->selectRaw($column->Name . ' as \'' . $column->Alias . '\'');
        }
    }

    //Add the join info to the query. Note that join info comes from constants.php only as it is not configurable in UI...
    if (isset($reportQryInfo['joins']) && count($reportQryInfo['joins']) > 0) {

      foreach ($reportQryInfo['joins'] as $join) {
        if ($join['type'] == 'left') {

          $query->leftJoin($join['table'], $join['column'], '=', $join['on_column']);
        } else {
          $query->join($join['table'], $join['column'], '=', $join['on_column']);
        }
      }
    }

    // dd($searchGroups);
    //Now add search info to the query...
    if ($searchGroups != null) {
      if (count($searchGroups) > 0) {
        foreach ($searchGroups as $searchGroup) {
          //$searchGroup = $searchGroup[0];
          //dd($searchGroup);
          if (count($searchGroup) == 0 || $searchGroup[0]->column == null)
            break;
          $query->orWhere(function ($query) use ($searchGroup, $reportQryInfo, $input) {

            foreach ($searchGroup as $whereClause) {
              $constColumn = null;
              // if ($whereClause->column->name == 'period')
              //   dd($whereClause);
              foreach ($reportQryInfo['columns'] as $struct) {
                // if ($whereClause->column->name == 'period')
                //dd($struct);
                if (isset($whereClause->column->alias) && strtolower($whereClause->column->alias) == strtolower($struct['alias'])) {
                  $constColumn = $struct;
                  break;
                } else if (isset($whereClause->column->name) && strtolower($whereClause->column->name) == strtolower($struct['alias'])) {
                  $constColumn = $struct;
                  break;
                }
              }
              //print_r($constColumn['type']);
              // if ($constColumn['type'] == 'date')
              //   dd($constColumn['type'], $constColumn['group']);
              //print_r($constColumn['type']);
              // if ($constColumn['type'] == 'date')
              // if ($constColumn['type'] != 'string')
              // dd($whereClause);
              // dd($whereClause->value);
              $timespan = $this->timespanConversion($whereClause->value);

              if (isset($constColumn['where']) && $constColumn['where'] == 'date') {
                // dd('inwhere');
                $query->whereRaw($whereClause->column->name . $whereClause->operator . '\'' . date('Y-m-d', strtotime($whereClause->value)) . '\'');
              } else if (isset($constColumn['type']) && $constColumn['type'] == 'date' && isset($constColumn['group']) && $timespan) {
                // dd('in');
                if ($whereClause->operator == '==') {

                  $start_dt = new DateTime($timespan['sd']);
                  $end_dt = new DateTime($timespan['ed']);

                  $v1 = $start_dt > $end_dt ? $timespan['ed'] : $timespan['sd'];
                  $v2 = $start_dt > $end_dt ? $timespan['sd'] : $timespan['ed'];
                  // dd($whereClause->column->name . ' BETWEEN ' . '\'' .$v1. '\'' .' AND '.'\'' .$v2 . '\'');
                  // dd($whereClause->column->name . ' BETWEEN ' . '\'' .date('Y-m-d'). '\'' .' AND '.'\'' . date('Y-m-d', strtotime($whereClause->value)) . '\'');
                  $query->whereRaw($whereClause->column->name . ' BETWEEN ' . '\'' . $v1 . '\'' . ' AND ' . '\'' . $v2 . '\'');
                  // dd($query->get());
                } else {

                  $where = $this->getRawSelectForPeriod($constColumn['name'],  $input['period']);

                  $query->whereRaw($where . $whereClause->operator . '\'' . $whereClause->value . '\'');
                }
              } else if (isset($constColumn['type']) && $constColumn['type'] == 'date' && isset($constColumn['group'])) {
                // dd('in');
                $where = $this->getRawSelectForPeriod($constColumn['name'],  $input['period']);
                //dd($where);
                //print_r($where);
                $query->whereRaw($where . $whereClause->operator . '\'' . $whereClause->value . '\'');
              } else if (isset($constColumn['type']) && $constColumn['type'] == 'date') {

                if ($whereClause->operator == '==') {

                  $start_dt = new DateTime($timespan['sd']);
                  $end_dt = new DateTime($timespan['ed']);

                  $v1 = $start_dt > $end_dt ? $timespan['ed'] : $timespan['sd'];
                  $v2 = $start_dt > $end_dt ? $timespan['sd'] : $timespan['ed'];
                  // dd($whereClause->column->name . ' BETWEEN ' . '\'' .$v1. '\'' .' AND '.'\'' .$v2 . '\'');
                  // dd($whereClause->column->name . ' BETWEEN ' . '\'' .date('Y-m-d'). '\'' .' AND '.'\'' . date('Y-m-d', strtotime($whereClause->value)) . '\'');
                  $query->whereRaw($whereClause->column->name . ' BETWEEN ' . '\'' . $v1 . '\'' . ' AND ' . '\'' . $v2 . '\'');
                  // dd($query->get());
                } else {

                  // dd($whereClause);
                  $query->whereRaw($whereClause->column->name . $whereClause->operator . '\'' . date('Y-m-d', strtotime($whereClause->value)) . '\'');
                }
              } else if (isset($constColumn['type']) && $constColumn['type'] == 'time'){

                $convertedValue = date('H:i:s', strtotime($whereClause->value));
                // dd($convertedValue);
                $query->whereRaw($whereClause->column->name . " " . $whereClause->operator . " '" . $convertedValue . "'");
              } else {
                if ($whereClause->operator == 'contains')
                  $query->whereRaw($whereClause->column->name . ' like \'%' . $whereClause->value . '%\'');
                else
                  $query->whereRaw($whereClause->column->name . " " . $whereClause->operator . " '" . $whereClause->value . "'");
              }
            }
          });
        }
      }
    }



    //Now add grouped columns info to the query...
    $groupedColumnsStr = '';
    foreach ($groupedColumns as $groupedCol) {
      //first check whether the grouped col is in the selected columns list...
      //dd($selectedColumns);
      if (!$this->find_key_value($selectedColumns, 'Name', $groupedCol->Name))
        continue; //process the next record
      //dd($groupedCol);
      if (strpos($groupedCol->Alias, " ") !== false)
        $groupedColumnsStr = $groupedColumnsStr . $groupedCol->Name . ',';
      else
        $groupedColumnsStr = $groupedColumnsStr . $groupedCol->Alias . ',';
    }
    $groupedColumnsStr = rtrim($groupedColumnsStr, ',');
    if (strlen($groupedColumnsStr) > 0) {
      $query->groupBy(\DB::raw($groupedColumnsStr));
    }

    $sql = $query->toSql();
    // dd($sql);
    $countQ = \DB::select( \DB::raw("select count(*) as countAll from ($sql) as a"));
  //  $countQ =  \DB::raw("select count(*) from ($sql) as a");


// select count(*) from (
// select 
// )
// dd($countQ[0]);
// \DB::enableQueryLog(); // Enable query log

// $data = $query->get();
//     dd(\DB::getQueryLog()); // Show results of log

    //Now execute the query...  
    
    $TotalRecords = $countQ[0]->countAll; 

    if (isset($input['pageSort'])) {
      $sortingPagination = json_decode($input['pageSort']);
      $data = $query->skip($sortingPagination->page * 100 - 100)->take($sortingPagination->page * 100);
      if (isset($sortingPagination->colName))
        $data = $data->orderBy($sortingPagination->colName, $sortingPagination->direction);
      $data = $data->get();
    } else {
      $data = $query->get();
    }

    //dd($data);
    //print_r('period is ' . $input['period']);

    //Now process the columns for any link type columns...
    foreach ($reportQryInfo['columns'] as $colLink) {
      if (!$this->find_key_value($selectedColumns, 'Name', $colLink['name']))
        continue; //skip processing if the column is not in the selected columns list
      //processing of link type columns
      if ($colLink['isDefault'] == 1 && isset($colLink['link'])) {
        $link = $colLink['link'];
        $link = str_replace('__period__', isset($input['period']) ? $input['period'] : 'Month', $link);
        for ($i = 0; $i < count($data); $i++) {
          $linkUpdated = $link;
          // $linkUpdated = $this->get_updated_link($link);
          //now iterate all columns to update the values...
          foreach ($reportQryInfo['columns'] as $col) {
            //$prop = strpos($col['alias'], ' ') ? '\'' . $col['alias'] . '\'' : $col['alias']; //add ' to property name if it has spaces
            $prop = $col['alias'];
            // if ($prop == '\'Patron Code\'')
            //   dd($data[$i]->{$col['alias']});
            try {
              if (isset($data[$i]->{$prop}))
                $linkUpdated = str_replace(
                  '__' . strtolower($col['alias']),
                  $data[$i]->{$prop} == null ? '' : $data[$i]->{$prop},
                  $linkUpdated
                );
            } catch (\ErrorException $e) {
              //dd(print_r($data[$i]) . $e);
            }
          }
          //$prop = strpos($colLink['alias'], ' ') ? '\'' . $colLink['alias'] . '\'' : $colLink['alias']; //add ' to property name if it has spaces
          $prop = $colLink['alias'];
          if (isset($data[$i]->{$prop}))
            $data[$i]->$prop = '<a href="' . site_url($linkUpdated.'&d=1') . '" >' . $data[$i]->$prop . '</a>';
        }
      }
    }

    //remove columns data that have Display set to 0
    foreach ($selectedColumns as $col1) {
      if (isset($col1->Display) && $col1->Display == '0') {
        $prop = $col1->Alias;
        for ($i = 0; $i < count($data); $i++) {
          unset($data[$i]->{$prop});
        }
      }
    }

    //remove columns that have Display set to 0
    for ($i = 0; $i < count($selectedColumns); $i++) {
      if (isset($selectedColumns[$i]->Display) && $selectedColumns[$i]->Display == '0') {
        unset($selectedColumns[$i]);
      }
    }

    // dd($data);
    
    return json_encode([
      'totalRecords' => $TotalRecords,
      'result' => $data,
      'selectedColumns' => $selectedColumns,
      'groupedColumns' => $groupedColumns,
      'searchGroups' => $searchGroups
    ], JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
  }

  public function getReportOld2(Request $request)
  {
    $input = $request->all();
    $defaultConfig = $input['defaultConfig'];
    $reportName = $input['report'];
    $reportQryInfo = config('constants.reports.' . $reportName);

    //variables to be used in query generation
    $selectedColumns = [];
    $groupedColumns = [];
    $searchGroups = [];


    if ($defaultConfig == '0') { //means selectedColumns, groupedColumns, searchGroups should be taken from the request
      if (isset($input['selectedColumns']))
        $selectedColumns = json_decode($input['selectedColumns']);
      if (isset($input['groupedColumns']))
        $groupedColumns = json_decode($input['groupedColumns']);
      if (isset($input['searchGroups']))
        $searchGroups = json_decode($input['searchGroups']);
    } else { //means selectedColumns (default = 1), groupedColumns should be taken from the constants config 
      // if searchCriteria present in request then process that otherwise process searchGroups in constants or requests
      $selectedColumnsCounter = 0;
      $groupedColumnsCounter = 0;
      foreach ($reportQryInfo['columns'] as $column) {
        if (!isset($column['isDefault']) || $column['isDefault'] == 0)
          continue;
        //at this point code comes if column is a default column
        if (isset($column['aggregation'])) {
          $selectedColumns[$selectedColumnsCounter++] = (object)array('Name' => $column['name'], 'Alias' => $column['alias'], 'Type' => $column['type'], 'Aggregation' => $column['aggregation']);
        } else
          $selectedColumns[$selectedColumnsCounter++] = (object)array('Name' => $column['name'], 'Alias' => $column['alias'], 'Type' => $column['type']);

        if (isset($column['group']) && $column['group'] == 1)
          $groupedColumns[$groupedColumnsCounter++] = (object)array('Name' => $column['name'], 'Alias' => $column['alias'], 'Type' => $column['type']);
      }

      //setup search groups
      $searchGroupsCounter = 0;
      if (isset($input['searchCriteria'])) { //means search criteria should be processed from the incoming request parameters
        $searchCriteria = json_decode($input['searchCriteria']);
        if ($defaultConfig == '1') { //means default config is being picked...

          $searchGroupsCounter = 0;
          foreach ($searchCriteria as $criteriaArr) {
            $searchCounter = 0;
            foreach ($criteriaArr as $criteria) {
              $constCol = null;
              //dd($criteria);
              foreach ($reportQryInfo['columns'] as $col) {
                if (strtolower($col['alias']) == strtolower($criteria->column->name) || strtolower($col['name']) == strtolower($criteria->column->name)) {
                  $constCol = $col;
                  break;
                }
              }
              if ($constCol != null) {
                $searchGroups[$searchGroupsCounter][$searchCounter++] = (object)array(
                  'column' => (object)array('name' => $criteria->column->name, 'type' => $constCol['type'], 'alias' => $constCol['alias']),
                  'operator' => '=',
                  'value' => $criteria->value
                );
              } else {
                $searchGroups[$searchGroupsCounter][$searchCounter++] = (object)array(
                  'column' => (object)array('name' => $criteria->column->name),
                  'operator' => '=',
                  'value' => $criteria->value
                );
              }
              $searchGroupsCounter++;
            }
            //dd($searchGroups);
            //print_r($searchGroups);
          }
        } else { //means selectedColumns, groupedColumns, searchGroups should be taken from the request
          $searchCounter = 0;
          foreach ($searchCriteria as $criteria) {
            $constCol = null;
            //dd($criteria);
            foreach ($reportQryInfo['columns'] as $col) {
              if (strtolower($col['alias']) == strtolower($criteria->column) || strtolower($col['name']) == strtolower($criteria->column)) {
                $constCol = $col;
                break;
              }
            }
            if ($constCol != null) {
              $searchGroups[0][$searchCounter++] = (object)array(
                'column' => (object)array('name' => $criteria->column, 'type' => $constCol['type'], 'alias' => $constCol['alias']),
                'operator' => '=',
                'value' => $criteria->value
              );
            } else {
              $searchGroups[0][$searchCounter++] = (object)array(
                'column' => (object)array('name' => $criteria->column),
                'operator' => '=',
                'value' => $criteria->value
              );
            }
          }
        }
      } else if (isset($reportQryInfo['searchGroups'])) { //means searchCriteria is not there in request. Process searchGroups in constants (if any)
        foreach ($reportQryInfo['searchGroups'] as $searchGroup) {
          $searchCounter = 0;
          foreach ($searchGroup as $search) {
            $searchGroups[$searchGroupsCounter][$searchCounter++] = (object)array(
              'column' => (object)array('name' => $search['column']['name'], 'alias' => $search['column']['alias'], 'type' => $search['column']['type']),
              'operator' => $search['operator'],
              'value' => $search['value']
            );
          }
          $searchGroupsCounter++;
        }
      }
    }

    //Now start making the query...
    $query = \DB::table($reportQryInfo['base_table']);

    //dd($selectedColumns);
    //dd($groupedColumns);
    //dd($searchGroups);


    //Add the selected columns to the query...
    foreach ($selectedColumns as $column) {
      //get corresponding report column entry from constants...
      $constColumn = null;
      if (is_array($column))
        $column = $column[0]; //needed to avoid change in all references below.
      //if ($column->Type == 'date')
      //dd($selectedColumns);
      //dd($column);
      foreach ($reportQryInfo['columns'] as $struct) {
        if ($column->Name == $struct['name']) {
          $constColumn = $struct;
          break;
        }
      }

      // print_r($constColumn->group);
      // if ($column->Type == 'date' && isset($constColumn->group))
      //   print_r('hello date');
      //print_r('hello'. && $constColumn->group == 1 && isset($input['period']));

      if (isset($constColumn['custom'])) {
        $query = $query->selectRaw($constColumn['custom'] . ' as \'' . $column->Alias . '\'');
      } else if (isset($column->Aggregation))
        $query = $query->selectRaw($column->Aggregation . '(' . $column->Name . ') as \'' . $column->Alias . '\'');
      else if ($column->Type == 'date' && isset($constColumn['group']) && $constColumn['group'] == 1 && isset($input['period'])) { //if type is date and group is 1 and period is defined in query string
        $query = $query->selectRaw($this->getRawSelectForPeriod($column->Name, $input['period']) . ' as \'' . $column->Alias . '\'');
      } else
        $query = $query->selectRaw($column->Name . ' as \'' . $column->Alias . '\'');
    }

    //Add the join info to the query. Note that join info comes from constants.php only as it is not configurable in UI...
    if (isset($reportQryInfo['joins']) && count($reportQryInfo['joins']) > 0) {

      foreach ($reportQryInfo['joins'] as $join) {
        if ($join['type'] == 'left') {

          $query->leftJoin($join['table'], $join['column'], '=', $join['on_column']);
        } else {
          $query->join($join['table'], $join['column'], '=', $join['on_column']);
        }
      }
    }

    //dd($searchGroups);
    //Now add search info to the query...
    if ($searchGroups != null) {
      if (count($searchGroups) > 0) {
        foreach ($searchGroups as $searchGroup) {
          //$searchGroup = $searchGroup[0];
          //dd($searchGroup);
          if (count($searchGroup) == 0 || $searchGroup[0]->column == null)
            break;
          $query->orWhere(function ($query) use ($searchGroup, $reportQryInfo, $input) {
            foreach ($searchGroup as $whereClause) {
              $constColumn = null;
              // if ($whereClause->column->name == 'period')
              //   dd($whereClause);
              foreach ($reportQryInfo['columns'] as $struct) {
                // if ($whereClause->column->name == 'period')
                //dd($struct);
                if (isset($whereClause->column->alias) && strtolower($whereClause->column->alias) == strtolower($struct['alias'])) {
                  $constColumn = $struct;
                  break;
                } else if (isset($whereClause->column->name) && strtolower($whereClause->column->name) == strtolower($struct['alias'])) {
                  $constColumn = $struct;
                  break;
                }
              }
              //print_r($constColumn['type']);
              // if ($constColumn['type'] == 'date')
              //   dd($constColumn['type']);
              //print_r($constColumn['type']);
              // if ($constColumn['type'] == 'date')
              // if ($constColumn['type'] != 'string')
              //   dd($constColumn);
              if ($constColumn['type'] == 'date' && isset($constColumn['group']) && $constColumn['group'] == 1) {
                $where = $this->getRawSelectForPeriod($constColumn['name'],  $input['period']);
                //dd($where);
                //print_r($where);
                $query->whereRaw($where . $whereClause->operator . '\'' . $whereClause->value . '\'');
              } else {
                if ($whereClause->operator == 'contains')
                  $query->whereRaw($whereClause->column->name . ' like \'%' . $whereClause->value . '%\'');
                else
                  $query->whereRaw($whereClause->column->name . " " . $whereClause->operator . " '" . $whereClause->value . "'");
              }
            }
          });
        }
      }
    }

    //Now add grouped columns info to the query...
    $groupedColumnsStr = '';
    foreach ($groupedColumns as $groupedCol) {
      //first check whether the grouped col is in the selected columns list...
      //dd($selectedColumns);
      if (!$this->find_key_value($selectedColumns, 'Name', $groupedCol->Name))
        continue; //process the next record
      //dd($groupedCol);
      if (strpos($groupedCol->Alias, " ") !== false)
        $groupedColumnsStr = $groupedColumnsStr . $groupedCol->Name . ',';
      else
        $groupedColumnsStr = $groupedColumnsStr . $groupedCol->Alias . ',';
    }
    $groupedColumnsStr = rtrim($groupedColumnsStr, ',');
    if (strlen($groupedColumnsStr) > 0) {
      $query->groupBy(\DB::raw($groupedColumnsStr));
    }



    //Now execute the query...  
    //\DB::enableQueryLog(); // Enable query log
    $data = $query->get();
    //dd(\DB::getQueryLog()); // Show results of log
    //dd($data);
    //print_r('period is ' . $input['period']);

    //Now process the columns for any link type columns...
    foreach ($reportQryInfo['columns'] as $colLink) {
      if (!$this->find_key_value($selectedColumns, 'Name', $colLink['name']))
        continue; //skip processing if the column is not in the selected columns list
      if ($colLink['isDefault'] == 1 && isset($colLink['link'])) {
        $link = $colLink['link'];
        $link = str_replace('__period__', isset($input['period']) ? $input['period'] : 'Month', $link);
        for ($i = 0; $i < count($data); $i++) {
          $linkUpdated = $link;
          // $linkUpdated = $this->get_updated_link($link);
          //now iterate all columns to update the values...
          foreach ($reportQryInfo['columns'] as $col) {
            //$prop = strpos($col['alias'], ' ') ? '\'' . $col['alias'] . '\'' : $col['alias']; //add ' to property name if it has spaces
            $prop = $col['alias'];
            // if ($prop == '\'Patron Code\'')
            //   dd($data[$i]->{$col['alias']});
            try {
              if (isset($data[$i]->{$prop}))
                $linkUpdated = str_replace(
                  '__' . strtolower($col['alias']),
                  $data[$i]->{$prop} == null ? '' : $data[$i]->{$prop},
                  $linkUpdated
                );
            } catch (\ErrorException $e) {
              //dd(print_r($data[$i]) . $e);
            }
          }
          //$prop = strpos($colLink['alias'], ' ') ? '\'' . $colLink['alias'] . '\'' : $colLink['alias']; //add ' to property name if it has spaces
          $prop = $colLink['alias'];
          if (isset($data[$i]->{$prop}))
            $data[$i]->$prop = '<a href="' . site_url($linkUpdated) . '" >' . $data[$i]->$prop . '</a>';
        }
      }
    }


    //dd($data);

    return json_encode([
      'result' => $data,
      'selectedColumns' => $selectedColumns,
      'groupedColumns' => $groupedColumns,
      'searchGroups' => $searchGroups
    ], JSON_NUMERIC_CHECK);
  }

  function find_key_value($array, $key, $val)
  {
    //dd('in new func');
    foreach ($array as $item) {
      if (is_array($item) && $this->find_key_value($item, $key, $val)) return true;
      //dd($item);
      if (isset($item->$key) && $item->$key == $val) return true;
    }

    return false;
  }

  private function getRawSelectForPeriod(string $columnName, string $period)
  {
    $sql = '';
    switch ($period) {
      case 'Year':
        $sql = 'date_format(' . $columnName . ',\'%b %Y\')';
        break;
      case 'Quarter':
        $sql = 'concat(\'Q\',quarter(' . $columnName . '),\', \',date_format(' . $columnName . ',\'%Y\'))';
        break;
      case 'Month':
        $sql = 'date_format(' . $columnName . ',\'%m/%d/%Y\')';
        break;
      default:
        $sql = $columnName;
        break;
    }
    return $sql;
  }

  public function getReportOld(Request $request)
  {

    //\DB::enableQueryLog();
    $input = $request->all();
    $searchGrps = [];
    $searchGrpsChart = [];
    if (isset($input['searchGrps']))
      $searchGrps = json_decode($input['searchGrps']);
    //dd(print_r($searchGrps));
    $reportName = $input['report'];
    $selectedColumns = [];
    $groupedColumns = [];
    if (isset($input['selectedColumns' . $reportName]))
      $selectedColumns = json_decode($input['selectedColumns' . $reportName]);
    if (isset($input['groupedColumns' . $reportName]))
      $groupedColumns = json_decode($input['groupedColumns' . $reportName]);
    //dd(print_r($selectedColumns));
    $reportQryInfo = config('constants.reports.' . $reportName);
    //dd(print_r($reportQryInfo));
    $select = [];
    //dd(count($selectedColumns));
    //dd(print_r($reportQryInfo['columns']));
    //print_r('period is ' . $input['period']);
    if (count($selectedColumns) == 0) {

      $i = 0;
      foreach ($reportQryInfo['columns'] as $value) {
        if ($value['isDefault'] == 1) {
          if (isset($value['custom'])) {
            $select[$i] = $value['custom'] . ' as \'' . $value['alias'] . '\'';
          } else if (isset($value['aggregation']))
            $select[$i] = $value['aggregation'] . '(' . $value['name'] . ') as \'' . $value['alias'] . '\'';
          else if ($value['type'] == 'date' && isset($value['group']) && $value['group'] == 1 && isset($input['period'])) { //if type is date and group is 1 and period is defined in query string
            switch ($input['period']) {
              case 'Year':
                $select[$i] = 'date_format(' . $value['name'] . ',\'%b %Y\')' . ' as \'' . $value['alias'] . '\'';
                break;
              case 'Quarter':
                $select[$i] = 'concat(\'Q\',quarter(' . $value['name'] . '),\', \',date_format(' . $value['name'] . ',\'%Y\'))' . ' as \'' . $value['alias'] . '\'';
                break;
              case 'Month':
                $select[$i] = 'date_format(' . $value['name'] . ',\'%m %Y\')' . ' as \'' . $value['alias'] . '\'';
                break;
              default:
                $select[$i] = $value['name'] . ' as \'' . $value['alias'] . '\'';
                # code...
                break;
            }
          } else
            $select[$i] = $value['name'] . ' as \'' . $value['alias'] . '\'';
          //print_r($select[$i].'<br>');

          if (isset($value['group'])) {
            $groupedColumns = $groupedColumns . $value['alias'] . ',';
            //$groupedColumns = $groupedColumns . $value['custom'] . ',';
          }
          $i++;
        }
      }
      $selectedColumns = $select;

      // $selectedColumns = array_column($reportQryInfo['columns'], ['name','alias']);
      // print_r($selectedColumns);

      //also check if searchGrpsChart are defined in the report constants...
      if (isset($reportQryInfo['searchGrpsChart'])) {
        $searchGrpsChart = $reportQryInfo['searchGrpsChart'];
        $searchGrps = []; //reset searchGrps if searchGrpsChart is set
      }
    } else {
      $i = 0;
      foreach ($selectedColumns as $value) {
        //print_r($value->Name);
        // if($value['isDefault']==1){
        $select[$i] = $value->Name . ' as \'' . $value->Alias . '\'';
        $i++;
        // }

      }
      $selectedColumns = $select;
    }


    //dd(print_r($selectedColumns));
    //dd(print_r($searchGrps));

    $reportQryInfo['select'] = $selectedColumns;
    // $query = \DB::table($reportQryInfo['base_table'])->select($reportQryInfo['select']);
    $query = \DB::table($reportQryInfo['base_table']);
    foreach ($reportQryInfo['select'] as $selection) {
      $query = $query->selectRaw($selection);
    }

    if (isset($reportQryInfo['base_where'])) {
      $query->whereRaw($reportQryInfo['base_where']);
    }
    //reportqueryinfo yeh contant php ka aik object hai 
    if (isset($reportQryInfo['joins']) && count($reportQryInfo['joins']) > 0) {

      foreach ($reportQryInfo['joins'] as $join) {
        if ($join['type'] == 'left') {

          $query->leftJoin($join['table'], $join['column'], '=', $join['on_column']);
        } else {
          $query->join($join['table'], $join['column'], '=', $join['on_column']);
        }
      }
    }

    if ($searchGrps != null)
      if (count($searchGrps) > 0) {

        foreach ($searchGrps as $searchGrp) {
          //dd(print_r($searchGrp));
          $query->orWhere(function ($query) use ($searchGrp) {
            foreach ($searchGrp as $whereClause) {
              //dd(print_r($whereClause));
              $query->where($whereClause->column->alias, $whereClause->operator, $whereClause->value);
            }
          });
        }
      }

    if ($searchGrpsChart != null)
      if (count($searchGrpsChart) > 0) {

        foreach ($searchGrpsChart as $searchGrp) {
          //dd(print_r($searchGrp));
          $query->orWhere(function ($query) use ($searchGrp) {
            foreach ($searchGrp as $whereClause) {
              //dd(print_r($whereClause['column']));
              $query->where($whereClause['column']['name'], $whereClause['operator'], $whereClause['value']);
            }
          });
        }
      }

    $groupedColumns = rtrim($groupedColumns, ',');
    if (strlen($groupedColumns) > 0) {
      $query->groupBy(\DB::raw($groupedColumns));
    }


    //\DB::enableQueryLog(); // Enable query log
    $data = $query->get();
    //dd(\DB::getQueryLog()); // Show results of log
    //dd($data);
    //now process the columns for any link type columns...
    foreach ($reportQryInfo['columns'] as $value) {
      if ($value['isDefault'] == 1 && isset($value['link'])) {
        $link = $value['link'];
        $link = str_replace('_period', isset($input['period']) ? $input['period'] : 'Month', $link);
        for ($i = 0; $i < count($data); $i++) {
          $linkUpdated = str_replace('_' . strtolower($value['alias']), $data[$i]->{$value['alias']}, $link);
          $data[$i]->{$value['alias']} = '<a href="' . site_url($linkUpdated) . '" >' . $data[$i]->{$value['alias']} . '</a>';
        }
      }
    }
    //dd($data);
    return json_encode(['result' => $data]);
  }

  public function save_report_config(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'name' => 'required|unique:user_reports,name',
    ]);
    if ($validator->fails()) {
      $response = [
        'success' => false,
        'message' => [$validator->messages()->first()],
        'msgtype' => 'danger'
      ];

      return json_encode($response);
    }

    $input = $request->all();
    $input['user_id'] = Auth::user()->id;
    $userReport = new UserReport();
    if (!isset($input['module']))
      $input['module'] = '';

    // \DB::enableQueryLog();
    $userReport->save($input);
    // dd(\DB::getQueryLog());

    $response = [
      'success' => true,
      'message' => ['Report Configuration saved successfully!'],
      'msgtype' => 'success'
    ];

    echo json_encode($response);
  }
  public function share_report_config(Request $request)
  {
    // dd($request->all());
    $selected_role_ids = null;
    if (isset($request->role_ids))
      $selected_role_ids = implode(',', $request->role_ids);
    // dd($selected_role_ids);
    $user_reports = UserReport::findOrFail($request->save_report_id);
    $data['module_id'] = $request->module_id;
    $data['role_ids'] = $selected_role_ids;
    $data['name'] = $request->name;
    $data['description'] = $request->description;
    $data['report_name'] = $request->report_name;
    $data['criteria'] = $user_reports->criteria;
    $data['columns'] = $user_reports->columns;
    $data['grouped_columns'] = $user_reports->grouped_columns;
    // $input = $request->all();
    // $input['user_id'] = Auth::user()->id;
    $moduleReport = new ModuleReport();
    $moduleReport->save($data);
    // if (!isset($input['module']))
    //   $input['module'] = '';
    //dd($input);
    // $userReport->save($input);

    $response = [
      'success' => true,
      'message' => ['Report Configuration shared successfully!'],
      'msgtype' => 'success'
    ];

    echo json_encode($response);
  }

  public function getSavedReports()
  {
    $data['reports'] = UserReport::where('user_id', Auth::user()->id)->get();
    echo json_encode($data);
  }

  public function exportPdf(Request $request)
  {
    $input = $request->all();
    // dd($input);
    // $input['user_id'] = Auth::user()->id;
    // $userReport = new UserReport();
    if (!isset($input['module']))
      $input['module'] = '';
    // dd($input);
    $report = $this->getReport($request);
    $report_name = isset($input['title']) ? $input['title'] : $input['report'];
    $data = json_decode($report, true);
    $data['report_name'] =  $report_name;
    $admin_default_setting = AdminDefaultSetting::first();
    $user = User::findOrFail(Auth::id());
    $data['generated_date'] = date('m/d/Y');
    $data['generated_by'] = $user->name;
    $data['museum_name'] = $admin_default_setting->museum_name;
    $data['museum_picture'] = $admin_default_setting->picture;
    // dd($data);
    $new_result = [];
    //Check if report name is group, remove action column from pdf
    if (isset($data['result'][0]['Action'])) {
      //check if result key starts with action unset from array
      foreach ($data['result'] as $key => $value) {
        unset($value['Action']);
        $new_result[] = $value;
      }
      foreach ($data['selectedColumns'] as $key => $value) {
        //check if in selected columns if value of alias is equal to action unset its key from array
        if ($value['Alias'] == 'Action') {
          unset($data['selectedColumns'][$key]);
        }
      }
      //set result new and initialize new result
      $data['result'] = [];
      $data['result'] = $new_result;
    }
    // dd($data);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    // dd($pdf->stream());
    $pdf->loadView('report.exportpdf',  compact('data'));

    // dd(view('report.exportpdf',  compact('data')));


    // $pdf = PDF::loadView('report.exportpdf', compact('data'));
    // $pdf->output();
    // If you want to store the generated pdf to the server then you can use the store function
    $filename = $report_name . ".pdf";
    // dd('pdf/' . $filename);

    $pdf->save('pdf/' . $filename);
    // Finally, you can download the file using download function
    $pdf->download($report_name . ".pdf");
    // $userReport->save($input);
    return $response = [
      'success' => true,
      'filename' => $report_name,
      'message' => ['PDF downloaded successfully!'],
      'msgtype' => 'success'
    ];

    // return json_encode($response);
  }

  public function deleteReport(Request $request)
  {
    // dd($request->all());
    $user_report = UserReport::findOrFail($request->report_id);
    $user_report_name = $user_report->name;
    $user_report->delete();
    return $response = [
      'success' => true,
      'message' => [$user_report_name . ' report deleted successfully!'],
      'msgtype' => 'success'
    ];
  }

  public function deleteSharedReport(Request $request)
  {
    // dd($request->all());
    $module_report = ModuleReport::findOrFail($request->report_id);
    $module_report_name = $module_report->name;
    $module_report->delete();
    return $response = [
      'success' => true,
      'message' => [$module_report_name . ' report deleted successfully!'],
      'msgtype' => 'success'
    ];
  }

  public function editReport(Request $request)
  {
    // dd($request->all());

    if ($request->edit == "true") {

      if ($request->module_report != "true") {
        $validator = Validator::make($request->all(), [
          'name' => "required|unique:user_reports,name," . $request->save_report_id,
        ]);
        if ($validator->fails()) {
          $response = [
            'success' => false,
            'message' => [$validator->messages()->first()],
            'msgtype' => 'danger'
          ];

          return json_encode($response);
        }

        $user_reports = UserReport::findOrFail($request->save_report_id);

        if ($user_reports) {
          $name = $request->name;
          $description = $request->description;
          UserReport::where('id', $request->save_report_id)->update(['name' => $name, 'description' => $description]);
          $response = [
            'success' => true,
            'message' => ['Report edited successfully!'],
            'msgtype' => 'success'
          ];

          echo json_encode($response);
        } else {
          $response = [
            'success' => false,
            'message' => ['Report not found correctly!'],
            'msgtype' => 'danger'
          ];

          echo json_encode($response);
        }
      } else {

        $validator = Validator::make($request->all(), [
          'name' => "required|unique:module_reports,name," . $request->save_report_id,
        ]);
        if ($validator->fails()) {
          $response = [
            'success' => false,
            'message' => [$validator->messages()->first()],
            'msgtype' => 'danger'
          ];

          return json_encode($response);
        }

        $module_reports = ModuleReport::findOrFail($request->save_report_id);

        if ($module_reports) {
          $name = $request->name;
          $description = $request->description;
          ModuleReport::where('id', $request->save_report_id)->update(['name' => $name, 'description' => $description]);
          $response = [
            'success' => true,
            'message' => ['Report edited successfully!'],
            'msgtype' => 'success'
          ];

          echo json_encode($response);
        } else {
          $response = [
            'success' => false,
            'message' => ['Report not found correctly!'],
            'msgtype' => 'danger'
          ];

          echo json_encode($response);
        }
      }
    } else {
      $response = [
        'success' => false,
        'message' => ['Edit not found'],
        'msgtype' => 'danger'
      ];

      echo json_encode($response);
    }
  }

  public function moveReport(Request $request)
  {
    $module_reports = ModuleReport::findOrFail($request->save_report_id);

    if ($module_reports) {
      $module_id = $request->module_id;
      $description = $request->description;
      ModuleReport::where('id', $request->save_report_id)->update(['module_id' => $module_id]);
      $response = [
        'success' => true,
        'message' => ['Report moved successfully!'],
        'msgtype' => 'success'
      ];

      echo json_encode($response);
    } else {
      $response = [
        'success' => false,
        'message' => ['Report not moved correctly!'],
        'msgtype' => 'danger'
      ];

      echo json_encode($response);
    }
  }
}
