# Project Designer

## Installation

Apache .conf file:

```apache
<VirtualHost *:80>
    ServerName pdesigner.com

    ServerAdmin darkjedi9922@gmail.com
    DocumentRoot /path/to/pdesigner

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <Directory "/path/to/pdesigner">
        RewriteEngine on
        
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
        
        Require all granted
    </Directory>
</VirtualHost>
```