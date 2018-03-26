<?php

Route::get('/', 'SnipperController@getIndex')
    ->name('snippet.index');

Route::get('create', 'SnipperController@getCreate')
    ->name('snippet.create');
Route::post('create', 'SnipperController@postCreate');

Route::get('{id}', 'SnipperController@getShow')
    ->name('snippet.show');

Route::get('{id}/edit', 'SnipperController@getEdit')
    ->name('snippet.edit');
Route::post('{id}/edit', 'SnipperController@postEdit');

Route::get('embed/{id}.js', 'SnipperController@getShowEmbed')
    ->name('snippet.embed.show');

Route::get('raw/{id}', 'SnipperController@getShowRaw')
    ->name('snippet.raw.show');
