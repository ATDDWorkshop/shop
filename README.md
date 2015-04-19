Shop
=======================

Introduction
------------
This is a simple shop application. Registered users can login and buy items from a list.

URL
------------

    http://shop


Installation
------------

    git clone https://github.com/ATDDWorkshop/shop.git

Assuming you already have Composer:

    composer.phar install

Add a alias to your /etc/hosts

    127.0.0.1   shop

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName shop
        DocumentRoot /path/to/shop/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/shop/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
