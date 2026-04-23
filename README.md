<div align="center">

# TryHackUs CTF

**A deliberately vulnerable PHP + MySQL + Apache CTF lab**

Cyberpunk-styled, story-driven, Turkish UI + English hints, built for local labs and training environments.

<p>
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img alt="MySQL" src="https://img.shields.io/badge/MySQL%20%2F%20MariaDB-Required-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img alt="Apache" src="https://img.shields.io/badge/Apache-mod__rewrite%20%2B%20.htaccess-D22128?style=for-the-badge&logo=apache&logoColor=white">
  <img alt="Purpose" src="https://img.shields.io/badge/Purpose-Education%20Only-111111?style=for-the-badge">
</p>

</div>

---

## Overview

TryHackUs CTF is a classic LAMP-style training lab designed around **intentionally vulnerable challenge surfaces**.  
The project uses:

- **Vanilla PHP**
- **MySQL / MariaDB**
- **Apache + mod_rewrite + .htaccess**
- **Turkish interface text**
- **English challenge hints and vulnerability guidance**

It is meant for:

- local lab setups
- private training environments
- demo boxes / workshop exercises
- self-hosted CTF practice

It is **not** intended for internet-facing production deployment.

---

## Features

- Story-driven underground portal theme
- Cyberpunk / terminal-inspired interface
- 20 challenge flags
- Mixed difficulty progression: easy → insane
- Deliberately vulnerable authentication, file handling, API, and admin flows
- Turkish story text with English technical hints
- Simple structure for customization and extension

---

## Tech Stack

- **PHP 8.1+**
- **MySQL / MariaDB**
- **Apache**
- **mod_rewrite**
- **.htaccess support**

---

## Project Structure

```text
.
├── admin/          # Admin panel, logs, config surfaces
├── api/            # API endpoints used by challenges
├── c2/             # Hidden / chained attack surfaces
├── db/             # Database bootstrap SQL
├── includes/       # Shared config, auth, db and helper logic
├── static/         # CSS / JS assets
├── uploads/        # Writable upload target
├── *.php           # Main application pages
├── robots.txt
└── README.md
```

---

## Requirements

Before starting, make sure you have:

- PHP **8.1+**
- Apache with:
  - `mod_rewrite` enabled
  - `.htaccess` support enabled
- MySQL or MariaDB
- Writable `uploads/` directory

Recommended environment:

- Ubuntu / Debian
- Apache 2.4+
- MariaDB 10.x+

---

## Quick Start

### 1) Copy the project into Apache document root

Example:

```bash
sudo cp -r THUctf /var/www/html/
```

Or configure a dedicated virtual host pointing to the project directory.

### 2) Update database config

Edit:

```bash
includes/config.php
```

Set your own:

- host / port or socket
- database name
- username / password
- base URL if needed

### 3) Import the database

```bash
mysql -u root -p < db/setup.sql
```

### 4) Make sure uploads are writable

```bash
chmod -R 775 uploads
```

### 5) Enable Apache rewrite support

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 6) Open the lab

```text
http://localhost/THUctf
```

or your configured vhost URL.

---

## Challenge Map

| ID | Challenge | Vulnerability |
|---:|---|---|
| 01 | Robots | Information disclosure |
| 02 | Source Code | Source code disclosure |
| 03 | Cookie Monster | Sensitive data in cookie |
| 04 | Reflected XSS | Reflected XSS |
| 05 | Directory Listing | Directory listing |
| 06 | HTTP Header | Sensitive data in header |
| 07 | SQL Injection (Login) | Auth bypass |
| 08 | IDOR | Broken object-level authorization |
| 09 | Stored XSS | Persistent XSS |
| 10 | Path Traversal | Arbitrary file read |
| 11 | File Upload | Unrestricted file upload |
| 12 | JWT None Algorithm | JWT misconfiguration |
| 13 | SQL Injection (UNION) | UNION-based SQLi |
| 14 | Broken Access Control | Admin API exposure |
| 15 | Log Injection + Path Traversal | LFI / log poisoning |
| 16 | SSRF | Server-side request forgery |
| 17 | XXE | XML external entity injection |
| 18 | Mass Assignment | Privilege escalation |
| 19 | Chained Access | Multi-step exploitation |
| 20 | Timing + Extension | Timing leak + hash abuse |

---

## Notes for Realistic Behavior

Some challenges rely on traditional Apache / LAMP behavior. For best results:

- prefer **Apache** over PHP built-in server
- keep `.htaccess` active
- use a real MySQL / MariaDB instance
- allow writable uploads where intended
- if testing encoded-path behavior, use compatible Apache settings such as:

```apache
AllowEncodedSlashes NoDecode
```

---

## Safety Notice

This repository contains **intentional vulnerabilities** for training purposes.

Use it only in:

- local environments
- isolated labs
- private CTF/training infrastructure

Do **not** expose it to the public internet unless you fully understand the risk.

---

## Customization Ideas

- Add more flags and story arcs
- Swap UI copy for another language
- Expand the admin / API / C2 routes
- Add Docker support
- Add seeded demo users or reset scripts
- Convert it into a workshop pack with writeups

---

## Suggested GitHub Additions

If you plan to publish this repository, consider adding:

- `LICENSE`
- `Dockerfile`
- `docker-compose.yml`
- `start.sh`
- screenshots / GIF demo
- setup walkthrough

---

## Disclaimer

This project is for **educational and laboratory use only**.

The vulnerabilities are intentional.
Do not deploy it as a public production application.
