<?=
"
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the \"web\" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//tetapan route
Route::group(['prefix' => 'tetapan', 'namespace' => 'tetapan'], function () {
    Route::resources([
"?>
<?php
foreach ($tables as $i => $table) { 
    echo "\t\t'" .strtolower(substr($table, 3)) . "' => '".$table."Controller',"."\r\n";
}   
?>
<?="
    ]);	
});
"
?>