<?php

declare(strict_types=1);

use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/chats/{chat_id}/messages', [MessageController::class, 'index']);
Route::post('/chats/{chat_id}/messages', [MessageController::class, 'store']);
Route::patch('/chats/{chat_id}/messages/{message_id}', [MessageController::class, 'update']);
Route::delete('/chats/{chat_id}/messages/{message_id}', [MessageController::class, 'destroy']);
