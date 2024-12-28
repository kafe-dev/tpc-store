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
```

- Specific Docker ports:

```shell
WEB_PORT=8080
WEB_PORT_SSL=443
WEB_HOST="tpc-store.local:127.0.0.1"
WEB_HOSTNAME="tpc-store.local"
```

#### Docker dev setup

- Copy necessary files:

```shell
$ cp -r docker/dev/Dockerfile.dev ./Dockerfile
$ cp -r docker/dev/apache.conf.dev ./apache.conf
$ cp -r docker/dev/docker-compose.override.dev ./docker-compose.override.yml
```

- Run the following commands:

```shell
$ php bin/console doctrine:migrations:migrate
```

- Build Docker images:

```shell
$ docker-compose build
```

- Run Docker containers:

```shell
$ docker-compose up -d
```

- Access the docker container web then run the following commands:

```shell
$ composer install
$ chmod -R 777 var/
```

- Access the web application on: `http://tpc-store.local:8080`

#### Docker prod setup

- Copy necessary files:

```shell
$ cp -r docker/prod/Dockerfile.prod ./Dockerfile
$ cp -r docker/prod/apache.conf.prod ./apache.conf
$ cp -r docker/prod/docker-compose.override.prod ./docker-compose.override.yml
```

- Change .env file:

```
APP_ENV=prod
```

- Run the following commands:

```shell
$ composer install --no-dev --optimize-autoloader
$ chmod -R 777 var/
$ php bin/console asset-map:compile
```

- Build Docker images:

```shell
$ docker-compose build
```

- Run Docker containers:

```shell
$ docker-compose up -d
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