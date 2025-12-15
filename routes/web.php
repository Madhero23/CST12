<?php

use Illuminate\Support\Facades\Route;
// user routes
// http://cst12.test/index /products /about /contact 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('home.index');
});



//admin routes
// http://cst12.test/admin /productdetail /inventory /customers /finance /documents

Route::get('/admin', function () {
    return view('dashboard.admin');
});

Route::get('/productdetail', function () {
    return view('productdetails.PDetails');
});

Route::get('/inventory', function () {
    return view('inventory.inventory');
});

Route::get('/customers', function () {
    return view('customer.customer');
});

Route::get('/finance', function () {
    return view('finance.finance');
});

Route::get('/document', function () {
    return view('document.document');
});