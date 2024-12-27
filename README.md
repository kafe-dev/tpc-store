## TPC Store

The online store for laptops, pc and pc parts.

## Installation

### Docker

#### Setup environment

- Make .env file:

```shell
$ cp -r .env.example .env
```

- Update environment variables in `.env` file:

```shell
APP_NAME="TPC Store"
APP_URL="http://tpc-store.local"

DATABASE_SERVER=mysql
DATABASE_ROOT_PASSWORD=mysql
DATABASE_NAME=tpc_store_db
DATABASE_USER=tpc_admin
DATABASE_PASSWORD=tpc_password
```

#### Docker local setup

- Copy necessary files:

```shell
$ cp -r docker/dev/Dockerfile.dev ./Dockerfile
$ cp -r docker/dev/docker-compose.dev.yml ./docker-compose.yml
$ cp -r docker/dev/apache.conf.dev ./apache.conf
```

- Modify the `apache.conf` to match your local setup:

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

#### Docker server setup

- Copy necessary files:

```shell
$ cp -r docker/prod/Dockerfile.prod ./Dockerfile
$ cp -r docker/docker-compose.prod.yml ./docker-compose.yml
$ cp -r docker/apache.conf.example ./apache.conf
$ cp -r docker/ssl.key.example ./ssl.key
$ cp -r docker/ssl.pem.example ./ssl.pem
```
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

- Modify 2 files: `ssl.key` and `ssl.pem` to match your SSL certificate.

- Install Composer dependencies:

```shell
$ composer install
```

- Change permission for `var` directory:

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