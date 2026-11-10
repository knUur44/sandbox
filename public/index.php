<?php
/**
 * Front controller for the intentionally vulnerable demo app.
 *
 * ############################################################################
 * #  WARNING: This application is DELIBERATELY INSECURE.                      #
 * #  It exists only to generate findings for security CI/CD workflows        #
 * #  (Frogbot, JFrog SAST, OSSF Scorecard, Synopsys, SonarQube, Semgrep).    #
 * #  NEVER deploy it, expose it to a network, or run it with real data.      #
 * ############################################################################
 */

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use App\ApiClient;
use App\Database;
use App\FileManager;
use App\UserController;

$action = $_GET['action'] ?? 'home';

$user = new UserController();
$db   = new Database();
$file = new FileManager();
$api  = new ApiClient();

switch ($action) {
    case 'greet':
        $user->greet();
        break;

    case 'login':
        // VULNERABLE: credentials pulled straight from the request into SQLi.
        var_dump($db->login($_POST['username'], $_POST['password']));
        break;

    case 'search':
        $db->search($_GET['q'] ?? '');
        break;

    case 'render':
        $file->render();
        break;

    case 'ping':
        echo $api->fetch();
        break;

    case 'eval':
        // VULNERABLE: directly exposes eval() to the internet.
        var_dump($api->evaluate());
        break;

    default:
        echo '<h1>Vulnerable Demo App</h1>';
        echo '<p>For security-tooling tests only.</p>';
}
