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

// Les routes des interfaces de l admin

Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin_login');

Route::get('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin_logout');

Route::post('/utilisateurs/authenticate', [App\Http\Controllers\Admin\UtilisateurController::class, 'authenticate'])->name('utilisateur_authenticate');



Route::middleware(['admin', ])->group(function () {

//-----------------  Tableau de bord admin


    Route::get('/', [\App\Http\Controllers\Admin\TableauController::class, 'tableau'])->name('tableau');




//----------------- Contacts

    Route::get('/contacts/index', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin_contact_index');
    Route::get('/contacts/add', [\App\Http\Controllers\Admin\ContactController::class, 'add'])->name('admin_contact_add');
    Route::post('/contacts/save', [\App\Http\Controllers\Admin\ContactController::class, 'store'])->name('admin_contact_store');
    Route::get('/contacts/detail/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'detail'])->name('admin_contact_detail');
    Route::post('/contacts/delete/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'delete'])->name('admin_contact_delete');
    Route::get('/contacts/charger/{id}', [App\Http\Controllers\Admin\ContactController::class, 'charger'])->name('admin_contact_charger');

        //----------------- Messages

    Route::get('/messages/index', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('admin_message_index');
    Route::get('/messages/add', [App\Http\Controllers\Admin\MessageController::class, 'add'])->name('admin_message_add');
    Route::post('/messages/save', [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('admin_message_store');
    Route::get('/messages/modifier/{id}', [App\Http\Controllers\Admin\MessageController::class, 'edit'])->name('admin_message_edit');
    Route::post('/messages/update/{id}', [App\Http\Controllers\Admin\MessageController::class, 'update'])->name('admin_message_update');
    Route::post('/messages/delete/{id}', [App\Http\Controllers\Admin\MessageController::class, 'delete'])->name('admin_message_delete');


       


});

