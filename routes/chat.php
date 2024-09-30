<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AddMemberToChatController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\RemoveMemberFromChatController;
use App\Http\Controllers\Api\StoreGroupChatController;
use Illuminate\Support\Facades\Route;

Route::get('/chats', [ChatController::class, 'index']);
Route::post('/chats', [ChatController::class, 'store']);
Route::post('/chats/group', [StoreGroupChatController::class, '__invoke']);
Route::get('/chats/{chat_id}', [ChatController::class, 'show']);
Route::patch('/chats/{chat_id}', [ChatController::class, 'update']);
Route::post('/chats/{chat_id}/add-members', [AddMemberToChatController::class, '__invoke']);
Route::delete('/chats/{chat_id}/remove-members', [RemoveMemberFromChatController::class, '__invoke']);
Route::delete('/chats/{chat_id}', [ChatController::class, 'destroy']);
