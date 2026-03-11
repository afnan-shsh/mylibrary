<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Models\Book;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReaderDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('books.index');
});


Route::get('/Dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    $role = auth()->user()->role;

    return match ($role) {
        'admin'     => redirect('/admin/Dashboard'),
        'publisher' => redirect('/publisher'),
        'reader'    => redirect('/reader/Dashboard'),
        default     => view('Dashboard'),
    };
})->name('Dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/Dashboard', function () {
        return view('admin.Dashboard');
    });
});

Route::middleware(['auth','role:reader'])->group(function () {
    Route::get('/reader/Dashboard', function () {
        return view('reader.Dashboard');
    });
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/test', function () {
    return 'You are logged in as: ' . auth()->user()->email;
    })->middleware('auth');

Route::post('/books/{book}/buy', [BookController::class, 'buy'])
    ->middleware(['auth','role:reader'])
    ->name('books.buy');

Route::get('/books/{book}/rent', function(Book $book){
    return view('books.rent', compact('book'));
    })->middleware('auth')->name('rent.page');

Route::middleware(['auth','role:reader'])->group(function () {

    Route::post('/books/{book}/rent', [TransactionController::class, 'rent'])
        ->name('books.rent');

    Route::post('/books/{book}/buy', [TransactionController::class, 'buy'])
        ->name('books.buy');
});

Route::middleware(['auth','role:reader'])->group(function () {

    Route::get('/my-books', [TransactionController::class, 'myBooks'])
        ->name('my.books');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

use App\Http\Controllers\ReviewController;

Route::post('/books/{book}/review', [ReviewController::class, 'store'])
    ->middleware(['auth', 'role:reader'])
    ->name('reviews.store');
