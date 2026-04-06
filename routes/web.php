<?php
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ImportCSVUserController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    //Tela de login
    Route::get('/login', [AuthController::class, 'index'])->name('login');

    //Processamento dos dados do login
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

    //Tela de logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //Grupo de rotas restritas
    Route::group(['middleware' => 'auth'], function() {

        Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
        Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');

        Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
        Route::post('/store-user', [UserController::class, 'store'])->name('user.store');

        Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');

        Route::get('/edit-pwd_user/{user}', [UserController::class, 'pwd_edit'])->name('user.pwd_edit');
        Route::put('/update-pwd_user/{user}', [UserController::class, 'pwd_update'])->name('user.pwd_update');

        Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('/generate-pdf-user/{user}', [UserController::class, 'generatePdf'])->name('user.generate-pdf');
        Route::get('/generate-pdf-users', [UserController::class, 'generatePdfUsers'])->name('user.generate-pdf-users');
        Route::get('/generate-csv-users', [UserController::class, 'generateCSVUsers'])->name('user.generate-csv-users');

        Route::post('/import-csv-users', [ImportCSVUserController::class, 'importCSVUsers'])->name('user.import-csv-users');
    });
?>