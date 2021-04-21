<?php

Route::get('index.php',function(){
    Index::View('index');
 });

 Route::get('',function(){
   Index::View('index');
});

Route::get('articoli/{id}',function(){
   Index::View('articoli');
});

 Route::get('register',function(){
   Admin::View('register');
});

Route::post('register',function(){
   Admin::Register();
});

Route::get('logout',function(){
   Admin::Logout();
});

Route::get('admin',function(){
   Admin::Protect('admin');
});

Route::post('admin',function(){
   Admin::Login();
 });

Route::get('login',function(){
   Admin::Protect('admin');
});



Route::get('themes',function(){
   Themes::Protect('themes');
});




 Route::fallback();

