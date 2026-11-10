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
