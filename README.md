# GuestService
Микросервис для работы с гостями
## [API Documentation](https://github.com/ryazantsevilya/GuestService/tree/main/postman-collections)
## Build DEV
[Устанавливаем Docker Compose](https://docs.docker.com/compose/install/)
Устанваливаем make 
```sh
apt-get install make
```
Копируем конфиг
```sh
cp .env.example .env
```
Меняем криды для БД в .env

Собираем контейнер, запускаем, инициализируем БД
```sh
make build
make up
make database-init
```

Проверяем доступность https://guestservice.localhost/ (если не меняли SERVER_NAME)

ВАЖНО! Если поенять SERVER_NAME на отличный от *.localhost нужно будет или генерировать и подкидывать сертификаты или отключать HTTPS.