<?php
/**
 * Created by PhpStorm.
 * User: Quyen
 * Date: 1/20/2020
 * Time: 4:10 PM
 */
Route::resource('news', 'NewsController', [
    'names' => [
        'index' => 'admin.cms.news',
        'edit' => 'admin.cms.news.edit',
        'create' => 'admin.cms.news.create',
    ]
]);