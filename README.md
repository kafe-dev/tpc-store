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

DATABASE_SERVER=mariadb
DATABASE_VERSION=11.4
DATABASE_ROOT_PASSWORD=tpc_root_password
DATABASE_NAME=tpc_store_db
DATABASE_USER=tpc_admin
DATABASE_PASSWORD=tpc_password
```

- Specific Docker ports:

```shell
DB_PORT=3306
PMA_PORT=8081
WEB_HOST="tpc-store.local:127.0.0.1"
WEB_HOSTNAME="tpc-store.local"
WEB_PORT=80
```

#### Docker local setup

- Copy necessary files:

```shell
$ cp -r /docker/dev/Dockerfile.dev ./Dockerfile
$ cp -r /docker/dev/docker-compose.yml.dev ./docker-compose.yml
$ cp -r /docker/apache.conf.dev ./apache.conf
```

- Build Docker images:

```shell
$ docker-compose up -d
```

#### Dev setup

- Access the docker container web then run the following commands:

```shell
$ composer install
$ chmod -R 777 var/
$ php bin/console doctrine:migrations:migrate
```

#### Server setup

- Just access the project root then run the following commands:

```shell
$ composer install --no-dev
$ chmod -R 777 var/
$ php bin/console doctrine:migrations:migrate
```

#### Limit Docker logs

```shell
cd /etc/logrotate.d/
nano docker-logss
```

Then paste the following content:

```
/var/lib/docker/containers/*/*.log {
  rotate 7
  daily
  compress
  size=50M
  missingok
  delaycompress
  copytruncate
}
```

#### Clear unused Docker resources

```shell
$  docker system prune -f
```