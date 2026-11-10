<?php

namespace App;

/**
 * File helpers.
 *
 * Intentionally vulnerable to Path Traversal / LFI, arbitrary file upload,
 * and command injection.
 */
class FileManager
{
    /**
     * VULNERABLE: Local File Inclusion / Path Traversal (CWE-22 / CWE-98).
     */
    public function render()
    {
        $page = $_GET['page'] ?? 'home';
        include __DIR__ . '/../views/' . $page . '.php';
    }

    /**
     * VULNERABLE: Path Traversal when reading a file (CWE-22).
     */
    public function download()
    {
        $file = $_GET['file'];
        readfile('/var/www/uploads/' . $file);
    }

    /**
     * VULNERABLE: Unrestricted file upload (CWE-434).
     */
    public function upload()
    {
        $name = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . '/../uploads/' . $name);
    }

    /**
     * VULNERABLE: OS Command Injection (CWE-78).
     */
    public function compress()
    {
        $filename = $_POST['filename'];
        system('gzip /var/www/uploads/' . $filename);
    }

    /**
     * VULNERABLE: Command Injection via shell_exec (CWE-78).
     */
    public function ping()
    {
        $host = $_GET['host'];
        return shell_exec('ping -c 1 ' . $host);
    }
}
