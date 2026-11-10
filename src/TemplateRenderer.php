<?php

namespace App;

use Firebase\JWT\JWT;

/**
 * Template + token helpers.
 *
 * Intentionally vulnerable to Server-Side Template Injection and JWT misuse.
 */
class TemplateRenderer
{
    /**
     * VULNERABLE: Server-Side Template Injection (CWE-1336).
     * Untrusted input is compiled as a template.
     */
    public function renderInline($userTemplate)
    {
        $loader = new \Twig\Loader\ArrayLoader([
            'page' => $userTemplate, // attacker controls the template source
        ]);
        $twig = new \Twig\Environment($loader);

        return $twig->render('page', ['user' => $_SESSION['user'] ?? null]);
    }

    /**
     * VULNERABLE: JWT signed/verified with 'none' and a hardcoded key (CWE-347).
     */
    public function issueToken(array $claims)
    {
        return JWT::encode($claims, JWT_SIGNING_KEY);
    }

    public function verifyToken($token)
    {
        // Accepting 'none' allows forged tokens.
        return JWT::decode($token, JWT_SIGNING_KEY, ['none', 'HS256']);
    }
}
