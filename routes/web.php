<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('student', StudentController::class);
// Route::resource('company', 'CompanyController');
// Route::resource('companies', 'CompaniesController');
// fahad ahmed

// Route::group(['middleware' => ['activity']], function () {
Route::get('/', function () {
    if (Auth::user()) {
        $redirectUrl = Auth::user()->roles()->orderBy('preference', 'desc')->whereNotNull('preference')->whereNotNull('landing_page')->first();

        if (!empty($redirectUrl)) {
            if (strlen(trim($redirectUrl->landing_page))) {
                return redirect($redirectUrl->landing_page);
            }
        } else {
            return redirect('home');
        }
    } else {
        return view('auth/login');
    }
});
Auth::routes();

Route::get('/home', function () {
    return view('home');
});

/* company routes */
Route::get('companies', 'CompaniesController@index');
Route::get('getCompanies', 'CompaniesController@getCompanies');
Route::post('companies', 'CompaniesController@store');
Route::post('companies/del', 'CompaniesController@destroy');
Route::post('companies/{id}', 'CompaniesController@update');
Route::get('companies/delete/{id}', 'CompaniesController@delete');

/* bookings routes */
Route::get('bookings', 'BookingsController@index')->middleware('permission:can-view-booking');
Route::post('bookings/getData', 'BookingsController@getData')->middleware('permission:can-view-booking');
Route::get('bookings/find/{id}', 'BookingsController@show')->middleware('permission:can-add-booking');
Route::get('getBookings', 'BookingsController@getBookings')->middleware('permission:can-view-booking');
Route::post('searchRooms', 'BookingsController@searchRooms')->middleware('permission:can-add-booking');
Route::post('findCustomer', 'BookingsController@findCustomer')->middleware('permission:can-add-booking');
// Route::post('findAgent', 'BookingsController@findAgent')->middleware('permission:can-add-booking');
Route::post('searchPromotion', 'BookingsController@searchPromo')->middleware('permission:can-add-booking');
Route::post('bookings/filter', 'BookingsController@filter')->middleware('permission:can-view-booking');
Route::post('bookings', 'BookingsController@store')->middleware('permission:can-add-booking');
Route::post('bookings/cancel/{id}', 'BookingsController@cancelBooking')->middleware('permission:can-cancel-booking');
Route::post('resendBookingInvoice', 'BookingsController@resendInvoice')->middleware('permission:can-add-booking');
Route::post('bookings/checkout', 'BookingsController@checkout')->middleware('permission:can-edit-booking');
// Route::post('bookings/{id}', 'BookingsController@update')->middleware('permission:can-edit-booking');
Route::post('findOccupant', 'BookingsController@findOccupant')->middleware('permission:can-add-booking');
Route::post('bookings/changeStatus', 'BookingsController@changeStatus')->middleware('permission:can-edit-booking');
Route::post('bookings/find_room_booking', 'BookingsController@findRoomBooking')->middleware('permission:can-view-booking');
Route::post('bookings/resend_room_email', 'BookingsController@resendRoomEmail')->middleware('permission:can-view-booking');
Route::post('bookings/request_or_complain', 'BookingsController@requestServiceComplain')->middleware('permission:can-view-booking');
Route::post('bookings/extend', 'BookingsController@extendBooking')->middleware('permission:can-view-booking');
Route::get('bookings/receipt/{id}', 'BookingsController@bookingReceipt')->middleware('permission:can-edit-booking');
Route::post('bookings/payment/add', 'BookingsController@addTransaction')->middleware('permission:can-edit-booking');
Route::post('bookings/transfer/search', 'BookingsController@searchForTransfer')->middleware('permission:can-edit-booking');
Route::post('bookings/transfer/request', 'BookingsController@requestForTransfer')->middleware('permission:can-edit-booking');
Route::post('checkRoomAvailability', 'BookingsController@checkRoomAvailability')->middleware('permission:can-edit-booking');
Route::post('search-customers', 'BookingsController@searchCustomers')->middleware('permission:can-add-booking');

// FrontDesk
Route::get('frontdesk', 'BookingsController@frontdesk')->middleware('permission:can-view-booking');
// Route::get('bookings/find/{id}', 'BookingsController@show')->middleware('permission:can-add-booking');
// Route::get('getBookings','BookingsController@getBookings')->middleware('permission:can-view-booking');
// Route::post('searchRooms', 'BookingsController@searchRooms')->middleware('permission:can-add-booking');
// Route::post('findCustomer', 'BookingsController@findCustomer')->middleware('permission:can-add-booking');
// Route::post('searchPromotion', 'BookingsController@searchPromo')->middleware('permission:can-add-booking');
// Route::post('bookings/filter', 'BookingsController@filter')->middleware('permission:can-view-booking');
// Route::post('bookings', 'BookingsController@store')->middleware('permission:can-add-booking');
// Route::post('bookings/cancel/{id}', 'BookingsController@cancelBooking')->middleware('permission:can-cancel-booking');
// Route::post('resendBookingInvoice', 'BookingsController@resendInvoice')->middleware('permission:can-add-booking');
// Route::post('bookings/checkout', 'BookingsController@checkout')->middleware('permission:can-edit-booking');
// Route::post('bookings/{id}', 'BookingsController@update')->middleware('permission:can-edit-booking');
// Route::post('findOccupant', 'BookingsController@findOccupant')->middleware('permission:can-add-booking');

/*  users routes */
Route::get('users', 'UsersController@index')->middleware('permission:can-view-user');
Route::get('getUsers', 'UsersController@getUsers')->middleware('permission:can-view-user');
Route::post('users', 'UsersController@store')->middleware('permission:can-add-user');
Route::post('users/del', 'UsersController@destroy')->middleware('permission:can-delete-user');
Route::post('users/{id}', 'UsersController@update')->middleware('permission:can-edit-user');
Route::post('admin/saveProfilePicture', 'UsersController@saveProfilePicture')->middleware('permission:can-add-user');
Route::post('resendPassword', 'UsersController@resendPassword')->middleware('permission:can-edit-user');
Route::post('saveAddress', 'UsersController@saveAddress')->middleware('permission:can-edit-user');
Route::post('removeAddress', 'UsersController@removeAddress')->middleware('permission:can-edit-user');

/* roles routes */
Route::get('roles', 'RolesController@index')->middleware('permission:can-view-role');
Route::get('getRolesData', 'RolesController@get')->middleware('permission:can-view-role');
Route::post('addRole', 'RolesController@create')->middleware('permission:can-add-role');
Route::get('getRolesUserData', 'RolesController@getRolesData')->middleware('permission:can-view-role');
Route::post('removeRole', 'RolesController@delete')->middleware('permission:can-delete-role');
Route::post('assignUserRole', 'RolesController@assignUserRole')->middleware('permission:can-edit-user');
Route::post('removeUserRole', 'RolesController@removeUserRole')->middleware('permission:can-edit-user');

/* Permission Routes */
Route::get('permissions', 'PermissionController@index')->middleware('permission:can-view-permission');
Route::get('getPermissions', 'PermissionController@get')->middleware('permission:can-view-permission');
Route::get('getAdminPermissions', 'PermissionController@getall')->middleware('permission:can-view-permission');
Route::post('addPermission', 'PermissionController@create')->middleware('permission:can-add-permission');
Route::post('removePermission', 'PermissionController@delete')->middleware('permission:can-delete-permission');
Route::get('generatePermissions', 'PermissionController@generate')->middleware('permission:can-add-permission');
// });

//Profile
Route::get('profile', 'ProfileController@index');
Route::post('getProfile', 'ProfileController@getProfile');
Route::post('changePassword', 'ProfileController@changePassword');
Route::post('updateProfile', 'ProfileController@updateProfile');
Route::get('change_first_password', 'ProfileController@change_first_password');

/* Auth */
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('companies', 'CompaniesController@index');
Route::get('getCompanies', 'CompaniesController@getCompanies');
Route::post('companies', 'CompaniesController@store');
Route::post('companies/del', 'CompaniesController@destroy');
Route::post('companies/{id}', 'CompaniesController@update');
Route::get('companies/delete/{id}', 'CompaniesController@delete');

Route::get('cities', 'CitiesController@index');
Route::get('getCitiesCity', 'CitiesController@getCitiesCity');
Route::get('getCountryList', 'CitiesController@getCountryList');
Route::post('cities', 'CitiesController@store');
Route::post('cities/del', 'CitiesController@destroy');
Route::post('cities/{id}', 'CitiesController@update');
Route::get('cities/delete/{id}', 'CitiesController@delete');
Route::get('getStateList', 'CitiesController@getStateList');

Route::get('countries', 'CountriesController@index');
Route::get('getCountries', 'CountriesController@getCountries');
Route::post('countries', 'CountriesController@store');
Route::post('countries/del', 'CountriesController@destroy');
Route::post('countries/{id}', 'CountriesController@update');
Route::get('countries/delete/{id}', 'CountriesController@delete');

Route::get('states', 'StatesController@index');
Route::get('getStatesState', 'StatesController@getStatesState');
Route::post('states', 'StatesController@store');
Route::post('states/del', 'StatesController@destroy');
Route::post('states/{id}', 'StatesController@update');
Route::get('states/delete/{id}', 'StatesController@delete');

Route::get('contacttypes', 'ContactTypesController@index');
Route::get('getContactTypes', 'ContactTypesController@getContactTypes');
Route::post('contacttypes', 'ContactTypesController@store');
Route::post('contacttypes/del', 'ContactTypesController@destroy');
Route::post('contacttypes/{id}', 'ContactTypesController@update');
Route::get('contacttypes/delete/{id}', 'ContactTypesController@delete');

Route::get('taxrates', 'TaxRatesController@index');
Route::get('getTaxRates', 'TaxRatesController@getTaxRates');
Route::post('taxrates', 'TaxRatesController@store');
Route::post('taxrates/del', 'TaxRatesController@destroy');
Route::post('taxrates/{id}', 'TaxRatesController@update');
Route::get('taxrates/delete/{id}', 'TaxRatesController@delete');

Route::get('rooms', 'RoomsController@index');
Route::get('getRooms', 'RoomsController@getRooms');
Route::get('getRoomTypes', 'RoomsController@getRoomTypes');
Route::get('getRoomCategories', 'RoomsController@getRoomCategories');
Route::get('getTaxRates', 'RoomsController@getTaxRates');
Route::get('getHotels', 'RoomsController@getHotels');
Route::post('rooms', 'RoomsController@store');
Route::post('rooms/del', 'RoomsController@destroy');
Route::post('rooms/{id}', 'RoomsController@update');
Route::get('rooms/delete/{id}', 'RoomsController@delete');

Route::get('categoryfacilities', 'CategoryFacilitiesController@index');
Route::get('getCategoryFacilities', 'CategoryFacilitiesController@getCategoryFacilities');
Route::get('getFacilities', 'CategoryFacilitiesController@getFacilities');
Route::get('getDropDownfacilities', 'CategoryFacilitiesController@getDropDownfacilities');
// Route::get('postData', 'CategoryFacilitiesController@postData');
Route::post('categoryfacilities', 'CategoryFacilitiesController@store');
Route::post('categoryfacilities/del', 'CategoryFacilitiesController@destroy');
Route::post('categoryfacilities/{id}', 'CategoryFacilitiesController@update');
Route::get('categoryfacilities/delete/{id}', 'CategoryFacilitiesController@delete');
Route::get('getRoomCategories', 'CategoryFacilitiesController@getRoomCategories');

Route::get('facilities', 'FacilitiesController@index');
Route::get('getFacilities', 'FacilitiesController@getFacilities');
Route::post('facilities', 'FacilitiesController@store');
Route::post('facilities/del', 'FacilitiesController@destroy');
Route::post('facilities/{id}', 'FacilitiesController@update');
Route::get('facilities/delete/{id}', 'FacilitiesController@delete');
// Route::post('saveIconPath', 'FacilitiesController@saveIconPath');
// Route::post("upload", "FacilitiesController@upload");
Route::post("upload/file", "FacilitiesController@upload");

Route::get('roomtypes', 'RoomTypesController@index');
Route::get('getRoomTypes', 'RoomTypesController@getRoomTypes');
Route::post('roomtypes', 'RoomTypesController@store');
Route::post('roomtypes/del', 'RoomTypesController@destroy');
Route::post('roomtypes/{id}', 'RoomTypesController@update');
Route::get('roomtypes/delete/{id}', 'RoomTypesController@delete');

Route::get('servicetypes', 'ServiceTypesController@index');
Route::get('getServiceTypes', 'ServiceTypesController@getServiceTypes');
Route::post('servicetypes', 'ServiceTypesController@store');
Route::post('servicetypes/del', 'ServiceTypesController@destroy');
Route::post('servicetypes/{id}', 'ServiceTypesController@update');
Route::get('servicetypes/delete/{id}', 'ServiceTypesController@delete');

// Route::get('roomcategories', 'RoomCategoriesController@index');
// Route::get('getRoomCategories', 'RoomCategoriesController@getRoomCategories');
// Route::post('roomcategories', 'RoomCategoriesController@store');
// Route::post('roomcategories/del', 'RoomCategoriesController@destroy');
// Route::post('roomcategories/{id}', 'RoomCategoriesController@update');
// Route::get('roomcategories/delete/{id}', 'RoomCategoriesController@delete');

Route::get('roomservices', 'RoomServicesController@index');
Route::get('getRoomServices', 'RoomServicesController@getRoomServices');
Route::post('roomservices', 'RoomServicesController@store');
Route::post('roomservices/del', 'RoomServicesController@destroy');
Route::post('roomservices/{id}', 'RoomServicesController@update');
Route::get('roomservices/delete/{id}', 'RoomServicesController@delete');

Route::get('departments', 'DepartmentsController@index');
Route::get('getDepartmentsDepartment', 'DepartmentsController@getDepartmentsDepartment');
Route::get('getCompanies', 'DepartmentsController@getCompanies');
Route::get('getStates', 'DepartmentsController@getStates');
Route::post('departments', 'DepartmentsController@store');
Route::post('departments/del', 'DepartmentsController@destroy');
Route::post('departments/{id}', 'DepartmentsController@update');
Route::get('departments/delete/{id}', 'DepartmentsController@delete');

Route::get('hotels', 'HotelsController@index');
Route::get('getHotels', 'HotelsController@getHotels');
Route::get('getCurrentHotels', 'HotelsController@getCurrentHotels');
Route::get('getCompanies', 'HotelsController@getCompanies');
Route::get('getCities', 'HotelsController@getCities');
Route::post('hotels', 'HotelsController@store');
Route::post('hotels/del', 'HotelsController@destroy');
Route::post('hotels/{id}', 'HotelsController@update');
Route::get('hotels/delete/{id}', 'HotelsController@delete');

Route::get('hotelcontacts', 'HotelContactsController@index');
Route::get('getHotelContacts', 'HotelContactsController@getHotelContacts');
Route::get('getHotel', 'HotelContactsController@getHotel');
Route::get('getContactTypes', 'HotelContactsController@getContactTypes');
Route::post('hotelcontacts', 'HotelContactsController@store');
Route::post('hotelcontacts/del', 'HotelContactsController@destroy');
Route::post('hotelcontacts/{id}', 'HotelContactsController@update');
Route::get('hotelcontacts/delete/{id}', 'HotelContactsController@delete');

Route::get('relations', 'RelationsController@index');
Route::get('getRelations', 'RelationsController@getRelations');
Route::post('relations', 'RelationsController@store');
Route::post('relations/del', 'RelationsController@destroy');
Route::post('relations/{id}', 'RelationsController@update');
Route::get('relations/delete/{id}', 'RelationsController@delete');

Route::get('paymentmodes', 'PaymentModesController@index');
Route::get('getPaymentModes', 'PaymentModesController@getPaymentModes');
Route::post('paymentmodes', 'PaymentModesController@store');
Route::post('paymentmodes/del', 'PaymentModesController@destroy');
Route::post('paymentmodes/{id}', 'PaymentModesController@update');
Route::get('paymentmodes/delete/{id}', 'PaymentModesController@delete');

Route::get('services', 'ServicesController@index');
Route::get('getServices', 'ServicesController@getServices');
Route::get('getDepartments', 'ServicesController@getDepartments');
Route::get('getServiceTypes', 'ServicesController@getServiceTypes');
Route::post('services', 'ServicesController@store');
Route::post('services/del', 'ServicesController@destroy');
Route::post('services/{id}', 'ServicesController@update');
Route::get('services/delete/{id}', 'ServicesController@delete');

// room category new routes
Route::get('rcategories', 'RCategoriesController@index');
Route::get('getrCategories', 'RCategoriesController@getrCategories');
Route::post('rcategories', 'RCategoriesController@store');
Route::post('rcategories/del', 'RCategoriesController@destroy');
Route::post('rcategories/{id}', 'RCategoriesController@update');
Route::get('rcategories/delete/{id}', 'RCategoriesController@delete');

// room new routes
Route::get('nrooms', 'RoomController@index')->middleware('permission:can-view-room');
Route::get('getnRooms', 'RoomController@getnRooms')->middleware('permission:can-view-room');
Route::get('getRoomBookings', 'RoomController@getRoomBookings')->middleware('permission:can-view-room');
Route::post('nrooms', 'RoomController@store')->middleware('permission:can-add-room');
Route::post('nrooms/del', 'RoomController@destroy')->middleware('permission:can-delete-room');
Route::post('nrooms/{id}', 'RoomController@update')->middleware('permission:can-edit-room');
Route::get('nrooms/delete/{id}', 'RoomController@delete')->middleware('permission:can-delete-room');

// Locale
Route::get('locale', 'LocaleController@index')->middleware('permission:can-view-locale');
Route::post('locale/initData', 'LocaleController@init')->middleware('permission:can-view-locale');
Route::post('locale/deleteCountry', 'LocaleController@deleteCountry')->middleware('permission:can-delete-locale');
Route::post('locale/deleteState', 'LocaleController@deleteState')->middleware('permission:can-delete-locale');
Route::post('locale/deleteCity', 'LocaleController@deleteCity')->middleware('permission:can-delete-locale');
Route::post('locale/saveCountry', 'LocaleController@storeCountry')->middleware('permission:can-add-locale');
Route::post('locale/saveState', 'LocaleController@storeState')->middleware('permission:can-add-locale');
Route::post('locale/saveCity', 'LocaleController@storeCity')->middleware('permission:can-add-locale');
Route::post('locale/saveHotelCategory', 'LocaleController@storeHotelCategory')->middleware('permission:can-add-locale');
Route::post('locale/deleteHotelCategory', 'LocaleController@deleteHotelCategory')->middleware('permission:can-delete-locale');

// service new routes
Route::get('ndepartments', 'DepartmentController@index')->middleware('permission:can-view-department');
Route::get('getnDepartments', 'DepartmentController@getnDepartments')->middleware('permission:can-view-department');
Route::post('ndepartments', 'DepartmentController@store')->middleware('permission:can-add-department');
Route::post('ndepartments/del', 'DepartmentController@destroy')->middleware('permission:can-delete-department');
Route::post('ndepartments/{id}', 'DepartmentController@update')->middleware('permission:can-edit-department');
Route::get('ndepartments/delete/{id}', 'DepartmentController@delete')->middleware('permission:can-delete-department');
Route::post('saveService', 'DepartmentController@saveService')->middleware('permission:can-add-service');
Route::post('removeService', 'DepartmentController@removeService')->middleware('permission:can-delete-service');

// type management types

Route::get('types', 'TypeManagementController@index')->middleware('permission:can-view-lookup');
Route::get('getTypeManagement', 'TypeManagementController@getTypeManagement')->middleware('permission:can-view-lookup');
Route::post('types/saveCType', 'TypeManagementController@saveCType')->middleware('permission:can-add-lookup');
Route::post('types/deleteCType', 'TypeManagementController@deleteCType')->middleware('permission:can-delete-lookup');

Route::post('types/saveChannel', 'TypeManagementController@saveChannel')->middleware('permission:can-add-lookup');
Route::post('types/deleteChannel', 'TypeManagementController@deleteChannel')->middleware('permission:can-delete-lookup');

Route::post('types/saveSType', 'TypeManagementController@saveSType')->middleware('permission:can-add-lookup');
Route::post('types/deleteSType', 'TypeManagementController@deleteSType')->middleware('permission:can-delete-lookup');

Route::post('types/saveRType', 'TypeManagementController@saveRType')->middleware('permission:can-add-lookup');
Route::post('types/deleteRType', 'TypeManagementController@deleteRType')->middleware('permission:can-delete-lookup');

Route::post('types/saveRel', 'TypeManagementController@saveRel')->middleware('permission:can-add-lookup');
Route::post('types/deleteRel', 'TypeManagementController@deleteRel')->middleware('permission:can-delete-lookup');

Route::post('types/saveTaxRate', 'TypeManagementController@saveTaxRate')->middleware('permission:can-add-lookup');
Route::post('types/deleteTaxRate', 'TypeManagementController@deleteTaxRate')->middleware('permission:can-delete-lookup');

Route::post('saveImages', 'RoomController@saveImages');

// Hotel Management
Route::get('hotel', 'HotelController@index')->middleware('permission:can-view-hotel');
Route::post('hotel/get', 'HotelController@getData')->middleware('permission:can-view-hotel');
Route::post('hotel/deleteHotel', 'HotelController@deleteHotel')->middleware('permission:can-delete-hotel');
Route::post('hotel/deleteContact', 'HotelController@deleteContact')->middleware('permission:can-delete-hotel');
Route::post('hotel/saveHotel', 'HotelController@saveHotel')->middleware('permission:can-add-hotel');
Route::post('hotel/saveContact', 'HotelController@saveContact')->middleware('permission:can-add-hotel');
Route::get('hotel/testing', 'HotelController@testHotel')->middleware('permission:can-add-hotel');

Route::post('hotel/get_account_gl_hotel_mappings', 'HotelController@get_account_gl_hotel_mappings')->middleware('permission:can-add-hotel');
Route::post('hotel/saveHotelGlAccountMapping', 'HotelController@saveHotelGlAccountMapping');
// ->middleware('permission:can-edit-gl-account-mapping');



// service new routes
Route::get('promotions', 'PromotionsController@index')->middleware('permission:can-view-promotion');
Route::get('getPromotions', 'PromotionsController@getPromotions')->middleware('permission:can-view-promotion');
Route::post('promotions', 'PromotionsController@store')->middleware('permission:can-add-promotion');
Route::post('promotions/del', 'PromotionsController@destroy')->middleware('permission:can-delete-promotion');
Route::post('promotions/{id}', 'PromotionsController@update')->middleware('permission:can-edit-promotion');
Route::get('promotions/delete/{id}', 'PromotionsController@delete')->middleware('permission:can-delete-promotion');

// service new routes
Route::get('dashboard', 'DashboardController@index')->middleware('permission:can-view-report');
Route::get('getRecords', 'DashboardController@getRecords')->middleware('permission:can-view-report');

Route::get('getIcons', 'FacilitiesController@getIcons');

// reports
Route::get('reports', 'ReportController@index')->middleware('permission:can-view-report');
Route::get('getReportColumns', 'ReportController@getReportColumns')->middleware('permission:can-view-report');
Route::get('getModules', 'ReportController@getModules')->middleware('permission:can-view-report');
Route::get('getSavedReports', 'ReportController@getSavedReports')->middleware('permission:can-view-report');
Route::get('criteria', 'ReportController@criteria')->middleware('permission:can-view-report');
Route::get('report', 'ReportController@report')->middleware('permission:can-view-report');
Route::get('getReport', 'ReportController@getReport')->middleware('permission:can-view-report');
Route::post('exportPdf', 'ReportController@exportPdf')->middleware('permission:can-view-report');
Route::post('saveReportConfig', 'ReportController@save_report_config');
Route::get('getRoles', function () {
    $data = App\Models\Role::whereNotIn('name', ['superadmin', 'guest'])->orderBy('display_name', 'ASC')->get();
    echo json_encode(['success' => true, 'payload' => $data]);
});
Route::post('shareReportConfig', 'ReportController@share_report_config')->middleware('permission:can-view-report');

// partners
Route::get('partners', 'PartnersController@index')->middleware('permission:can-view-partner');
Route::get('getPartners', 'PartnersController@getPartners')->middleware('permission:can-view-partner');
Route::post('partners', 'PartnersController@store')->middleware('permission:can-add-partner');
Route::post('partners/del', 'PartnersController@destroy')->middleware('permission:can-delete-partner');
Route::post('partners/{id}', 'PartnersController@update')->middleware('permission:can-edit-partner');
Route::get('partners/delete/{id}', 'PartnersController@delete')->middleware('permission:can-delete-partner');

// housekeeping and service requests
Route::get('customerservices/{code}', 'HouseKeepingController@index');
Route::get('getCustomer/{code}', 'HouseKeepingController@getCustomer');
Route::post('saveComplain', 'HouseKeepingController@saveComplain');
Route::post('saveRequest', 'HouseKeepingController@saveRequest');
Route::get('getDeptServices/{id}', 'HouseKeepingController@getDeptServices');
// Route::get('get_booking_services', 'HouseKeepingController@getBookingServices');
// Route::get('get_booking_services_count', 'HouseKeepingController@getBooKingServiceCount');

Route::get('get_booking_services', 'BookingsController@getBookingServices');
Route::get('get_booking_services_count', 'BookingsController@getBooKingServiceCount');

// complain view
Route::get('complains', 'ComplainController@index')->middleware('permission:can-view-complain');
Route::get('complainsData', 'ComplainController@getData')->middleware('permission:can-view-complain');
Route::get('getComplains', 'ComplainController@getComplains')->middleware('permission:can-view-complain');
Route::post('complain/setPriority', 'ComplainController@setPriority')->middleware('permission:can-view-complain');
Route::post('complain/setDepartment', 'ComplainController@setDepartment')->middleware('permission:can-view-complain');
Route::post('complain/setStatus', 'ComplainController@setStatus')->middleware('permission:can-edit-complain');

// requests view
Route::get('discountrequests', 'DiscountRequestController@index')->middleware('permission:can-view-discount-request');
Route::get('discountrequestsData', 'DiscountRequestController@getData')->middleware('permission:can-view-discount-request');
Route::get('getDiscountRequests', 'DiscountRequestController@getDiscountRequests')->middleware('permission:can-view-discount-request|can-only-view-discount-request');
Route::post('discountrequest/setStatus', 'DiscountRequestController@setStatus')->middleware('permission:can-edit-discount-request');
Route::get('my_requests', 'DiscountRequestController@index')->middleware('permission:can-only-view-discount-request');

// service requests
Route::get('bookingservices', 'BookingServicesController@index');
Route::get('getHotelRooms', 'BookingServicesController@getHotelRooms');
Route::post('saveTask', 'BookingServicesController@saveTask');

// tasks
Route::get('tasks', 'TaskManagementController@index')->middleware('permission:can-view-task');
Route::post('getTasks', 'TaskManagementController@getTasks')->middleware('permission:can-view-task');
Route::get('get_departments', 'TaskManagementController@getDepartments')->middleware('permission:can-view-task');
Route::post('task/updateStatus', 'TaskManagementController@updateStatus')->middleware('permission:can-edit-task');

// inventory
Route::get('inventory', 'InventoryController@index')->middleware('permission:can-view-inventory');
Route::post('getInventories', 'InventoryController@getInventories')->middleware('permission:can-view-inventory');
Route::post('inventory', 'InventoryController@store')->middleware('permission:can-add-inventory');
Route::post('inventory/{id}', 'InventoryController@update')->middleware('permission:can-edit-inventory');

Route::get('purchase_orders', 'PurchaseOrderController@index')->middleware('permission:can-view-purchase-order');
Route::post('PurchaseOrder', 'PurchaseOrderController@store');
Route::post('PurchaseOrder/{id}', 'PurchaseOrderController@update');
Route::post('delete_purchase_order', 'PurchaseOrderController@delete');
Route::post('purchase_orders/{id}', 'PurchaseOrderController@update')->middleware('permission:can-edit-purchase-order');
Route::post('getPurchaseOrders', 'PurchaseOrderController@getPurchaseOrders')->middleware('permission:can-view-purchase-order');

//goods recieve notes
Route::get('goods_receive_notes', 'GoodsReceiveNoteController@index')->middleware('permission:can-view-goods_receive_note');
Route::post('goods_receive_notes', 'GoodsReceiveNoteController@store')->middleware('permission:can-add-goods_receive_note');
Route::post('goods_receive_notes/{id}', 'GoodsReceiveNoteController@update')->middleware('permission:can-edit-goods_receive_note');
Route::post('po_grn/get', 'GoodsReceiveNoteController@getPO_GRN')->middleware('permission:can-edit-goods_receive_note');
Route::post('getGoodsReceiveNotes', 'GoodsReceiveNoteController@getGoodsReceiveNotes')->middleware('permission:can-view-goods_receive_note');
Route::post('delete_gnr', 'GoodsReceiveNoteController@delete');

Route::get('vendors', 'VendorController@index')->middleware('permission:can-view-vendor');
Route::post('vendors', 'VendorController@store')->middleware('permission:can-add-vendor');
Route::post('vendors/{id}', 'VendorController@update')->middleware('permission:can-edit-vendor');
Route::post('getVendors', 'VendorController@getVendors')->middleware('permission:can-view-vendor');

// corporate_clients
Route::get('corporate_clients', 'CorporateClientController@index')->middleware('permission:can-view-corporate-client');
Route::get('getClients', 'CorporateClientController@getClients')->middleware('permission:can-view-corporate-client');
Route::post('clients', 'CorporateClientController@store')->middleware('permission:can-add-corporate-client');
Route::post('clients/del', 'CorporateClientController@destroy')->middleware('permission:can-delete-corporate-client');
Route::post('clients/{id}', 'CorporateClientController@update')->middleware('permission:can-edit-corporate-client');
Route::get('clients/delete/{id}', 'CorporateClientController@delete')->middleware('permission:can-delete-corporate-client');

// excel upload clients
Route::post('/importExcel', 'CorporateClientController@importExcel');

// customers
Route::get('customers', 'CustomersController@index')->middleware('permission:can-view-customers');
Route::get('getCustomers', 'CustomersController@getCustomers')->middleware('permission:can-view-customers');
Route::post('customers', 'CustomersController@store')->middleware('permission:can-add-customers');
Route::post('customers/del', 'CustomersController@destroy')->middleware('permission:can-delete-customers');
Route::post('customers/{id}', 'CustomersController@update')->middleware('permission:can-edit-customers');
Route::post('customer/blacklist', 'CustomersController@blacklistCustomer')->middleware('permission:can-edit-customers');

Route::get('customers/delete/{id}', 'CustomersController@delete')->middleware('permission:can-delete-customers');

// Room Dashboard for admin
Route::get('room_dashboard', 'BookingsController@getRoomDashboard')->middleware('permission:can-view-room-dashboard');

// account management lookups
Route::get('account_lookups', 'AccountLookupController@index')->middleware('permission:can-view-accounts');
Route::get('getAccountLookups', 'AccountLookupController@getAccountLookups')->middleware('permission:can-view-accounts');
// account types
Route::post('account/types', 'AccountLookupController@saveAccountType')->middleware('permission:can-add-accounts');
Route::post('accounts/deleteType', 'AccountLookupController@deleteAccountType')->middleware('permission:can-delete-accounts');
// account types
Route::post('account/subtypes', 'AccountLookupController@saveAccountSubType')->middleware('permission:can-add-accounts');
Route::post('accounts/deleteSubType', 'AccountLookupController@deleteAccountSubType')->middleware('permission:can-delete-accounts');

// voucher types
Route::post('voucher/types', 'AccountLookupController@saveVoucherType')->middleware('permission:can-add-accounts');
Route::post('vouchers/deleteType', 'AccountLookupController@deleteVoucherType')->middleware('permission:can-delete-accounts');
// account levels
Route::post('account/levels', 'AccountLookupController@saveAccountLevel')->middleware('permission:can-add-accounts');
Route::post('accounts/deleteLevel', 'AccountLookupController@deleteAccountLevel')->middleware('permission:can-delete-accounts');
// account natures
Route::post('account/salestax', 'AccountLookupController@saveAccountSalesTax')->middleware('permission:can-add-accounts');
Route::post('accounts/deleteSalesTax', 'AccountLookupController@deleteAccountSalesTax')->middleware('permission:can-delete-accounts');

// accounts fiscal years
Route::get('account_fiscalyears', 'FiscalYearController@index');
Route::get('getFiscalYears', 'FiscalYearController@getFiscalYears');
Route::post('fiscalyears', 'FiscalYearController@store');
Route::post('fiscalyears/del', 'FiscalYearController@destroy');
Route::post('fiscalyears/{id}', 'FiscalYearController@update');

// accounts general ledgers
Route::get('account_general_ledgers', 'GeneralLedgerController@index');
Route::get('getGeneralLedgers', 'GeneralLedgerController@getGeneralLedgers');
Route::post('general_ledgers', 'GeneralLedgerController@store');
Route::post('general_ledgers/del', 'GeneralLedgerController@destroy');
Route::post('general_ledgers/{id}', 'GeneralLedgerController@update');
Route::post('findGLCode', 'GeneralLedgerController@findGLCode');

Route::get('ledger', 'LedgerController@index');
Route::get('getAccountGL', 'LedgerController@getAccountGL');
// Route::get('get_status_and_accountGL', 'LedgerController@get_status_and_accountGL');
Route::post('get_ledger', 'LedgerController@get_ledger');
Route::post('pdfview', 'LedgerController@pdfview');

// accounts vouchers
Route::get('vouchers', 'VoucherController@index');
Route::get('getVouchers', 'VoucherController@getVouchers');
Route::post('vouchers', 'VoucherController@store');
Route::post('vouchers/del', 'VoucherController@destroy');
Route::post('voucher_detail/del', 'VoucherController@destroy_detail');
Route::post('voucher_detail/add', 'VoucherController@add_single_detail');
Route::post('vouchers/{id}', 'VoucherController@update');

// posted vouchers
Route::get('posted_vouchers', 'VoucherController@postedvouchers');
Route::get('getPostedVouchers', 'VoucherController@getPostedVouchers');
Route::post('voucher_approve', 'VoucherController@aproval');

Route::get('trialbalancesheet', 'TrialBalanceSheetController@index');
Route::post('trial_balance_sheet', 'TrialBalanceSheetController@TrialBalanceSheet');
Route::get('levels_fiscalyears', 'TrialBalanceSheetController@getLevels_FiscalYear');
Route::post('tb_pdfview', 'TrialBalanceSheetController@tb_pdfview');

// accept reject booking service

Route::post('accept_booking_service', 'HouseKeepingController@acceptRejectBookingService');
Route::post('cancel_booking_service', 'HouseKeepingController@cancelBookingService');

// hotelbookingservices

Route::get('hotel_booking_services', 'HotelBookingServicesController@index');
Route::post('get_hotel_booking_services', 'HotelBookingServicesController@getData');
Route::get('get_hotels', 'HotelBookingServicesController@getHotels');
Route::post('get_filter_booking_services', 'HotelBookingServicesController@getFilterData');
Route::post('accept_reject_booking_service', 'HotelBookingServicesController@acceptRejectBookingService');
// Route::post('cancel_booking_service', 'HotelBookingServicesController@cancelBookingService');
Route::post('cancel_booking_service/{id}', 'HotelBookingServicesController@cancelBookingService');

// leaveRequest
Route::post('leave_request', 'ProfileController@saveLeaveRequest');
Route::post('get_leaves', 'ProfileController@getLeaves');

// all leaves
Route::get('all_leaves', 'LeavesController@index')->middleware('permission:can-view-leaves-calendar');
Route::post('get_all_leaves', 'LeavesController@getAllLeaves')->middleware('permission:can-view-leaves-calendar');
Route::post('approve_reject_leave', 'LeavesController@approveRejectLeave')->middleware('permission:can-view-leaves-calendar');
Route::get('get_approved_leaves', 'LeavesController@approvedLeave')->middleware('permission:can-view-leaves-calendar');
Route::get('all_users', 'LeavesController@getUsers')->middleware('permission:can-view-leaves-calendar');

Route::post('third_party_booking', 'BookingsController@third_party_booking');
Route::get('get_third_party_bookings', 'BookingsController@get_third_party_bookings');
Route::get('get_third_party_booking_count', 'BookingsController@get_third_party_booking_count');

// Booking Mapping
Route::get('booking_mappings', 'BookingMappingController@index');
Route::post('booking_mappings', 'BookingMappingController@store');
Route::post('booking_mappings/{id}', 'BookingMappingController@update');
Route::post('getBookingMappings', 'BookingMappingController@getBookingMappings');

//Income Statement
Route::get('income_statement', 'IncomeStatementController@index');
Route::post('get_income_statement', 'IncomeStatementController@get_income_statement');
Route::post('income_pdf', 'IncomeStatementController@income_pdf');

//Balance Sheet
Route::get('balance_sheet', 'BalanceSheetController@index');
Route::post('get_balance_sheet', 'BalanceSheetController@get_balance_sheet');
Route::post('balance_sheet_pdf', 'BalanceSheetController@balance_sheet_pdf');

// bookingscalendar

Route::get('bookings_calendar', 'BookingsCalendarController@index')->middleware('permission:can-view-booking-calendar');
Route::post('get_bookings_calendar', 'BookingsCalendarController@getData')->middleware('permission:can-view-booking-calendar');
Route::post('get_event_bookings', 'BookingsCalendarController@getEventData')->middleware('permission:can-view-booking-calendar');

// accounts auto posting
Route::get('auto_postings', 'AutoPostingController@index')->middleware('permission:can-view-auto-posting');
Route::get('get_auto_postings', 'AutoPostingController@getData')->middleware('permission:can-view-auto-posting');
Route::post('auto_postings', 'AutoPostingController@store')->middleware('permission:can-add-auto-posting');
Route::post('auto_postings/del', 'AutoPostingController@destroy')->middleware('permission:can-view-auto-posting');
Route::post('auto_postings/{id}', 'AutoPostingController@update')->middleware('permission:can-edit-auto-posting');

// hotel dashboard
Route::get('hotel_dashboard', 'HotelDashboardController@index')->middleware('permission:can-view-hotel-dashboard');
Route::get('get_hotel_records', 'HotelDashboardController@getRecords')->middleware('permission:can-view-hotel-dashboard');
Route::get('getCheckins', 'HotelDashboardController@getCheckins')->middleware('permission:can-view-hotel-dashboard');
Route::get('getCheckouts', 'HotelDashboardController@getCheckouts')->middleware('permission:can-view-hotel-dashboard');
// ->middleware('permission:can-view-hotel-dashboard');

// shift handover
Route::get('shift_handover', 'ShiftHandOverController@index')->middleware('permission:can-view-shift-handover');
Route::get('get_shift_handover', 'ShiftHandOverController@getData')->middleware('permission:can-view-shift-handover');
Route::post('shift_handover', 'ShiftHandOverController@store')->middleware('permission:can-view-shift-handover');
Route::post('calculate_voucher_amount', 'ShiftHandOverController@calculateAmount')->middleware('permission:can-view-shift-handover');
