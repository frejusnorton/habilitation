<?php

use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DemandeExcelExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AclController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\HblController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\ChampsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RoleMenuController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ValidateurController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\HblDerogationController;
use App\Http\Controllers\ApplicationRoleController;
use App\Http\Controllers\ApplicationTypeController;

Auth::routes();
/**
 * Test
 */

Route::get('dev', [DevController::class, 'dev'])->name('dev');

Route::middleware('portal')->group(function () {

    Route::get('user', [UserController::class, 'index'])->name('app_user_index');
    Route::match(['GET', 'POST'], 'user/create', [UserController::class, 'create'])->name('app_user_create');
    Route::match(['GET', 'POST'], 'user/{user}/edit', [UserController::class, 'modifier'])->name('app_user_edit');
    Route::get('user/detail/{user}', [UserController::class, 'detailUser'])->name('detail_user');
    Route::get('user/init_delete/{user}', [UserController::class, 'Initdelete'])->name('init_delete');
    Route::get('user/activate-or-disable/{user}', [UserController::class, 'activateOrDisableUser'])->name('activateOrDisableUser');

    // Rôle
    Route::get('roles', [RoleController::class, 'index'])->name('app_role_index');
    Route::match(['POST', 'GET'], 'role', [RoleController::class, 'create'])->name('role.create');
    Route::match(['POST', 'GET'], 'role/{role}/activate', [RoleController::class, 'activate'])->name('role.activate');
    Route::match(['POST', 'GET'], 'role/{role}/edit', [RoleController::class, 'update'])->name('role.update');
    Route::match(['POST', 'GET'], 'role/{role}/delete', [RoleController::class, 'delete'])->name('role.delete');

    // Menu
    Route::get('menu', [MenuController::class, 'index'])->name('app_menu_index');
    Route::post('menu', [MenuController::class, 'create'])->name('menu.create');
    Route::post('modification/{menu}/menu', [MenuController::class, 'update'])->name('menu.update');
    Route::post('suppression/{menu}/menu', [MenuController::class, 'delete'])->name('menu.delete');
    Route::get('rechercher-information-dans-menu', [MenuController::class, 'searchDataInMenu'])->name('search.menu');
    Route::post('export-menu', [MenuController::class, 'export'])->name('export.menu');

    // Role menu
    Route::get('role-menu', [RoleMenuController::class, 'index'])->name('app_role_menu_index');
    Route::post('role-menu', [RoleMenuController::class, 'create'])->name('app_role_menu_new');
    Route::post('modification-role-menu/{menu}', [RoleMenuController::class, 'update'])->name('app_role_menu_update');
    Route::post('suppression-role-menu/{menu}', [RoleMenuController::class, 'delete'])->name('app_role_menu_delete');
    Route::get('rechercher-information-dans-role-menu', [RoleMenuController::class, 'searchDataInMenu'])->name('app_role_menu_search');
    Route::post('export-role-menu', [RoleMenuController::class, 'export'])->name('app_role_menu_export');

    // Actions effectuées
    Route::get('acl/{menu}/get', [AclController::class, 'index'])->name('app_acl_index');
    Route::post('acl/{menu}/add', [AclController::class, 'create'])->name('app_acl_new');
    Route::post('modification-acl/{acl}', [AclController::class, 'update'])->name('app_acl_update');
    Route::get('suppression/{acl}/{menu}/', [AclController::class, 'delete'])->name('app_acl_delete');


    Route::get('log/activity', [ActivityController::class, 'activityList'])->name('app_activity_index');
    Route::post('log/export', [ActivityController::class, 'export'])->name('app_activity_export');

    //Services
    Route::get('service', [ServiceController::class, 'index'])->name('app_service_index');
    Route::post('service', [ServiceController::class, 'create'])->name('service.create');
    Route::post('modification/{service}/service', [ServiceController::class, 'update'])->name('service.update');
    Route::post('suppression/{service}/service', [ServiceController::class, 'delete'])->name('service.delete');

    //Direction
    Route::get('direction', [DirectionController::class, 'index'])->name('app_direction_index');
    Route::post('direction', [DirectionController::class, 'create'])->name('direction.create');
    Route::post('modification/{direction}/direction', [DirectionController::class, 'update'])->name('direction.update');
    Route::post('suppression/{direction}/direction', [DirectionController::class, 'delete'])->name('direction.delete');

    //Departement
    Route::get('departement', [DepartementController::class, 'index'])->name('app_departement_index');
    Route::post('departement', [DepartementController::class, 'create'])->name('departement.create');
    Route::post('modification/{departement}/departement', [DepartementController::class, 'update'])->name('departement.update');
    Route::post('suppression/{departement}/departement', [DepartementController::class, 'delete'])->name('departement.delete');

    //VALIDATEUR
    Route::get('validateur', [ValidateurController::class, 'index'])->name('app_validateur_index');
    Route::post('validateur', [ValidateurController::class, 'create'])->name('validateur.create');
    Route::post('modification/{validateur}/validateur', [ValidateurController::class, 'update'])->name('validateur.update');
    Route::post('suppression/{aprobateur}/validateur', [ValidateurController::class, 'delete'])->name('validateur.delete');

    //Agences
    Route::get('agence', [AgenceController::class, 'index'])->name('app_agence_index');

    // Habilitation par derogation
    Route::get('derogation', [HblDerogationController::class, 'index'])->name('app_derogation_index');
    Route::post('derogation', [HblDerogationController::class, 'step1'])->name('derogation.create');
    Route::post('derogation', [HblDerogationController::class, 'step2'])->name('derogation.create');
    Route::post('derogation', [HblDerogationController::class, 'step3'])->name('derogation.create');

    // Habilitation
    Route::get('habilitation', [HblController::class, 'index'])->name('app_habilitation_index');
    Route::get('habilitation/attente', [HblController::class, 'demandeAttente'])->name('habilitation.attente');
    Route::match(['get', 'post'], 'habilitation/create', [HblController::class, 'create'])->name('habilitation.create');
    Route::match(['get', 'post'], 'habilitation/demande/details/{demande}', [HblController::class, 'details'])->name('habilitation.details');
    Route::match(['get', 'post'], 'habilitation/demande/validation/details/{demande}', [HblController::class, 'detailValidation'])->name('hbl_validation.details');
    Route::post('/demande/{demande}/valider', [HblController::class, 'validerDemande'])->name('validation.demande');
    Route::post('/demande/{demande}/delete', [HblController::class, 'deleteDemande'])->name('supprimer.demande');
    Route::post('/demande/{demande}/rejeter', [HblController::class, 'rejeterDemande'])->name('rejet.demande');
    Route::post('/approbation/{demande}/valider', [HblController::class, 'validerApprobation'])->name('valider.approbation');

    //Approbation
    Route::get('approbation/attente', [HblController::class, 'approbation'])->name('approbation.index');

    //Application
    Route::get('application', [ApplicationController::class, 'index'])->name('app_application_index');
    Route::post('application', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('application/champ', [ApplicationController::class, 'champs'])->name('application_champ.create');
    Route::post('modification/{application}/application', [ApplicationController::class, 'update'])->name('application.update');
    Route::match(['POST', 'GET'], 'application/{application}/activate', [ApplicationController::class, 'activate'])->name('application.activate');
    Route::post('suppression/{application}/application', [ApplicationController::class, 'delete'])->name('application.delete');
    Route::match(['get', 'post'], 'load/field', [ApplicationController::class, 'loadField'])->name('loadField');
    Route::get('profils/{application}/profils', [ApplicationController::class, 'loadProfils'])->name('loadProfils');
    Route::get('champs/{application}/champs', [ApplicationController::class, 'loadChamps'])->name('loadChamps');


    //Application type
    Route::get('type', [ApplicationTypeController::class, 'index'])->name('app_application_type_index');
    Route::post('type', [ApplicationTypeController::class, 'create'])->name('application_type.create');
    Route::match(['POST', 'GET'], 'application_type/{application_type   }/activate', [ApplicationTypeController::class, 'activate'])->name('application_type.activate');
    Route::post('modification/{application_type}/application_type', [ApplicationTypeController::class, 'update'])->name('application_type.update');

    //Application rôle
    Route::get('application/role', [ApplicationRoleController::class, 'index'])->name('app_application_role_index');
    Route::post('application/role', [ApplicationRoleController::class, 'create'])->name('application_role.create');
    Route::match(['POST', 'GET'], 'application_role/{application_role}/activate', [ApplicationRoleController::class, 'activate'])->name('application_role.activate');
    Route::post('modification/{application_role}/application_role', [ApplicationRoleController::class, 'update'])->name('application_role.update');
    Route::post('suppression/{application_role}/application_role', [ApplicationRoleController::class, 'delete'])->name('application_role.delete');

    // Type champs
    Route::get('champs', [ChampsController::class, 'index'])->name('app_champs_index');
    Route::post('champ', [ChampsController::class, 'create'])->name('champ.create');
    Route::post('modification/{champ}/champ', [ChampsController::class, 'update'])->name('champ.update');
    Route::post('send-query', [ChampsController::class, 'handleQuery'])->name('send.query');

     //REPORTING
    Route::get('export-users-excel', [ExportController::class, 'exportUsersExcel'])->name('export-users-excel');
    Route::get('export-users-pdf', [ExportController::class, 'exportUsersPdf'])->name('export-users-pdf');

    Route::get('export-demande-excel', [ExportController::class, 'exportDemandeExcel'])->name('export-demande-excel');
    Route::get('export-demande-pdf', [ExportController::class, 'exportDemandePdf'])->name('export-demande-pdf');

    Route::get('export-agence-excel', [ExportController::class, 'exportAgenceExcel'])->name('export-agence-excel');
    Route::get('export-agence-pdf', [ExportController::class, 'exportAgencePdf'])->name('export-agence-pdf');

    Route::get('export-application-excel', [ExportController::class, 'exportApplicationExcel'])->name('export-application-excel');
    Route::get('export-application-pdf', [ExportController::class, 'exportApplicationPdf'])->name('export-application-pdf');



    Route::get('/', [HblController::class, "index"])->name('app_habilitation_index');
    // Route::get('/', [DevController::class, "dev"])->name('app_habilitation_index');

    Route::post('/deconnexion', function () {
        Auth::logout();
        return redirect('/login');
    })->name('deconnexion');
});

//AUTHENTIFICATION
Route::match(['POST', 'GET'], 'login', [LoginController::class, 'attemptLogin'])->name('auth');



Route::get('/notautorized', function () {
    return view('errors.notautorized');
})->name('notautorized');
