<?php

namespace palPalani\Bandwidth;

use BandwidthLib\Messaging\Models\MessageRequest;
use Throwable;

class Bandwidth
{
    public function sendMessage(string $from, array $to, string $text)
    {
        $messagingClient = app('bandwidth')->getMessaging()->getClient();

        $body = new MessageRequest();
        $body->from = $from;
        $body->to = $to;
        $body->applicationId = "1234-ce-4567-de";
        $body->text = $text;

        try {
            $response = $messagingClient->createMessage(config('bandwidth.messaging.account_id'), $body);
            print_r($response);
        } catch (Throwable $e) {
            print_r($e);
        }
    }
}
