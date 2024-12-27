## TPC Store

The online store for laptops, pc and pc parts.

## Installation

### Docker

#### Local setup

- Copy necessary files:

```shell
$ cd ${ROOT_DIR}
$ cp -r docker/docker-compose.local.yml ./docker-compose.yml
$ cp -r docker/apache.conf.example /docker/apache.conf
```

- Remove ```#SSL``` section in the ```docker/apache.conf``` file then modify the file to match your local environment.

```apacheconf
# Local setup example
<VirtualHost *:80>
    DocumentRoot "/var/www/html/tpc-store/public"

    ServerAdmin admin@tpc-store
    ServerName tpc-store.local
    ServerAlias www.tpc-store.local

    <Directory /var/www/html/tpc-store/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
     </Directory>

    ErrorLog "${APACHE_LOG_DIR}/tpc-store.local.error.log"
    CustomLog "${APACHE_LOG_DIR}/tpc-store.local.access.log" combined
</VirtualHost>
```

- Build Docker images:

```shell
$ docker-compose up -d
```

- Access the docker container web then run the following commands:

```shell
$ cd tpc-store
$ composer install
$ chmod -R 777 var/
$ php bin/console doctrine:migrations:migrate
```

#### Prod setup

- Copy necessary files:

```shell
$ cd ${ROOT_DIR}
$ cp -r docker/docker-compose.prod.yml ./docker-compose.yml
$ cp -r docker/apache.conf.example /docker/apache.conf
$ cp -r docker/ssl.key.example /docker/ssl.key
$ cp -r docker/ssl.pem.example /docker/ssl.pem
```

- Remove ```#LOCAL``` section in the ```docker/apache.conf``` file then modify the file to match your local environment.

```apacheconf
# Local setup example
<VirtualHost *:443>
    DocumentRoot "/var/www/html/tpc-store/public"

    ServerAdmin admin@tpc-store
    ServerName tpc-store.seniorlab.dev
    ServerAlias tpc-store.seniorlab.dev

    SSLEngine on

    SSLCertificateFile      /etc/apache2/ssl/ssl.pem
    SSLCertificateKeyFile   /etc/apache2/ssl/ssl.key

    <FilesMatch "\.(?:cgi|shtml|phtml|php)$">
        SSLOptions +StdEnvVars
    </FilesMatch>

    <Directory /var/www/html/tpc-store/public/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/tpc-store.seniorlab.dev.error.log
    CustomLog ${APACHE_LOG_DIR}/tpc-store.seniorlab.dev.access.log combined
</VirtualHost>
```

- Modify 2 files: ```docker/ssl.key``` and ```docker/ssl.pem``` to match your SSL certificate.

- Install Composer dependencies:

```shell
$ composer install
```

- Change permission for ```var``` directory:

```shell
$ chmod -R 777 var/
```

- Build Docker images:

```shell
$ docker-compose up -d
```

- Access the docker container web then run the following commands:

```shell
$ cd tpc-store
$ php bin/console doctrine:migrations:migrate
```