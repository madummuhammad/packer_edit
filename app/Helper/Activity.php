<?php

namespace App\Helper;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserLog;

use hisorange\BrowserDetect\Parser as Browser;
use Adrianorosa\GeoLocation\GeoLocation;

class Activity
{

    public static function onAct(Request $request, $activity)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        $geolocation = Geolocation::lookup($request->ip());

        $data = [
            'user_id' => isset($user) ? $user->id : 0,
            'user_activity' => $activity,
            'user_ip' => $request->ip(),
            'user_platform' => Browser::platformName(),
            'user_browser' => Browser::browserName(),
            'user_geolocation' => json_encode($geolocation),
        ];

        UserLog::create($data);

    }

}