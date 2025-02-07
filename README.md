Тестовое задание для tapir
---

Старт проекта:

```shell
cp .env.example .env
```
Настроить конфигурацию в .env файле:

NEW_CARS_LINK \
OLD_CARS_LINK \
CRM_LINK \
MEILISEARCH_HOST\
DB_HOST\
DB_PORT\
DB_DATABASE\
DB_USERNAME\
DB_PASSWORD

Установка sail

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

Поднятие приложения
```shell
vendor/bin/sail up -d
```

Миграции
```shell
vendor/bin/sail php artisan migrate
```

Пользователь orchid
```shell
vendor/bin/sail php artisan orchid:admin
```

Импорт данных автомобилей
```shell
vendor/bin/sail php artisan app:car-import-command
```
