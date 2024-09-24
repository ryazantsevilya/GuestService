# GuestService
Микросервис для работы с гостями на Symfony. 

Микросервис реализует API для CRUD операций над гостем. То есть принимает данные для создания, изменения, получения, удаления записей гостей хранящихся в выбранной базе данных.
Сущность "Гость" Имя, фамилия и телефон – обязательные поля. А поля телефон и email уникальны. В итоге у гостя должны быть следующие атрибуты: идентификатор, имя, фамилия, email, телефон, страна. Если страна не указана то доставать страну из номера телефона 7 - Россия и т.д. Номер телефона. Длина номера от 3 до 15 символов.

Для подключения Docker выбрана библиотека https://github.com/dunglas/symfony-docker, основываясь на документации Symfony https://symfony.com/doc/current/setup/docker.html.

В ответах сервера присутствовуют два заголовка: X-Debug-Time и X-Debug-Memory, которые указывают сколько миллисекунд выполнялся запрос и сколько Кб памяти потребовалось соответственно.

## API Documentation
[API Documentation](https://github.com/ryazantsevilya/GuestService/tree/main/postman-collections)

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
