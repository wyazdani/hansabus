<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\General;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function uploadFiles(Request $request) {

        $general = new General;
        $ext = $request->file('file')->getClientOriginalExtension();
        $imageName = $general->randomKey().'.'.$ext;

        $request->file('file')->move(
            base_path() . '/public/attachments/', $imageName
        );

        $attachment = new Attachment;
        $attachment->ext = $ext;
        $attachment->file = $imageName;
        $attachment->temp_key = $request->temp_key;
        $attachment->save();
        dd('');
    }
}