<?php
/**
 * Default view. Reached via FileManager::render() which is vulnerable to LFI,
 * so this file is only the "happy path" landing page.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Vulnerable Demo App</title>
</head>
<body>
    <h1>Vulnerable Demo App</h1>
    <!-- VULNERABLE: reflected XSS directly in a view (CWE-79) -->
    <p>You searched for: <?php echo $_GET['q'] ?? ''; ?></p>
</body>
</html>
