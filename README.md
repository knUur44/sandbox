# Vulnerable PHP App — DevSecOps Testbed

> ⚠️ **This application is intentionally insecure.** It exists purely to produce
> findings for security CI/CD workflows. **Never deploy it, expose it to a
> network, or run it with real data or real credentials.**

This repo is a deliberately vulnerable PHP application used to learn and test
security scanning GitHub Actions:

- **Frogbot (Scan & Fix)** — JFrog SCA for vulnerable dependencies
- **JFrog SAST** — static analysis of the source code
- **OSSF Scorecard** — repository security-posture scoring
- **Synopsys / Black Duck Action** — SCA + SAST
- **SonarQube** — code quality + security hotspots
- **Semgrep** — pattern-based SAST

## What's intentionally wrong

### Vulnerable dependencies (SCA targets — Frogbot, Synopsys, JFrog Xray)

Declared in `composer.json` with known-CVE versions, e.g.:

| Package | Version | Example issue |
|---|---|---|
| `phpmailer/phpmailer` | 5.2.16 | CVE-2016-10033 — RCE via mail() |
| `monolog/monolog` | 1.11.0 | Known deserialization issues |
| `guzzlehttp/guzzle` | 6.2.0 | Cookie/redirect CVEs |
| `twig/twig` | 1.35.0 | Sandbox escapes |
| `symfony/http-foundation` | 2.8.0 | Multiple CVEs |
| `league/flysystem` | 1.0.0 | TOCTOU / path issues |
| `firebase/php-jwt` | 3.0.0 | `none` algorithm acceptance |
| `smarty/smarty` | 3.1.32 | SSTI / RCE CVEs |
| `erusev/parsedown` | 1.7.0 | XSS |

### Vulnerable code (SAST targets — Semgrep, JFrog SAST, SonarQube, Coverity)

| File | Issue | CWE |
|---|---|---|
| `config/config.php` | Hardcoded secrets / API keys, debug on | CWE-798, CWE-489 |
| `src/Database.php` | SQL Injection, MD5 password hashing | CWE-89, CWE-327 |
| `src/UserController.php` | Reflected XSS, insecure deserialization, open redirect, weak RNG | CWE-79, CWE-502, CWE-601, CWE-330 |
| `src/FileManager.php` | LFI / path traversal, arbitrary upload, command injection | CWE-22, CWE-434, CWE-78 |
| `src/ApiClient.php` | SSRF, TLS verify disabled, weak crypto, `eval()` RCE | CWE-918, CWE-295, CWE-327, CWE-95 |
| `src/TemplateRenderer.php` | Server-Side Template Injection, JWT `none` | CWE-1336, CWE-347 |

## Layout

```
config/config.php        hardcoded secrets + config
public/index.php         front controller (routes to the vulnerable code)
src/                     vulnerable classes
views/home.php           demo view (reflected XSS)
composer.json            intentionally outdated dependencies
```

## Local setup (optional)

```bash
composer install        # pulls the old, vulnerable dependencies
```

You do **not** need to run the app to get scanner output — most of these
workflows analyze the source and `composer.json`/`composer.lock` statically.
