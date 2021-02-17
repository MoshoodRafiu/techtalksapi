<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function getMessages(){
        return ChatResource::collection(Chat::all());
    }
}
