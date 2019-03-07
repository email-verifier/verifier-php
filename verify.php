<?php

/**
 * verify email from curl request
 * https://github.com/email-verifier/verifier-php
 */

function verifyEmail($email = null, $access_token, $details = false)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://verifier.meetchopra.com/verify/'. $email .'?token='. $access_token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Error:'. curl_error($ch);
    }
    
    curl_close ($ch);

    if ($details) {
        return json_decode($result);
    } else {
        $data = json_decode($result);
        return $data['status'];
    }
}


?>
