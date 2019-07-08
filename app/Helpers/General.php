<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class General
{

    public function invoiceNumber($id){
        return str_pad($id, 9, "0", STR_PAD_LEFT);
    }
    /* get random string key */
    public function randomKey() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0C2f) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0x2Aff), mt_rand(0, 0xffD3), mt_rand(0, 0xff4B)
        );
    }
    public function validateMe($request, $rules, $messages){

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            $messages = $validator->messages();
            foreach ($messages->all() as $message)
            {
                toastr()->error($message, 'Failed', ['timeOut' => 10000]);
            }
            return false;
        }
        return true;
    }
}
?>