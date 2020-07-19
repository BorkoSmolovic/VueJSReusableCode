
<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['auth:api']], function () {

    //User
    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@destroy');
    Route::get('/getLogedUserData', 'UserController@getLogedUserData');
    Route::post('/userUpdate', 'UserController@updateCurrentUser');


    //Country
    Route::post('/country', 'CountryController@store');
    Route::get('/country', 'CountryController@index');
    Route::get('/countryActive', 'CountryController@activeCountries');
    Route::put('/country/{country}', 'CountryController@update');
    Route::delete('/country/{country}', 'CountryController@destroy');

    //City
    Route::post('/city', 'CityController@store');
    Route::get('/city', 'CityController@index');
    Route::get('/cityActive', 'CityController@activeCities');
    Route::put('/city/{city}', 'CityController@update');
    Route::delete('/city/{city}', 'CityController@destroy');

    //Partner
    Route::post('/partners', 'PartnerController@store');
    Route::get('/partnerInfo', 'PartnerController@getUserInfo');
    Route::get('/partners', 'PartnerController@index');
    Route::get('/partnersActive', 'PartnerController@getPartners');
    Route::get('/partners/{partnerId}', 'PartnerController@getPartnerById');
    Route::put('/partners/{partner}', 'PartnerController@update');
    Route::delete('/partners/{partner}', 'PartnerController@destroy');
    Route::post('/getPartnersByFirstLetter', 'PartnerController@getPartnersByFirstLetter');
    Route::get('/partnerLicences/{partner}', 'PartnerController@getPartnerLicences');
    Route::post('/setPartnerParent', 'PartnerController@setPartnerParent');

    //Partner Type
    Route::post('/partnerType', 'PartnerTypeController@store');
    Route::get('/partnerType', 'PartnerTypeController@index');
    Route::get('/partnerTypeActive', 'PartnerTypeController@activePartnerTypes');
    Route::put('/partnerType/{partnerType}', 'PartnerTypeController@update');
    Route::delete('/partnerType/{partnerType}', 'PartnerTypeController@destroy');

    //Contact Type
    Route::post('/contactType', 'ContactTypeController@store');
    Route::get('/contactType', 'ContactTypeController@index');
    Route::get('/contactTypeActive', 'ContactTypeController@activeContactTypes');
    Route::put('/contactType/{contactType}', 'ContactTypeController@update');
    Route::delete('/contactType/{contactType}', 'ContactTypeController@destroy');

    //Contact
    Route::post('/contact', 'ContactController@store');
    Route::get('/contact/{partnerId}', 'ContactController@getContactByPartnerId');
    Route::put('/contact/{contact}', 'ContactController@update');
    Route::delete('/contact/{contact}', 'ContactController@destroy');

    //Contact Person
    Route::post('/contactPerson', 'ContactPersonController@store');
    Route::get('/contactPerson', 'ContactPersonController@index');
    Route::get('/contactPersonActive', 'ContactPersonController@activeContactPersons');
    Route::put('/contactPerson/{contactPerson}', 'ContactPersonController@update');
    Route::delete('/contactPerson/{contactPerson}', 'ContactPersonController@destroy');

    //Bank
    Route::post('/bank', 'BankController@store');
    Route::get('/bank', 'BankController@index');
    Route::get('/bankActive', 'BankController@activeBanks');
    Route::put('/bank/{bank}', 'BankController@update');
    Route::delete('/bank/{bank}', 'BankController@destroy');

    //Bank Account
    Route::post('/bankAccount', 'BankAccountController@store');
    Route::get('/bankAccount/getContactByPartnerId{partnerId}', 'BankAccountController@index');
    Route::put('/bankAccount/{bankAccount}', 'BankAccountController@update');
    Route::delete('/bankAccount/{bankAccount}', 'BankAccountController@destroy');

    //Contract
    Route::post('/contract', 'ContractController@store');
    Route::get('/contract/{partnerId}', 'ContractController@readContractsByPartnerId');
    Route::get('/contractActive/{partnerId}', 'ContractController@readContractsByPartnerIdActive');
    Route::put('/contract/{contract}', 'ContractController@update');
    Route::delete('/contract/{contract}', 'ContractController@destroy');

    //Languages
    Route::post('/language', 'LanguageController@store');
    Route::get('/language', 'LanguageController@index');
    Route::put('/language/{language}', 'LanguageController@update');
    Route::delete('/language/{language}', 'LanguageController@destroy');

    //Payment Type
    Route::post('/paymentType', 'PaymentTypeController@store');
    Route::get('/paymentType', 'PaymentTypeController@index');
    Route::get('/paymentTypeActive', 'PaymentTypeController@activePaymentTypes');
    Route::delete('/paymentType/{paymentType}', 'PaymentTypeController@destroy');
    Route::put('/paymentType/{paymentType}', 'PaymentTypeController@update');

    //Worker Type
    Route::post('/workerType', 'WorkerTypeController@store');
    Route::get('/workerType', 'WorkerTypeController@index');
    Route::get('/workerTypeActive', 'WorkerTypeController@activeWorkerTypes');
    Route::delete('/workerType/{workerType}', 'WorkerTypeController@destroy');
    Route::put('/workerType/{workerType}', 'WorkerTypeController@update');

    //Worker
    Route::post('/workers', 'WorkerController@store');
    Route::get('/workers', 'WorkerController@index');
    Route::get('/workersActive', 'WorkerController@activeWorkers');
    Route::delete('/workers/{worker}', 'WorkerController@destroy');
    Route::put('/workers/{worker}', 'WorkerController@update');

    Route::get('/workerTypeWorkers', 'WorkerTypeWorkerController@index');

    //Evidention
    Route::post('/evidentionInvoice', 'EvidentionController@uploadInvoice');
    Route::delete('/evidentionInvoice/{evidention}', 'EvidentionController@deleteInvoice');
    Route::get('/evidentionInvoice/{evidention}', 'EvidentionController@getInvoice');
    Route::get('/evidentionInvoiceDownload/{evidention}', 'EvidentionController@downloadInvoice');
    Route::post('/evidention', 'EvidentionController@store');
    Route::get('/evidention', 'EvidentionController@index');
    Route::post('/evidentionFinishedDenied', 'EvidentionController@indexFinishedDenied');
    Route::post('/evidentionsBetweenDates', 'EvidentionController@getbetweenDates');
    Route::delete('/evidention/{evidention}', 'EvidentionController@destroy');
    Route::put('/evidention/{evidention}', 'EvidentionController@update');
    Route::get('/evidentionByPartner', 'EvidentionController@getByPartnerId');

    //Evidention Item
    Route::post('/evidentionItem', 'EvidentionItemController@store');
    Route::get('/evidentionItem/{evidention_id}', 'EvidentionItemController@index');
    Route::delete('/evidentionItem/{evidentionItem}', 'EvidentionItemController@destroy');
    Route::put('/evidentionItem/{evidentionItem}', 'EvidentionItemController@update');

    //Evidention Status
    Route::post('/evidentionStatus', 'EvidentionStatusController@store');
//    Route::get('/evidentionStatus', 'EvidentionStatusController@index');
//    Route::delete('/evidentionStatus/{evidentionStatus}', 'EvidentionStatusController@destroy');
//    Route::put('/evidentionStatus/{evidentionStatus}', 'EvidentionStatusController@update');

    //Evidention Worker
    Route::post('/evidentionWorker', 'EvidentionWorkerController@store');
    Route::get('/evidentionWorker/{evidention_id}', 'EvidentionWorkerController@index');
    Route::delete('/evidentionWorker/{evidentionWorker}', 'EvidentionWorkerController@destroy');
    Route::put('/evidentionWorker/{evidentionWorker}', 'EvidentionWorkerController@update');

    //Comment
    Route::post('/comment', 'CommentController@store');
    Route::get('/comment/{evidention_id}', 'CommentController@index');
    Route::get('/getCommentInfo', 'CommentController@commentsDashboard');
    Route::delete('/comment/{comment}', 'CommentController@destroy');
    Route::put('/comment/{comment}', 'CommentController@update');

    //Vehicle
    Route::post('/vehicle', 'VehicleController@store');
    Route::get('/vehicle', 'VehicleController@index');
    Route::get('/vehicleActive', 'VehicleController@activeVehicles');
    Route::delete('/vehicle/{vehicle}', 'VehicleController@destroy');
    Route::put('/vehicle/{vehicle}', 'VehicleController@update');

    //Status
    Route::post('/status', 'StatusController@store');
    Route::get('/status', 'StatusController@index');
    Route::delete('/status/{status}', 'StatusController@destroy');
    Route::put('/status/{status}', 'StatusController@update');

    //Item
    Route::post('/items', 'ItemController@store');
    Route::get('/items', 'ItemController@index');
    Route::get('/itemsActive', 'ItemController@activeItems');
    Route::delete('/items/{item}', 'ItemController@destroy');
    Route::put('/items/{item}', 'ItemController@update');

    //Vehicles
    Route::get('/vehicle', 'VehicleController@index');

    Route::get('/excel1', 'ExcelController@store');
    Route::get('/instruction', 'ExcelController@getInstruction');
    Route::get('/invoice', 'ExcelController@getInstruction');
    Route::get('/instructionClient', 'ExcelController@getInstructionClient');
    //Route::post('/excel3', 'ExcelController@store');

    Route::post('/seen', 'CommentController@leaveMeSeen');

    //Services
    Route::post('/services', 'ServiceController@store');
    Route::get('/services', 'ServiceController@index');
    Route::get('/servicesActive', 'ServiceController@activeItems');
    Route::delete('/services/{service}', 'ServiceController@destroy');
    Route::put('/services/{service}', 'ServiceController@update');

    //Evidention services
    Route::post('/evidentionServices', 'EvidentionServiceController@store');
    Route::get('/evidentionServices/{evidention_id}', 'EvidentionServiceController@index');
    Route::delete('/evidentionServices/{evidention_service}', 'EvidentionServiceController@destroy');
    Route::put('/evidentionServices/{evidentionItem}', 'EvidentionServiceController@update');


});


Route::post('/login', 'Auth\LoginController@login');


Route::post('/excel1', 'ExcelController@store');
Route::post('/downloadReportExcel', 'ExcelController@workerReport');
Route::post('/downloadReportItems', 'ExcelController@itemsReport');
Route::post('/downloadReportClients', 'ExcelController@clientsReport');
Route::get('/downloadWorkerReportExcel', 'ExcelController@workerReport');

