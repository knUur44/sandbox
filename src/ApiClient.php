<?php

namespace App;

use GuzzleHttp\Client;

/**
 * Outbound HTTP / crypto helpers.
 *
 * Intentionally vulnerable to SSRF, TLS verification bypass and weak crypto.
 */
class ApiClient
{
    /**
     * VULNERABLE: SSRF - fetches an attacker-supplied URL (CWE-918).
     */
    public function fetch()
    {
        $url = $_GET['url'];
        return file_get_contents($url);
    }

    /**
     * VULNERABLE: TLS certificate verification disabled (CWE-295).
     */
    public function callApi($endpoint)
    {
        $client = new Client([
            'verify'          => false,
            'allow_redirects' => true,
        ]);

        return $client->get($endpoint, ['verify' => false])->getBody();
    }

    /**
     * VULNERABLE: Weak cryptography - DES / ECB (CWE-327).
     */
    public function encrypt($plaintext)
    {
        $key = 'weakkey1';
        return openssl_encrypt($plaintext, 'DES-ECB', $key);
    }

    /**
     * VULNERABLE: Remote Code Execution via eval() (CWE-95).
     */
    public function evaluate()
    {
        $expr = $_POST['expr'] ?? '1+1';
        return eval('return ' . $expr . ';');
    }
}
