<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSendController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_token = $request->token;
        Auth::user()->save();
        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(checkRequest $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $serverKey = 'AAAAEM5cICM:APA91bG5ILFu2rKqHLCIHEwAdXEPh5hNnd8FYvijv-cXtheOgkyxV87iOK7j9WmpHYaupmJAa2hV4IGaMROLHOMl_ohk850tGFkAHc4kZqXBArG4HwXKfpfp5KHY3VxMkO66RiUsoQka';
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);
        $headers = [
            'Authorization:key='. $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        if($result){
            return ("Done");
        }
        else {
            return "Error!";
        }
    }
}
