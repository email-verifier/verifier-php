<?php

namespace EmailVerifier;
use InvalidArgumentException;
use RuntimeException;

/**
 * Email verification library
 * https://github.com/email-verifier/verifier-php
 */

class EmailVerifier
{
    private string $baseUrl = 'https://verifyright.co/verify/';
    private string $accessToken;

    /**
     * EmailVerifier constructor
     * 
     * @param string $accessToken The API access token
     */
    public function __construct(string $accessToken)
    {
        if (empty($accessToken)) {
            throw new InvalidArgumentException('Access token cannot be empty');
        }
        $this->accessToken = $accessToken;
    }

    protected function makeRequest(string $url)
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('Curl request failed: ' . $error);
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new RuntimeException('API request failed with status code: ' . $httpCode);
        }

        return json_decode($result, true);
    }

    /**
     * Verify an email address
     * 
     * @param string|null $email Email address to verify
     * @param bool $details Whether to return full verification details
     * @return mixed Array with status or full object with details
     * @throws InvalidArgumentException If email is invalid
     * @throws RuntimeException If API request fails
     */
    public function verifyEmail(?string $email, bool $details = false)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }

        $url = $this->baseUrl . urlencode($email) . '?token=' . $this->accessToken;
        $data = $this->makeRequest($url);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Failed to parse API response');
        }

        return $details ? $data : ($data['status'] ?? null);
    }
}


?>
