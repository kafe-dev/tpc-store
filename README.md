## TPC Store

The online store for laptops, pc and pc parts.

## Installation

- Make .env file:

```shell
$ cp -r .env.example .env
```

- Specific Docker ports:

```shell
DOCKER_SQL_PORT=3306
DOCKER_PMA_PORT=7080
DOCKER_WEB_PORT=8080
DOCKER_WEB_HOST="tpc-store.local"
```

- Update database credentials:

```shell
DB_ROOT_PASSWORD=root
DB_NAME=tpc_store_db
DB_USER=tpc_admin
DB_PASSWORD=tpc_admin_password
```

- Update app information:

```shell
APP_NAME="TPC Store"
APP_URL="http://tpc-store.local:8080"
```

- Start Docker containers:

```shell
$ docker-compose up -d
```