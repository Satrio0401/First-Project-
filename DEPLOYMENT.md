# Deployment Guide 🚀

Panduan deployment untuk Organization Profile System ke production server.

## Prerequisites

- PHP 8.2 atau lebih tinggi
- Composer 2.x
- Node.js & NPM
- MySQL 8.0+ atau PostgreSQL
- Web server (Apache/Nginx)
- SSL Certificate (recommended)

## Deployment Steps

### 1. Server Setup

#### Update System
```bash
sudo apt update && sudo apt upgrade -y
```

#### Install Dependencies
```bash
# PHP & Extensions
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-mbstring php8.2-zip php8.2-gd

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Clone & Setup Application

```bash
# Clone repository
cd /var/www
git clone your-repo-url organization-profile
cd organization-profile

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Edit .env file
nano .env
```

#### Production `.env` Configuration
```env
APP_NAME="Your Organization"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=org_profile_db
DB_USERNAME=db_user
DB_PASSWORD=strong_password_here

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=redis
QUEUE_CONNECTION=database

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Database Setup

```bash
# Create database
mysql -u root -p
```

```sql
CREATE DATABASE org_profile_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'db_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON org_profile_db.* TO 'db_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

```bash
# Run migrations
php artisan migrate --force

# Seed data (optional)
php artisan db:seed --force

# Or create admin manually
php artisan make:filament-user
```

### 5. Storage & Permissions

```bash
# Create storage link
php artisan storage:link

# Set permissions
sudo chown -R www-data:www-data /var/www/organization-profile
sudo chmod -R 755 /var/www/organization-profile
sudo chmod -R 775 /var/www/organization-profile/storage
sudo chmod -R 775 /var/www/organization-profile/bootstrap/cache
```

### 6. Build Assets

```bash
npm run build
```

### 7. Optimize Application

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimize composer autoloader
composer install --optimize-autoloader --no-dev
```

## Web Server Configuration

### Nginx Configuration

Create file: `/etc/nginx/sites-available/organization-profile`

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/organization-profile/public;

    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

    # Main location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Logging
    access_log /var/log/nginx/organization-profile-access.log;
    error_log /var/log/nginx/organization-profile-error.log;
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/organization-profile /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Apache Configuration

Create file: `/etc/apache2/sites-available/organization-profile.conf`

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/organization-profile/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/yourdomain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/yourdomain.com/privkey.pem

    <Directory /var/www/organization-profile/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/organization-profile-error.log
    CustomLog ${APACHE_LOG_DIR}/organization-profile-access.log combined
</VirtualHost>
```

```bash
# Enable modules and site
sudo a2enmod rewrite ssl
sudo a2ensite organization-profile
sudo systemctl restart apache2
```

## SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Get certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (already configured by certbot)
sudo certbot renew --dry-run
```

## Queue Worker (Optional)

If using queues, setup supervisor:

```bash
sudo apt install supervisor
```

Create file: `/etc/supervisor/conf.d/organization-profile-worker.conf`

```ini
[program:organization-profile-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/organization-profile/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/organization-profile/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start organization-profile-worker:*
```

## Scheduled Tasks

Add to crontab:
```bash
sudo crontab -e -u www-data
```

Add line:
```cron
* * * * * cd /var/www/organization-profile && php artisan schedule:run >> /dev/null 2>&1
```

## Monitoring & Maintenance

### Health Check
```bash
# Check application
curl https://yourdomain.com

# Check admin panel
curl https://yourdomain.com/admin
```

### Logs
```bash
# Application logs
tail -f /var/www/organization-profile/storage/logs/laravel.log

# Web server logs
tail -f /var/log/nginx/organization-profile-error.log
```

### Backups

#### Database Backup
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u db_user -p org_profile_db > /backups/db_backup_$DATE.sql
find /backups -type f -name "db_backup_*.sql" -mtime +7 -delete
```

#### Files Backup
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf /backups/files_backup_$DATE.tar.gz /var/www/organization-profile/storage/app/public
find /backups -type f -name "files_backup_*.tar.gz" -mtime +7 -delete
```

Setup cron for automatic backups:
```cron
0 2 * * * /path/to/backup-db.sh
0 3 * * * /path/to/backup-files.sh
```

## Updates & Maintenance Mode

### Before Update
```bash
# Enable maintenance mode
php artisan down --refresh=15 --retry=60 --secret="secret-token"

# You can still access: https://yourdomain.com/secret-token
```

### Update Process
```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan optimize
```

### After Update
```bash
# Disable maintenance mode
php artisan up
```

## Troubleshooting

### Clear All Cache
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Fix Permissions
```bash
sudo chown -R www-data:www-data /var/www/organization-profile
sudo chmod -R 755 /var/www/organization-profile
sudo chmod -R 775 /var/www/organization-profile/storage
sudo chmod -R 775 /var/www/organization-profile/bootstrap/cache
```

### Debug Mode (Temporarily)
```bash
# Edit .env
APP_DEBUG=true

# Clear cache
php artisan config:clear

# Check logs
tail -f storage/logs/laravel.log

# Remember to disable debug after fixing!
APP_DEBUG=false
php artisan config:cache
```

## Security Checklist

- [ ] APP_DEBUG=false in production
- [ ] Strong database password
- [ ] SSL certificate installed
- [ ] Firewall configured (UFW/iptables)
- [ ] Regular backups scheduled
- [ ] File permissions set correctly
- [ ] Security headers configured
- [ ] Rate limiting enabled
- [ ] Admin password changed from default
- [ ] Regular updates applied

## Performance Optimization

### Redis Cache (Recommended)
```bash
sudo apt install redis-server
sudo systemctl enable redis-server
```

Update `.env`:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

### OPcache Configuration
Edit `/etc/php/8.2/fpm/php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
```

### PHP-FPM Tuning
Edit `/etc/php/8.2/fpm/pool.d/www.conf`:
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
```

## Support

For deployment issues:
- Check application logs: `storage/logs/laravel.log`
- Check web server logs
- Review Laravel documentation
- Check Filament documentation

---

**Happy Deployment! 🎉**
