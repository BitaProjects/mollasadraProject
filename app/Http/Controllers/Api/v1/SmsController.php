<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class SmsController extends Controller
{
    public static function lookUp($phone, $code)
    {
        try{
            $sender = "1000596446";

            $message = "خوش آمدید.رمز ورود:".$code;

            $receptor = $phone;

           Kavenegar::Send($sender,$receptor,$message);

        }
        catch(ApiException $e){
            echo $e->errorMessage();
        }
        catch(HttpException $e){
            echo $e->errorMessage();
        }
    }
}
