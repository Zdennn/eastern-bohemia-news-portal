# Zpravodaj Výhodních Čech - News Portal

## About the Project

A regional news portal dedicated to the Eastern Bohemia region of the Czech Republic. This application was developed as a high school graduation project by Zdeněk Michalec in 2025.

The system serves as a platform for publishing and reading regional news. It includes a custom-built content management system (CMS), role-based access control, and a responsive frontend layout.

## **Language Disclaimer**

The source code and GUI of this project are in Czech, as it was originally built for a local audience. This English README is provided to explain the app's logic and features to a broader audience.

## Features

### Public Interface (Readers)
- Browse the latest news articles.
- Search and filter content by categories (Culture, Sports, Economy, Events) and tags.
- Read full articles and engage in comment threads.
- Rate articles and individual comments.
- User registration and account management.

### Redaction (Authors)
- Create, edit, and format articles using the TinyMCE rich text editor.
- Upload and manage media/images attached to articles.
- Submit drafts for publication and track article view counts.

### Administration (Admins)
- Centralized dashboard for site overview.
- User management and role assignment (Reader, Author, Admin).
- Content moderation for articles and user comments.
- Manage taxonomy (categories and tags).
- View basic site analytics and engagement metrics.

## Technical Architecture

The application is built on a custom MVC (Model-View-Controller) architecture using object-oriented PHP to ensure separation of logic and presentation.

### Technology Stack
- **Backend**: PHP 8.2+, MySQL 8.0+
- **Database Layer**: PDO (PHP Data Objects) utilizing prepared statements
- **Frontend**: HTML5, CSS3 (custom styling), JavaScript (ES6+)
- **Dependencies**: Composer and npm (primarily for TinyMCE integration)

### Core System Mechanics
- **Routing**: Custom URL router mapping requests to specific controllers (e.g., `/clanek/[id]`).
- **Templating**: Native PHP-based templating utilizing layout inheritance.
- **Security**: Session-based authentication, secure password hashing, and input sanitization to prevent XSS and SQL injection.

## Database Schema

The system uses a MySQL relational database consisting of the following primary tables:

- **clanky**: Articles (title, content, teaser, excerpt, views, timestamps)
- **uzivatele**: Users (username, email, password, role)
- **kategorie**: Categories (name, description)
- **tag**: Tags (name)
- **komentar**: Comments (content, article reference, user reference)
- **hodnoceni_clanku**: Article ratings
- **hodnoceni_komentare**: Comment ratings
- **clanky_tagy**: Many-to-many relationship between articles and tags
- **obrazek**: Image metadata and paths
- **role**: User roles (reader, author, admin)
- **stav**: Article status (draft, published, archived)

## Installation and Setup

### Prerequisites
- Web Server (Apache/Nginx)
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer and Node.js/npm

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd eastern-bohemia-news-portal
   ```

2. **Database Setup**
   - Create a new MySQL database
   - Import the provided SQL schema: `_db/zpravodajskyportal.sql`
   - Update database connection settings in `_db/database.php`

3. **Web Server Configuration**
   - Point your web server's document root to the `eastern-bohemia-news-portal` directory.
   - Ensure URL rewriting is enabled (e.g., `mod_rewrite` for Apache) to support the custom routing system.

4. **Dependencies**
   ```bash
   # Install PHP dependencies
   composer install

   # Install frontend dependencies
   npm install
   ```

5. **Permissions & Initialization**:
   - Ensure the web server has write permissions for the designated upload and session directories.
   - Open the application in a web browser.
   - Register a new user and update their role to Admin directly in the database to gain initial dashboard access.

## Project Structure

```
eastern-bohemia-news-portal/
├── index.php                    # Application entry point
├── package.json                 # Frontend dependencies (TinyMCE)
├── _db/ 
│   ├── zpravodajskyportal.sql   # Demo data and structure of database
│   └── database.php             # Database configuration
├── docs/                        # PDF documentation
├── assets/ 
│   ├── img/                     # Images
│   ├── js/                      # JavaScript files
│   │   ├── clanek.js            # Article page interactions
│   │   ├── dashboard.js         # Admin dashboard functionality
│   │   └── ...                  # Other JS modules
│   └── styly/                   # CSS stylesheets
│       ├── main.css             # Main stylesheet
│       ├── index.css            # Homepage styles
│       └── ...                  # Component-specific styles
├── controller/                  # MVC Controllers
│   ├── RouterController.php     # URL routing logic
│   ├── IndexController.php      # Homepage controller
│   ├── ClanekController.php     # Article management
│   ├── DashboardController.php  # Admin panel
│   └── ...                      # Other controllers
├── model/                       # MVC Models
│   ├── Clanek.php               # Article model
│   ├── Uzivatel.php             # User model
│   ├── Kategorie.php            # Category model
│   ├── Tag.php                  # Tag model
│   ├── Komentar.php             # Comment model
│   └── ...                      # Other models
└── view/                        # MVC Views
    ├── layout.php               # Main layout template
    ├── layoutDashboard.php      # Admin layout
    ├── index.php                # Homepage view
    ├── clanek.php               # Article detail view
    └── ...                      # Other view templates
```

## Author

**Zdeněk Michalec** - High School Graduation Project, 2025