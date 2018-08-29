<?php

Route::resource('/', IndexController::class, ['only' => 'index']);
Route::resource('ipn', IPNController::class, ['only' => 'store']);
Route::resource('order.confirm', ConfirmController::class, ['only' => 'index']);
Route::resource('order.pay', PayController::class, ['only' => ['store', 'index']]);
Route::resource('order.return', PayController::class, ['only' => 'index']);
Route::resource('order.checkin', CheckinController::class, ['only' => 'index']);
Route::resource('event', EventController::class, ['only' => ['index', 'show']]);
Route::resource('event.checkout', CheckoutController::class, ['only' => 'store']);
