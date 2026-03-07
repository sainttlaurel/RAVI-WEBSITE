# RAVI Modular Cabinet - Booking System

> Personal project for learning web development: appointment booking system with Firebase integration and admin dashboard.

[![Status](https://img.shields.io/badge/status-in%20development-yellow)]()
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)]()
[![Firebase](https://img.shields.io/badge/Firebase-Realtime%20DB-orange)]()
[![License](https://img.shields.io/badge/license-MIT-green)]()

**Note:** Educational project. Not production-ready without further security improvements.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Admin Dashboard](#admin-dashboard)
- [Database Structure](#database-structure)
- [Security](#security)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

RAVI Modular Cabinet Booking System is a web app built to practice:

- PHP backend development
- Firebase Realtime Database
- Responsive design and interactive UI
- Session-based authentication
- CRUD operations

Includes:

- 5-page website: Home, Gallery, About, Contact, Booking
- Customer booking system with validation
- Admin dashboard
- Search, filter, bulk operations, print views

---

## Features

**Customer:**

- Browse website pages
- Book appointments
- Real-time search/filter
- Animated statistics
- Fully responsive

**Admin:**

- Dashboard with statistics
- Real-time search and filter
- Bulk operations: delete, mark complete
- Print-friendly view
- Mobile-friendly

---

## System Architecture


Customer Interface -> Form Submission -> Firebase Realtime DB -> Admin Interface


**Tech Stack:**

- **Frontend:** HTML5, CSS3, JS (ES6+), Google Fonts, Font Awesome  
- **Backend:** PHP 7.4+, Firebase Realtime DB, Session auth  
- **Server:** Apache (XAMPP), cURL for Firebase API  

---

## Quick Start

**Prerequisites:**

- XAMPP or PHP server
- Browser
- Firebase account
- Internet connection

**Steps:**

1. Start Apache via XAMPP
2. Update Firebase URL in `config.php`
3. Test database with `test_database.php`

**Default Admin:** `admin@example.com` / `admin123` (change before use)

---

## Installation

```bash
git clone https://github.com/yourusername/ravi-cabinet.git

Configure Firebase (URL & rules)

Test database connection

Configuration

Admin credentials: PHP/adminlogin.php

Firebase URL: ravi(htdocs)FIREBASE-PHP/config.php

Service types: PHP/forms.php

Usage

Customer:

Book appointments via form

Browse homepage, gallery, about, contact pages

Admin:

Log in via adminlogin.php

Manage appointments: search, filter, view, complete, delete, bulk actions, print

Admin Dashboard

Overview of total, pending, completed appointments

Appointment table with search/filter

Bulk operations

Clean, responsive UI

Database Structure
{
  "appointments": {
    "-ID1": {
      "name": "John Doe",
      "phone": "09123456789",
      "email": "john@example.com",
      "address": "Manila",
      "service": "kitchen",
      "message": "Custom kitchen cabinets",
      "timestamp": "2026-03-07 14:30:00",
      "status": "pending"
    }
  }
}
Security

Session-based authentication

Input validation & sanitization

XSS protection

Confirmation dialogs for destructive actions

Recommended for production:

Password hashing

HTTPS

Firebase security rules

CSRF protection

Rate limiting

Troubleshooting

Firebase issues: check URL, rules, internet, cURL

Session errors: session_start() at top, no BOM

Admin page empty: check session & Firebase data

File Structure
RAVI WEBSITE/
├── index.php
├── PHP/               # Website and admin files
├── CSS/               # Stylesheets
├── JS/                # Scripts
├── ravi(htdocs)FIREBASE-PHP/ # Firebase integration
├── test_database.php
└── Documentation/
Contributing

Fork the repo

Create a feature branch

Commit & push changes

Open a pull request

Focus: security, UI/UX, performance, refactoring, documentation

License

MIT License - see LICENSE

Last updated: March 7, 2026
Author: Personal project - GitHub
