<?php
// config for palPalani/ClassName
return [
    'messaging' => [
        'username' => env('BANDWIDTH_MESSAGING_USERNAME'),
        'password' => env('BANDWIDTH_MESSAGING_PASSWORD'),
        'account_id' => env('BANDWIDTH_MESSAGING_ACCOUNT_ID'),
    ],
    'voice' => [
        'username' => env('BANDWIDTH_VOICE_USERNAME'),
        'password' => env('BANDWIDTH_VOICE_PASSWORD'),
        'account_id' => env('BANDWIDTH_VOICE_ACCOUNT_ID'),
    ],
    'twoFactor' => [
        'username' => env('BANDWIDTH_TWO_FACTOR_USERNAME'),
        'password' => env('BANDWIDTH_TWO_FACTOR_PASSWORD'),
        'account_id' => env('BANDWIDTH_TWO_FACTOR_ACCOUNT_ID'),
    ],
    'webRtc' => [
        'username' => env('BANDWIDTH_WEBRTC_USERNAME'),
        'password' => env('BANDWIDTH_WEBRTC_PASSWORD'),
        'account_id' => env('BANDWIDTH_WEBRTC_ACCOUNT_ID'),
    ],
];
