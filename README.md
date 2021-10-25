# Api cars tapir - выполнение задачи


Использованные версии:
- Laravel v8.6.3
- composer:2.1
- php:8.0-fpm
- Ubuntu 20.04.3 LTS (запущено на релизе 20.04)
- в качестве базы данных используется MongoDb и драйвер [jenssegers/mongodb](https://github.com/jenssegers/laravel-mongodb) ^3.8.4, но так же преднастроена mysql, но закомментирована


## Запуск проекта ➡️

## Запусть в терминале 3 команды:

## 1)

`git clone https://github.com/itaidi/tapir1.git`

`cd tapir1`

`docker-compose up`

## 2) 

(повторить команду `docker-compose up`, **в случае таймаута загрузки пакетов** 💤)

## 3) 

➡️ открыть - api [http://localhost:7777/api/store ...](http://localhost:7777/api/store?year_from=2000&year_to=2010&price_less=1500000), если сразу не открылось, нужно обновить .

📋 открыть api docs в [editor.swagger.io/?url= ...](https://editor.swagger.io/?url=https://raw.githubusercontent.com/itaidi/tapir1/main/docs/swagger.yaml)

(работает после отображения выполнения миграций в терминал, когда отобразиться `✅ cars_cron   | <pre>Migration table created successfully.`)

---
Возможные конфликты при запуске, могут помочь команды:
1) очистка открых контейнеров (случае конфликтов) `docker rm -f $(docker ps -aq)`
2) остановка apache если перекрыт порт 80 (для ubuntu/linux) `/etc/init.d/apache2 stop` 
3) проверка занятых портов, если не получилось `sudo lsof -i -P -n | grep 80`
---


5) доки:

## Swagger file yaml 

- https://raw.githubusercontent.com/itaidi/tapir1/main/docs/swagger.yaml

## Edit swgger online 🔍:
https://editor.swagger.io/?url=https://raw.githubusercontent.com/itaidi/tapir1/main/docs/swagger.yaml (просмотр запросов)

## redoc-cli
Запуск в докере -

(в каталоге проекта, запустить в терминале) `docker run -it --rm -p 7778:80 -v "$(pwd)/docs":/usr/share/nginx/html/swagger/ -e SPEC_URL=swagger/swagger.yaml redocly/redoc`

redoc будет по адресу - `http://localhost:7778`

## Подключение к MongoDb

https://www.mongodb.com/products/compass
через Compas - `mongodb://root:your_mongodb_root_password@localhost:27017/laravel?authSource=admin`

Через терминал - 

`docker exec -it cars_mongodb bash`
затем ``

---

Дополнительно:

6) Запуск проекта в фоне `docker-compose up -d --build`



---

📌 Логи обработки json записываются в - `**src/storage/logs/laravel.log`

# описание функциональность проекта

1) cron реализован двумя способами 
- конейнер без php который запускает расписание **через curl**, в основном контейнере (`cron_only.Dockerfile`)
- конейнер с php, который выполняет artisan как отдельный сервис (`cron_with_php.Dockerfile`)
`cron/cron-cars` - файл cron

т.к. без php **сборка быстрее**, используется №1 вариант

curl запускает файлы `/src/public/check_schedule.php`, и `/src/public/check_update_cars.php` (при первом запуске, команда прописана в `docker-compose.yml`, у соответствующего контейнра) PS: **там же запуск** `php artisan migrate`

2) 

обработка файлов здесь - `/app/console/commands/GetCars.php`, метод `php artisan cars:get`, вызов расписания через каждые 10 минут `php artisan schedule:run`

3)

Апи эндпоинт здесь - `/app/http/controllers/CarsController.php` и `routes/api.php`

4.1) 
пришлось создать файл composer_ready_check.php проверки загрузки comoser install, т.к. докер контейнеры запускаются асинхронно, - проверка запускается через curl в docker-compose в файле check_update_cars.php (скрипт ожидает, пока скопилируется autoload.php)
4.2)
и отдельный файл который создает laravel.log с нужными правами от сервера, чтобы curl `/src/public/start_commands_preset.php`, запускается перед composer install

- это обеспечивает работоспособность при первом запуске ✅