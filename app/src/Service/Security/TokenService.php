<?php

namespace App\Service\Security;

class TokenService
{
    public function generateToken(string $payload, string $secret)
    {
        $header = json_encode(
      [
        'typ' => 'JWT',
        'alg' => 'HS256',
      ]
    );

        $encodedHeader = $this->encode64($header);
        $encodedPayload = $this->encode64($payload);
        // signature en sha256
        $signature = hash_hmac('sha256', $encodedHeader.'.'.$encodedPayload, $secret, true);

        $token = $encodedHeader.'.'.$encodedPayload.'.'.$this->encode64($signature);

        return $token;
    }

    public function getPayload(string $token, bool $json = false)
    {
        $exploded_token = \explode('.', $token);
        $base64_payload = \base64_decode($exploded_token[1]);

        return $json ? $base64_payload : json_decode($base64_payload);
    }

    private function encode64(string $toEncode)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($toEncode));
    }

}
