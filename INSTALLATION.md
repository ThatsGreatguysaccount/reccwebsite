# Installation Guide

This guide will walk you through the complete installation and configuration of the Platform application on a Linux server (VDS/VPS).

## Table of Contents

1. [Prerequisites](#1-prerequisites)
2. [MySQL Database Setup](#2-mysql-database-setup)
3. [Apache Configuration with SSL](#3-apache-configuration-with-ssl)

---

## 1. Prerequisites

Before installing the application, ensure the following software is installed on your server:

### Required Software

#### PHP (8.1 or 8.2)
```bash
# Install PHP and required extensions
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-common php8.1-mysql \
    php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath \
    php8.1-intl php8.1-soap php8.1-redis

# Or for PHP 8.2
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-common php8.2-mysql \
    php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath \
    php8.2-intl php8.2-soap php8.2-redis

# Verify PHP installation
php -v
```

**Important Extensions:**
- `php-mysql` - MySQL database connection
- `php-gd` - Image processing (required for team member photo resizing)
- `php-mbstring` - String handling
- `php-xml` - XML processing
- `php-curl` - HTTP requests (CoinGecko API)
- `php-zip` - Archive handling
- `php-bcmath` - Arbitrary precision mathematics

#### MySQL (8.0 or higher)
```bash
# Install MySQL Server
sudo apt update
sudo apt install mysql-server

# Secure MySQL installation
sudo mysql_secure_installation

# Verify MySQL installation
mysql --version
```

#### Apache Web Server
```bash
# Install Apache
sudo apt update
sudo apt install apache2

# Enable required Apache modules
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers

# Verify Apache installation
apache2 -v
```

#### Composer (PHP Dependency Manager)
```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify Composer installation
composer --version
```

#### Node.js and npm
```bash
# Install Node.js 18.x or higher
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Or use Node Version Manager (nvm)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
source ~/.bashrc
nvm install 18
nvm use 18

# Verify Node.js and npm installation
node -v
npm -v
```

#### Git
```bash
# Install Git
sudo apt update
sudo apt install git

# Verify Git installation
git --version
```

### System Requirements

- **Operating System:** Ubuntu 20.04 LTS or higher / Debian 11 or higher
- **RAM:** Minimum 2GB (4GB recommended)
- **Storage:** Minimum 10GB free space
- **PHP:** 8.1 or 8.2
- **MySQL:** 8.0 or higher
- **Node.js:** 18.x or higher
- **Apache:** 2.4 or higher

---

## 2. MySQL Database Setup

### Step 1: Create Database and User

```bash
# Login to MySQL as root
sudo mysql -u root -p
```

Once logged in, run the following SQL commands:

```sql
-- Create database
CREATE DATABASE platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user (replace 'your_password' with a strong password)
CREATE USER 'platform_user'@'localhost' IDENTIFIED BY 'your_strong_password_here';

-- Grant privileges
GRANT ALL PRIVILEGES ON platform.* TO 'platform_user'@'localhost';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;

-- Exit MySQL
EXIT;
```

### Step 2: Configure MySQL for Laravel

Edit MySQL configuration to ensure proper character set support:

```bash
# Edit MySQL configuration
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

Add or modify the following settings under `[mysqld]`:

```ini
[mysqld]
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
max_allowed_packet = 64M
innodb_buffer_pool_size = 256M
```

Restart MySQL:

```bash
sudo systemctl restart mysql
```

### Step 3: Test Database Connection

```bash
# Test connection with the new user
mysql -u platform_user -p platform

# If successful, you should see the MySQL prompt
# Type EXIT to leave
```

### Step 4: Update Laravel .env File

After cloning the repository and setting up the application, update the `.env` file:

```bash
cd /var/www/reccwebsite
nano .env
```

Update database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=platform
DB_USERNAME=platform_user
DB_PASSWORD=your_strong_password_here
```

### Step 5: Run Database Migrations

```bash
cd /var/www/reccwebsite
php artisan migrate --force
```

---

## 3. Apache Configuration with SSL

### Step 1: Basic Apache Configuration

#### Create Apache Virtual Host Configuration

```bash
# Create configuration file
sudo nano /etc/apache2/sites-available/reccwebsite.conf
```

Add the following configuration (HTTP only - we'll add SSL later):

```apache
<VirtualHost *:80>
    ServerName dargroupltd.com
    ServerAlias www.dargroupltd.com

    DocumentRoot /var/www/reccwebsite/public

    <Directory /var/www/reccwebsite/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/reccwebsite_error.log
    CustomLog ${APACHE_LOG_DIR}/reccwebsite_access.log combined
</VirtualHost>
```

#### Enable the Site

```bash
# Enable the site
sudo a2ensite reccwebsite.conf

# Disable default site (optional)
sudo a2dissite 000-default.conf

# Test Apache configuration
sudo apache2ctl configtest

# Restart Apache
sudo systemctl restart apache2
```

### Step 2: Set Proper Permissions

```bash
# Set ownership (replace 'www-data' with your Apache user if different)
sudo chown -R www-data:www-data /var/www/reccwebsite

# Set directory permissions
sudo chmod -R 755 /var/www/reccwebsite
sudo chmod -R 775 /var/www/reccwebsite/storage
sudo chmod -R 775 /var/www/reccwebsite/bootstrap/cache
```

### Step 3: Install SSL Certificate with Let's Encrypt

#### Install Certbot

```bash
# Install Certbot
sudo apt update
sudo apt install certbot python3-certbot-apache
```

#### Obtain SSL Certificate

```bash
# Obtain certificate (replace with your domain)
sudo certbot --apache -d dargroupltd.com -d www.dargroupltd.com

# Follow the prompts:
# - Enter your email address
# - Agree to terms of service
# - Choose whether to redirect HTTP to HTTPS (recommended: Yes)
```

Certbot will automatically:
- Obtain the SSL certificate
- Configure Apache with SSL
- Set up automatic renewal

#### Manual SSL Configuration (Alternative)

If you prefer to configure SSL manually, use the following configuration:

```bash
# Create SSL configuration
sudo nano /etc/apache2/sites-available/reccwebsite-ssl.conf
```

Add the following configuration:

```apache
<VirtualHost *:443>
    ServerName dargroupltd.com
    ServerAlias www.dargroupltd.com

    DocumentRoot /var/www/reccwebsite/public

    # SSL Configuration (set by Certbot)
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/dargroupltd.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/dargroupltd.com/privkey.pem
    Include /etc/letsencrypt/options-ssl-apache.conf

    # Security Headers - Force HTTPS and secure connections
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"

    <Directory /var/www/reccwebsite/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/reccwebsite_ssl_error.log
    CustomLog ${APACHE_LOG_DIR}/reccwebsite_ssl_access.log combined
</VirtualHost>
```

Enable SSL site:

```bash
sudo a2ensite reccwebsite-ssl.conf
sudo systemctl restart apache2
```

### Step 4: Configure HTTP to HTTPS Redirect

Update the HTTP virtual host to redirect to HTTPS:

```bash
sudo nano /etc/apache2/sites-available/reccwebsite.conf
```

Update the configuration:

```apache
<VirtualHost *:80>
    ServerName dargroupltd.com
    ServerAlias www.dargroupltd.com

    # Redirect all HTTP traffic to HTTPS
    Redirect permanent / https://dargroupltd.com/
</VirtualHost>
```

Restart Apache:

```bash
sudo systemctl restart apache2
```

### Step 5: Verify SSL Configuration

```bash
# Test SSL configuration
sudo apache2ctl configtest

# Check SSL certificate
sudo certbot certificates

# Test SSL certificate expiration
echo | openssl s_client -servername dargroupltd.com -connect dargroupltd.com:443 2>/dev/null | openssl x509 -noout -dates
```

### Step 6: Automatic Certificate Renewal

Certbot sets up automatic renewal, but you can test it:

```bash
# Test renewal process
sudo certbot renew --dry-run

# Check renewal status
sudo systemctl status certbot.timer
```

Certificates are automatically renewed before expiration (30 days before expiry).

---

## Additional Configuration

### Laravel Environment Setup

1. **Copy environment file:**
   ```bash
   cd /var/www/reccwebsite
   cp .env.example .env
   ```

2. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

3. **Update .env file with your configuration:**
   ```env
   APP_NAME="Your App Name"
   APP_ENV=production
   APP_KEY=base64:... (generated by key:generate)
   APP_DEBUG=false
   APP_URL=https://dargroupltd.com
   FRONTEND_URL=https://dargroupltd.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=platform
   DB_USERNAME=platform_user
   DB_PASSWORD=your_password

   SANCTUM_STATEFUL_DOMAINS=dargroupltd.com,www.dargroupltd.com
   ```

4. **Install dependencies:**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install
   npm run build
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate --force
   ```

6. **Create storage link:**
   ```bash
   php artisan storage:link
   ```

7. **Optimize application:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### PHP-FPM Configuration

If using PHP-FPM, configure it:

```bash
# Edit PHP-FPM pool configuration
sudo nano /etc/php/8.1/fpm/pool.d/www.conf
# Or for PHP 8.2: sudo nano /etc/php/8.2/fpm/pool.d/www.conf

# Update user and group
user = www-data
group = www-data

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
# Or: sudo systemctl restart php8.2-fpm
```

### Firewall Configuration

```bash
# Allow HTTP and HTTPS traffic
sudo ufw allow 'Apache Full'
# Or specifically:
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable
```

---

## Troubleshooting

### Common Issues

1. **Permission Denied Errors:**
   ```bash
   sudo chown -R www-data:www-data /var/www/reccwebsite
   sudo chmod -R 755 /var/www/reccwebsite
   sudo chmod -R 775 /var/www/reccwebsite/storage
   ```

2. **PHP Extensions Not Loaded:**
   ```bash
   # Check loaded extensions
   php -m
   
   # Enable extension in php.ini
   sudo nano /etc/php/8.1/fpm/php.ini
   # Uncomment: extension=gd
   # Restart PHP-FPM
   ```

3. **Apache Not Starting:**
   ```bash
   # Check Apache error logs
   sudo tail -f /var/log/apache2/error.log
   
   # Test configuration
   sudo apache2ctl configtest
   ```

4. **SSL Certificate Issues:**
   ```bash
   # Check certificate status
   sudo certbot certificates
   
   # Renew certificate manually
   sudo certbot renew
   ```

5. **Database Connection Errors:**
   ```bash
   # Test MySQL connection
   mysql -u platform_user -p platform
   
   # Check MySQL status
   sudo systemctl status mysql
   ```

---

## Security Checklist

- [ ] Use strong database passwords
- [ ] Set `APP_DEBUG=false` in production
- [ ] Configure proper file permissions
- [ ] Enable SSL/HTTPS
- [ ] Set up firewall rules
- [ ] Keep software updated
- [ ] Configure automatic backups
- [ ] Set up log monitoring
- [ ] Enable security headers (already configured in SSL setup)

---

## Support

For issues or questions, please refer to:
- Laravel Documentation: https://laravel.com/docs
- Apache Documentation: https://httpd.apache.org/docs/
- Let's Encrypt Documentation: https://letsencrypt.org/docs/

---

**Last Updated:** November 2024

