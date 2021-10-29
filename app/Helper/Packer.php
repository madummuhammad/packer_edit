<?php

namespace App\Helper;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserLog;

use App\Jobs\SendEmailJob;

use Crypt;

class Packer
{

    public static function sendEmailVerification($email, $data = [])
    {

        $data['email'] = $email;
        $data['link'] = url('/api/check-verification') . '/' . Crypt::encryptString($email);
        $data['type'] = 'verification';

        dispatch(new SendEmailJob($data));

    }

    public static function sendEmailForgotPassword($email, $fullname, $data = [])
    {

        $data['email'] = $email;
        $data['name'] = $fullname;
        $data['link'] = url('/change-password') . '/' . Crypt::encryptString($email);
        $data['type'] = 'reset';

        dispatch(new SendEmailJob($data));

    }

}