<?php

use Illuminate\Support\Facades\Route;

// user routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('home.index');
})->name('home.index'); // Added name for home page

Route::get('/products', function () {
    return view('products.products');
})->name('product');

Route::get('/about', function () {
    return view('about.about');
})->name('about');

Route::get('/contact', function () {
    return view('contact.contact');
})->name('contact');

// Add this route for product details
Route::get('/product/{id}', function ($id) {
    return view('components.viewproduct', ['productId' => $id]);
})->name('product.details');

//admin routes
Route::get('/admin', function () {
    return view('dashboard.admin');
})->name('admin');

Route::get('/productdetail', function () {
    return view('productdetails.PDetails');
})->name('products');

Route::get('/inventory', function () {
    return view('inventory.inventory');
})->name('inventory');

Route::get('/customers', function () {
    return view('customer.customer');
})->name('customers');

Route::get('/finance', function () {
    return view('finance.finance');
})->name('finance');

Route::get('/document', function () {
    return view('document.document');
})->name('documents');