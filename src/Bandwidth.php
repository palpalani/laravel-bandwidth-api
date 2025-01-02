<?php

namespace palPalani\Bandwidth;

use BandwidthLib\Messaging\Models\MessageRequest;
use Iris\Account;
use Throwable;

class Bandwidth
{
    public function sendMessage(string $from, array $to, string $text, string $applicationId)
    {
        $messagingClient = app('bandwidth')->getMessaging()->getClient();

        $body = new MessageRequest;
        $body->from = $from;
        $body->to = $to;
        $body->applicationId = $applicationId;
        $body->text = $text;

        try {
            $response = $messagingClient->createMessage(config('bandwidth.messaging.account_id'), $body);
            print_r($response);
        } catch (Throwable $e) {
            print_r($e);
        }
    }

    public function getAccount(): Account
    {
        return new Account(config('bandwidth.messaging.account_id'), app('phone'));
    }
}
