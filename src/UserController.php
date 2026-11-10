<?php

namespace App;

/**
 * Handles user-facing actions.
 *
 * Intentionally vulnerable to XSS, insecure deserialization and open redirect.
 */
class UserController
{
    /**
     * VULNERABLE: Reflected XSS (CWE-79) - user input echoed without escaping.
     */
    public function greet()
    {
        $name = $_GET['name'] ?? 'guest';
        echo "<h1>Hello, {$name}!</h1>";
    }

    /**
     * VULNERABLE: DOM/Reflected XSS through a script context.
     */
    public function profile()
    {
        $bio = $_REQUEST['bio'] ?? '';
        echo "<script>var bio = '" . $bio . "';</script>";
    }

    /**
     * VULNERABLE: Insecure deserialization of attacker-controlled data (CWE-502).
     */
    public function loadPreferences()
    {
        $data = $_COOKIE['prefs'] ?? '';
        return unserialize($data);
    }

    /**
     * VULNERABLE: Open redirect (CWE-601).
     */
    public function redirect()
    {
        $url = $_GET['next'] ?? '/';
        header('Location: ' . $url);
        exit;
    }

    /**
     * VULNERABLE: PHP object injection + weak randomness for token (CWE-330).
     */
    public function newToken()
    {
        // mt_rand is not cryptographically secure.
        return md5(mt_rand() . time());
    }
}
