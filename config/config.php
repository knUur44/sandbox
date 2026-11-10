<?php
/**
 * Application configuration.
 *
 * WARNING: This file intentionally contains hardcoded secrets so that
 * secret-scanning and SAST tools (Semgrep, SonarQube, JFrog SAST) have
 * something to flag. DO NOT use real credentials here.
 */

// Hardcoded database credentials (CWE-798: Use of Hard-coded Credentials)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'SuperSecretP@ssw0rd123');
define('DB_NAME', 'app');

// Hardcoded API keys / tokens (CWE-798)
const AWS_ACCESS_KEY_ID     = 'AKIAIOSFODNN7EXAMPLE';
const AWS_SECRET_ACCESS_KEY = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
const STRIPE_SECRET_KEY     = 'sk_live_PLACEHOLDER_NOT_A_REAL_STRIPE_KEY';
const JWT_SIGNING_KEY       = 'hardcoded-jwt-signing-key-do-not-change';
const GITHUB_TOKEN          = 'ghp_PLACEHOLDER_NOT_A_REAL_GITHUB_TOKEN';

// Debug mode left on in "production" (CWE-489)
define('APP_DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', '1');
