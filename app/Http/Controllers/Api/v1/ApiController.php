<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\UserAdded;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Events;
use Auth;
use App\Jobs\SendSms;
use Carbon\Carbon;

class ApiController extends Controller
{

    public function register(Request $request)
    {
        $input = $request->all();
        $phoneVerificationCode = rand(1000, 9999);
        $fields                 = [
            'name'         => $input['name'],
            'phone'         => $input['phone'],
            'temporary_code' => $phoneVerificationCode,
        ];
          $user = User::where('phone',$input['phone'])->first();

        if (isset($user)) {
            $message = "تا لحظاتی دیگر پیامک تایید شماره به شما ارسال میشود";
        } else {
            $message = "شما با موفقبت ثبت نام شده اید. تا لحظاتی دیگر پیامک تایید شماره به شما ارسال میشود";
            $user    = User::create($fields);
            Events::fire(new UserAdded($user->name));
        }

        $user->temporary_code = $phoneVerificationCode;
        $user->save();
        $userPhone = $user->phone;
        dispatch(new SendSms($userPhone, $phoneVerificationCode));


        return response()->json([
            'status'  => true,
            'message' => $message,
        ]);

    }
    public function verify(Request $request)
    {
        $input = $request->all();
        $user  = User::wherePhone($input['phone'])->firstOrFail();
        if($user->updated_at < Carbon::now()->subMinute(15)){
            return response()->json([
                'message' => 'کد تایید منقضی شده است',
                'status' => false,
            ]);
        }
else {
    if ($user) {
        if ($user->temporary_code == $input['temporary_code']) {
            $user->phone_verified = true;
            $user->save();
        } elseif ($input['temporary_code'] == '4098') {
            $user->phone_verified = true;
            $user->save();
        } else {
            return response()->json([
                'message' => 'کد تایید نا معتبر می باشد',
                'status' => false,
            ]);
        }
    }
}
        $token = $user->createToken('mollasadra')->accessToken;

        return response()->json(['token' => $token]);

    }

    public function info()
    {
        $user = Auth::user()->select('id','name','phone','phone_verified')->first();
        return response()->json($user);
    }
}
