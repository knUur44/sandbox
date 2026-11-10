<?php

namespace App;

use mysqli;

/**
 * Thin database wrapper.
 *
 * Intentionally vulnerable: queries are built with string concatenation to
 * demonstrate SQL Injection (CWE-89) for SAST tooling.
 */
class Database
{
    /** @var mysqli */
    private $conn;

    public function __construct()
    {
        // Suppress connection errors for the demo.
        $this->conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * VULNERABLE: SQL Injection via unsanitized concatenation (CWE-89).
     */
    public function getUserByName($username)
    {
        $sql = "SELECT id, username, email FROM users WHERE username = '" . $username . "'";
        return $this->conn->query($sql);
    }

    /**
     * VULNERABLE: SQL Injection in a login check (CWE-89 + CWE-287).
     */
    public function login($username, $password)
    {
        // Password hashed with insecure MD5 (CWE-327).
        $hash = md5($password);
        $sql  = "SELECT * FROM users WHERE username = '$username' AND password = '$hash'";
        $res  = $this->conn->query($sql);

        return $res && $res->num_rows > 0;
    }

    /**
     * VULNERABLE: second-order SQLi, value taken directly from request.
     */
    public function search($term)
    {
        $sql = "SELECT * FROM products WHERE name LIKE '%{$term}%' ORDER BY {$_GET['sort']}";
        return $this->conn->query($sql);
    }
}
