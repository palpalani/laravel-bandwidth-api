<?php

namespace palPalani\Bandwidth;

use BandwidthLib\Messaging\Models\MessageRequest;
use Iris\Account;
use Throwable;

class Bandwidth
{
    public function sendMessage(string $from, array $to, string $text)
    {
        $messagingClient = app('bandwidth')->getMessaging()->getClient();

        $body = new MessageRequest;
        $body->from = $from;
        $body->to = $to;
        $body->applicationId = config('bandwidth.messaging.application_id');
        $body->text = $text;

        try {
            $response = $messagingClient->createMessage(config('bandwidth.messaging.account_id'), $body);

            $result = $this->extractResult($response);

            $messageId = $result->id ?? null;

            return [
                'success' => true,
                'message' => 'Message sent successfully.',
                'id' => $messageId,
                'data' => $result,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Failed to send message.',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function extractResult($response)
    {
        if ($response instanceof \BandwidthLib\Http\ApiResponse) {
            return $response->getResult(); 
        }

        throw new \RuntimeException('Unexpected response type.');
    }

    public function getAccount(): Account
    {
        return new Account(config('bandwidth.messaging.account_id'), app('phone'));
    }
}
