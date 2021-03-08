<?php

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


Route::get('/', [
	'uses' => 'DashboardController@index',
	'as' => 'dashboard'
]);


Route::get('/dashboard', [
	'uses' => 'DashboardController@index',
	'as' => 'dashboard'
]);


Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

Auth::routes(['verify' => true]);

Route::get('/backoffice', [
	'uses' => 'DashboardController@index',
	'middleware' => ['auth'],
	'as' => 'backoffice.index'
])->middleware('verified');;	

//region Users
Route::get('/backoffice/users', [
	'uses' => 'UsersController@index',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'backoffice.users.index'
]);

Route::get('/dashboard/users/create', [
	'uses' => 'UsersController@create',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.create'
]);

Route::post('/dashboard/users/create/store', [
	'uses' => 'UsersController@store',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.store'
]);

Route::get('/dashboard/users/show/{user}', [
	'uses' => 'UsersController@show',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.show'
]);

Route::get('/backoffice/dashboard/users/edit/{user}', [
	'uses' => 'UsersController@edit',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.edit'
]);

Route::put('/dashboard/users/edit/{user}/update', [
	'uses' => 'UsersController@update',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.update'
]);

Route::get('/dashboard/users/delete/{user}', [
	'uses' => 'UsersController@delete',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.delete'
]);



Route::get('/backoffice/dashboard/users/destroy/{user}', [
	'uses' => 'UsersController@destroy',
	'middleware' => ['hasPermission:view_users'],
	'as' => 'dashboard.users.destroy'
]);

Route::put('/backoffice/dashboard/users/{user}/locale', 'UsersController@locale')->middleware('auth')->name('user.locale');
Route::put('/backoffice/dashboard/users/{user}/password', 'UsersController@password')->middleware('auth')->name('user.password');


Route::get('/dashboard/users/pass/{user}', [
	'uses' => 'UsersController@pass',
	//'middleware' => [],
	'as' => 'dashboard.users.pass'
]);

Route::post('/dashboard/users/pass/store', [
	'uses' => 'UsersController@passstore',
	//'middleware' => [],
	'as' => 'dashboard.users.passstore'
]);

//endregion


//region Roles
Route::get('/backoffice/roles', [
	'uses' => 'RolesController@index',
	'middleware' => ['hasPermission:view_roles'],
	'as' => 'backoffice.roles.index'
]);

Route::get('/backoffice/roles/create', [
	'uses' => 'RolesController@create',
	'middleware' => ['hasPermission:view_roles'],
	'as' => 'backoffice.roles.create'
]);

Route::post('/backoffice/roles/create/store', [
	'uses' => 'RolesController@store',
	'middleware' => ['hasPermission:view_roles'],
	'as' => 'backoffice.roles.store'
]);

Route::get('/backoffice/roles/edit/{role}', [
	'uses' => 'RolesController@edit',
	'middleware' => ['hasPermission:view_roles'],
	'as' => 'backoffice.roles.edit'
]);

Route::post('/backoffice/roles/edit/{role}/update', [
	'uses' => 'RolesController@update',
	'middleware' => ['hasPermission:view_roles'],
	'as' => 'backoffice.roles.update'
]);

Route::get('/backoffice/roles/delete/{role}', [
	'uses' => 'RolesController@delete',
	'middleware' => ['hasPermission:view_roles'],
	'as' => 'backoffice.roles.delete'
]);
//endregion

//region Permissions
Route::get('/backoffice/permissions', [
	'uses' => 'PermissionsController@index',
	'middleware' => ['hasPermission:view_permissions'],
	'as' => 'backoffice.permissions.index'
]);

Route::get('/backoffice/permissions/create', [
	'uses' => 'PermissionsController@create',
	'middleware' => ['hasPermission:view_permissions'],
	'as' => 'backoffice.permissions.create'
]);

Route::post('/backoffice/permissions/create/store', [
	'uses' => 'PermissionsController@store',
	'middleware' => ['hasPermission:view_permissions'],
	'as' => 'backoffice.permissions.store'
]);

Route::get('/backoffice/permissions/edit/{role}', [
	'uses' => 'PermissionsController@edit',
	'middleware' => ['hasPermission:view_permissions'],
	'as' => 'backoffice.permissions.edit'
]);

Route::post('/backoffice/permissions/edit/{role}/update', [
	'uses' => 'PermissionsController@update',
	'middleware' => ['hasPermission:view_permissions'],
	'as' => 'backoffice.permissions.update'
]);

Route::get('/backoffice/permissions/delete/{role}', [
	'uses' => 'PermissionsController@delete',
	'middleware' => ['hasPermission:view_permissions'],
	'as' => 'backoffice.permissions.delete'
]);
//endregion

//region Profile
Route::get('/backoffice/profile', [
	'uses' => 'ProfileController@index',
	//'middleware' => [],
	'as' => 'backoffice.profile.index'
]);

//region Profile
Route::get('/backoffice/myprofile', [
	'uses' => 'ProfileController@myprofile',
	//'middleware' => [],
	'as' => 'backoffice.myprofile.index'
]);

Route::get('/backoffice/profile/change-password', [
	'uses' => 'UsersController@changePasswordForm',
	//'middleware' => [],
	'as' => 'backoffice.profile.change-password'
]);

Route::post('/backoffice/profile/change-password/save', [
	'uses' => 'UsersController@changePassword',
	//'middleware' => [],
	'as' => 'backoffice.profile.change-password.save'
]);
//endregion


//region companies
Route::get('/backoffice/companies', [
	'uses' => 'CompaniesController@index',
	//'middleware' => [],
	'as' => 'companies.index'
]);
Route::get('/backoffice/companies/create', [
	'uses' => 'CompaniesController@create',
	//'middleware' => [],
	'as' => 'companies.create'
]);

Route::post('/companies/create/store', [
	'uses' => 'CompaniesController@store',
	//'middleware' => [],
	'as' => 'companies.store'
]);

Route::get('/backoffice/companies/edit/{id}', [
	'uses' => 'CompaniesController@edit',
	//'middleware' => [],
	'as' => 'companies.edit'
]);

Route::put('/companies/edit/{id}/update', [
	'uses' => 'CompaniesController@update',
	//'middleware' => [],
	'as' => 'companies.update'
]);

Route::get('/backoffice/companies/delete/{id}', [
	'uses' => 'CompaniesController@delete',
	//'middleware' => [],
	'as' => 'companies.delete'
]);

Route::get('/backoffice/companies/search', 'CompaniesController@search')->name('companies.search');
//endregion

//region suppliers
Route::get('/backoffice/suppliers', [
	'uses' => 'SuppliersController@index',
	//'middleware' => [],
	'as' => 'suppliers.index'
]);

Route::get('/backoffice/suppliers/create', [
	'uses' => 'SuppliersController@create',
	//'middleware' => [],
	'as' => 'suppliers.create'
]);

Route::post('/suppliers/create/store', [
	'uses' => 'SuppliersController@store',
	//'middleware' => [],
	'as' => 'suppliers.store'
]);

Route::get('/backoffice/suppliers/edit/{id}', [
	'uses' => 'SuppliersController@edit',
	//'middleware' => [],
	'as' => 'suppliers.edit'
]);

Route::get('/backoffice/suppliers/show/{id}', [
	'uses' => 'SuppliersController@show',
	//'middleware' => [],
	'as' => 'suppliers.show'
]);

Route::get('/backoffice/suppliers/balancedetails/{id}', [
	'uses' => 'SuppliersController@balancedetails',
	//'middleware' => [],
	'as' => 'suppliers.balancedetails'
]);

Route::put('/suppliers/edit/{id}/update', [
	'uses' => 'SuppliersController@update',
	//'middleware' => [],
	'as' => 'suppliers.update'
]);

Route::get('/backoffice/suppliers/delete/{id}', [
	'uses' => 'SuppliersController@delete',
	//'middleware' => [],
	'as' => 'suppliers.delete'
]);

Route::get('/backoffice/suppliers/{id}/payments', [
	'uses' => 'SuppliersController@showPayments',
	//'middleware' => [],
	'as' => 'suppliers.payments'
]);


Route::get('/backoffice/suppliers/search', 'SuppliersController@search')->name('suppliers.search');

//endregion

//region works
Route::get('/backoffice/works', [
	'uses' => 'WorksController@index',
	//'middleware' => [],
	'as' => 'works.index'
]);
Route::get('/backoffice/works/create', [
	'uses' => 'WorksController@create',
	//'middleware' => [],
	'as' => 'works.create'
]);

Route::post('/works/create/store', [
	'uses' => 'WorksController@store',
	//'middleware' => [],
	'as' => 'works.store'
]);

Route::get('/backoffice/works/edit/{id}', [
	'uses' => 'WorksController@edit',
	//'middleware' => [],
	'as' => 'works.edit'
]);

Route::put('/works/edit/{id}/update', [
	'uses' => 'WorksController@update',
	//'middleware' => [],
	'as' => 'works.update'
]);

Route::get('/backoffice/works/delete/{id}', [
	'uses' => 'WorksController@delete',
	//'middleware' => [],
	'as' => 'works.delete'
]);

Route::get('/backoffice/works/show/{id}', [
	'uses' => 'WorksController@show',
	//'middleware' => [],
	'as' => 'works.show'
]);

Route::get('/backoffice/works/show/real/{id}', [
	'uses' => 'WorksController@real',
	//'middleware' => [],
	'as' => 'works.real'
]);

Route::get('/backoffice/works/show/budget/{id}', [
	'uses' => 'WorksController@budget',
	//'middleware' => [],
	'as' => 'works.budget'
]);

Route::get('/backoffice/works/show/payed/{id}', [
	'uses' => 'WorksController@payed',
	//'middleware' => [],
	'as' => 'works.payed'
]);

Route::get('/backoffice/works/show/to-pay/{id}', [
	'uses' => 'WorksController@toPay',
	//'middleware' => [],
	'as' => 'works.to-pay'
]);

Route::get('/backoffice/works/show/comparation/{id}', [
	'uses' => 'WorksController@comparation',
	//'middleware' => [],
	'as' => 'works.comparation'
]);

Route::get('/backoffice/works/show/out-of-budget/{id}', [
	'uses' => 'WorksController@outOfBudget',
	//'middleware' => [],
	'as' => 'works.out-of-budget'
]);

Route::get('/backoffice/works/show/unbilled-budget/{id}', [
	'uses' => 'WorksController@unbilledBudget',
	//'middleware' => [],
	'as' => 'works.unbilled-budget'
]);

Route::put('/backoffice/works/{id}/status-update', [
	'uses' => 'WorksController@statusUpdate',
	//'middleware' => [],
	'as' => 'works.status-update'
]);

Route::get('/backoffice/works/search', 'WorksController@search')->name('works.search');
//endregion


//region budgets
Route::get('/backoffice/budgets', [
	'uses' => 'BudgetsController@index',
	//'middleware' => [],
	'as' => 'budgets.index'
]);
Route::get('/backoffice/budgets/create', [
	'uses' => 'BudgetsController@create',
	//'middleware' => [],
	'as' => 'budgets.create'
]);

Route::post('/budgets/create/store', [
	'uses' => 'BudgetsController@store',
	//'middleware' => [],
	'as' => 'budgets.store'
]);

Route::get('/backoffice/budgets/edit/{id}', [
	'uses' => 'BudgetsController@edit',
	//'middleware' => [],
	'as' => 'budgets.edit'
]);

Route::put('/budgets/edit/{id}/update', [
	'uses' => 'BudgetsController@update',
	//'middleware' => [],
	'as' => 'budgets.update'
]);

Route::get('/backoffice/budgets/delete/{id}', [
	'uses' => 'BudgetsController@delete',
	//'middleware' => [],
	'as' => 'budgets.delete'
]);

Route::get('/backoffice/budgets/show/{id}', [
	'uses' => 'BudgetsController@show',
	//'middleware' => [],
	'as' => 'budgets.show'
]);

Route::post('/backoffice/budgets/addDoc/{id}', [
	'uses' => 'BudgetsController@addDoc',
	//'middleware' => [],
	'as' => 'budgets.addDoc'
]);

Route::get('/backoffice/budgets/delDoc/{id}', [
	'uses' => 'BudgetsController@delDoc',
	//'middleware' => [],
	'as' => 'budgets.delDoc'
]);

Route::post('/backoffice/budgets/addLine/{id}', [
	'uses' => 'BudgetsController@addLine',
	//'middleware' => [],
	'as' => 'budgets.addLine'
]);

Route::get('/backoffice/budgets/delLine/{id}', [
	'uses' => 'BudgetsController@delLine',
	//'middleware' => [],
	'as' => 'budgets.delLine'
]);

Route::get('/backoffice/budgets/search', 'BudgetsController@search')->name('budgets.search');
//endregion

//region invoices
Route::get('/backoffice/invoices', [
	'uses' => 'InvoicesController@index',
	//'middleware' => [],
	'as' => 'invoices.index'
]);
Route::get('/backoffice/invoices/create', [
	'uses' => 'InvoicesController@create',
	//'middleware' => [],
	'as' => 'invoices.create'
]);

Route::post('/invoices/create/store', [
	'uses' => 'InvoicesController@store',
	//'middleware' => [],
	'as' => 'invoices.store'
]);

Route::get('/backoffice/invoices/edit/{id}', [
	'uses' => 'InvoicesController@edit',
	//'middleware' => [],
	'as' => 'invoices.edit'
]);

Route::put('/invoices/edit/{id}/update', [
	'uses' => 'InvoicesController@update',
	//'middleware' => [],
	'as' => 'invoices.update'
]);

Route::get('/backoffice/invoices/delete/{id}', [
	'uses' => 'InvoicesController@delete',
	//'middleware' => [],
	'as' => 'invoices.delete'
]);

Route::get('/backoffice/invoices/show/{id}', [
	'uses' => 'InvoicesController@show',
	//'middleware' => [],
	'as' => 'invoices.show'
]);

Route::post('/backoffice/invoices/addDoc/{id}', [
	'uses' => 'InvoicesController@addDoc',
	//'middleware' => [],
	'as' => 'invoices.addDoc'
]);

Route::get('/backoffice/invoices/delDoc/{id}', [
	'uses' => 'InvoicesController@delDoc',
	//'middleware' => [],
	'as' => 'invoices.delDoc'
]);

Route::post('/backoffice/invoices/addLine/{id}', [
	'uses' => 'InvoicesController@addLine',
	//'middleware' => [],
	'as' => 'invoices.addLine'
]);

Route::get('/backoffice/invoices/delLine/{id}', [
	'uses' => 'InvoicesController@delLine',
	//'middleware' => [],
	'as' => 'invoices.delLine'
]);

Route::post('/backoffice/invoices/addPayment/{id}', [
	'uses' => 'InvoicesController@addPayment',
	//'middleware' => [],
	'as' => 'invoices.addPayment'
]);

Route::put('/backoffice/invoices/updatePayment', [
	'uses' => 'InvoicesController@updatePayment',
	//'middleware' => [],
	'as' => 'invoices.updatePayment'
]);

Route::put('/backoffice/invoices/updateLine', [
	'uses' => 'InvoicesController@updateLine',
	//'middleware' => [],
	'as' => 'invoices.updateLine'
]);

Route::get('/backoffice/invoices/delPayment/{id}', [
	'uses' => 'InvoicesController@delPayment',
	//'middleware' => [],
	'as' => 'invoices.delPayment'
]);

Route::get('/backoffice/invoices/search', 'InvoicesController@search')->name('invoices.search');

//endregion

//region docnames
Route::get('/backoffice/docnames', [
	'uses' => 'DocnamesController@index',
	//'middleware' => [],
	'as' => 'docnames.index'
]);
Route::get('/backoffice/docnames/create', [
	'uses' => 'DocnamesController@create',
	//'middleware' => [],
	'as' => 'docnames.create'
]);

Route::post('/docnames/create/store', [
	'uses' => 'DocnamesController@store',
	//'middleware' => [],
	'as' => 'docnames.store'
]);

Route::get('/backoffice/docnames/edit/{id}', [
	'uses' => 'DocnamesController@edit',
	//'middleware' => [],
	'as' => 'docnames.edit'
]);

Route::put('/docnames/edit/{id}/update', [
	'uses' => 'DocnamesController@update',
	//'middleware' => [],
	'as' => 'docnames.update'
]);

Route::get('/backoffice/docnames/delete/{id}', [
	'uses' => 'DocnamesController@delete',
	//'middleware' => [],
	'as' => 'docnames.delete'
]);


Route::get('/backoffice/docnames/search', 'DocnamesController@search')->name('docnames.search');

//endregion


//region producttypes
Route::get('/backoffice/producttypes', [
	'uses' => 'ProducttypesController@index',
	//'middleware' => [],
	'as' => 'producttypes.index'
]);
Route::get('/backoffice/producttypes/create', [
	'uses' => 'ProducttypesController@create',
	//'middleware' => [],
	'as' => 'producttypes.create'
]);

Route::post('/producttypes/create/store', [
	'uses' => 'ProducttypesController@store',
	//'middleware' => [],
	'as' => 'producttypes.store'
]);

Route::get('/backoffice/producttypes/edit/{id}', [
	'uses' => 'ProducttypesController@edit',
	//'middleware' => [],
	'as' => 'producttypes.edit'
]);

Route::put('/producttypes/edit/{id}/update', [
	'uses' => 'ProducttypesController@update',
	//'middleware' => [],
	'as' => 'producttypes.update'
]);

Route::get('/backoffice/producttypes/delete/{id}', [
	'uses' => 'ProducttypesController@delete',
	//'middleware' => [],
	'as' => 'producttypes.delete'
]);


Route::get('/backoffice/producttypes/search', 'ProducttypesController@search')->name('producttypes.search');



//endregion

//region settings
Route::get('/backoffice/settings', [
	'uses' => 'SettingsController@index',
	//'middleware' => [],
	'as' => 'backoffice.settings.index'
]);

Route::post('/backoffice/settings/store', [
	'uses' => 'SettingsController@store',
	//'middleware' => [],
	'as' => 'backoffice.settings.store'
]);

//endregion

//region configurations
Route::get('/backoffice/configurations', [
	'uses' => 'ConfigurationsController@index',
	//'middleware' => [],
	'as' => 'backoffice.configurations.index'
]);

Route::post('/backoffice/configurations/store', [
	'uses' => 'ConfigurationsController@store',
	//'middleware' => [],
	'as' => 'backoffice.configurations.store'
]);

//endregion

//region categories
Route::get('/backoffice/categories', [
	'uses' => 'CategoriesController@index',
	//'middleware' => [],
	'as' => 'categories.index'
]);
Route::get('/backoffice/categories/create', [
	'uses' => 'CategoriesController@create',
	//'middleware' => [],
	'as' => 'categories.create'
]);

Route::post('/backoffice/categories/create/store', [
	'uses' => 'CategoriesController@store',
	//'middleware' => [],
	'as' => 'categories.store'
]);

Route::get('/backoffice/categories/edit/{id}', [
	'uses' => 'CategoriesController@edit',
	//'middleware' => [],
	'as' => 'categories.edit'
]);

Route::post('/backoffice/categories/edit/{id}/update', [
	'uses' => 'CategoriesController@update',
	//'middleware' => [],
	'as' => 'categories.update'
]);

Route::get('/backoffice/categories/delete/{id}', [
	'uses' => 'CategoriesController@delete',
	//'middleware' => [],
	'as' => 'categories.delete'
]);


Route::get('/backoffice/categories/search', 'CategoriesController@search')->name('categories.search');
//endregion

//region LoginActivityController
//Route::get('/login-activity', 'LoginActivityController@index')->middleware('auth');
Route::get('/backoffice/loginactivity', [
	'uses' => 'LoginactivityController@index',
	'middleware' => ['hasPermission:view_loginactivity'],
	'as' => 'backoffice.loginactivity.index'
]);
//endregion

//region ivas
Route::get('/backoffice/ivas', [
	'uses' => 'IvasController@index',
	//'middleware' => [],
	'as' => 'ivas.index'
]);

Route::get('/backoffice/ivas/show/', [
	'uses' => 'IvasController@show',
	//'middleware' => [],
	'as' => 'ivas.show'
]);

//endregion

//region payments
Route::post('/backoffice/invoice-line/payments/store', [
	'uses' => 'InvoicePaymentsController@store',
	//'middleware' => [],
	'as' => 'payments.store'
]);

Route::post('/backoffice/invoice-line/{id}/payments/create', [
	'uses' => 'InvoicePaymentsController@create',
	//'middleware' => [],
	'as' => 'payments.create'
]);

//endregion

//region invoice_line
Route::get('/backoffice/invoice-line/edit/{supplier_id}/{line_id}/{work_id}', [
	'uses' => 'InvoiceLinesController@edit',
	//'middleware' => [],
	'as' => 'invoice_line.edit'
]);

Route::post('/backoffice/invoice-line/update/{supplier_id}', [
	'uses' => 'InvoiceLinesController@update',
	//'middleware' => [],
	'as' => 'invoice_line.update'
]);
//endregion

Route::get('recipes/{id}/pathologies', [
	'uses' => 'RecipeController@showRecipePathologies',
	'as' => 'recipes.pathologies'
]);
Route::put('recipes/{recipe_id}/pathologies/{pathology_id}/update', [
	'uses' => 'RecipeController@updateRecipePathologies',
	'as' => 'recipe.pathologies.update'
]);

Route::get('users/{id}/health', [
	'uses' => 'UsersController@showHealth',
	'as' => 'user.health.show'
]);

Route::put('users/{user_id}/pathologies/{pathology_id}/update', [
	'uses' => 'UsersController@updateHealth',
	'as' => 'user.health.update'
]);

Route::resource('recipes', 'RecipeController');
Route::resource('clinical-examination-questions', 'ClinicalExaminationQuestionController');
Route::resource('clinical-examination-questions.options', 'QuestionOptionController');
Route::resource('pathologies', 'PathologyController');