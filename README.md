# Luminara CMS

A **PHP & MySQL blog Content Management System** built for multiple authors, featuring a beautiful Figma-inspired design using the Lemonada font and your custom Luminara logo.

---

## Features

- User Registration & Secure Login (passwords hashed)
- Authors create, edit, delete, and publish posts
- Draft/published post status
- Visitors can browse all published posts (no login required)
- Responsive, modern UI (gradient backgrounds, sidebar navigation, rounded blog cards)
- Author dashboard for post management
- Full blog post view
- Minimal JS for basic interactivity

---

## Tech Stack

- PHP 8.x
- MySQL 8.x
- HTML5, CSS3 ([Lemonada font](https://fonts.google.com/specimen/Lemonada)), minimal JavaScript
- Figma design ([see `/assets/luminara-logo.png`](assets/luminara-logo.png))

---

## Getting Started

### 1. Set up the database

Run the SQL script in your MySQL client:

```sql
CREATE DATABASE IF NOT EXISTS luminara;
USE luminara;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft',
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
);
```

### 2. Update database configuration

Edit `config.php` if needed:

```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'luminara');
```

### 3. File Structure

```
/
├── assets/
│   ├── style.css
│   └── luminara-logo.png
├── config.php
├── db.sql
├── index.php
├── login.php
├── register.php
├── logout.php
├── dashboard.php
├── view_post.php
├── create_post.php
├── edit_post.php
├── README.md
```

---

## Screenshots

UI based on Figma (Lemonada font) with modern gradients and sidebar:

- ![Luminara Logo](assets/luminara-logo.png)
- ![Login UI](docs/login-ui.png)
- ![Dashboard UI](docs/dashboard-ui.png)

---

## License

MIT (or your preferred license)