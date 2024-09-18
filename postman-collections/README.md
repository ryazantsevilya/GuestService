# API Endpoints

Файл [crud_guest_collection.json](https://github.com/ryazantsevilya/GuestService/blob/main/postman-collections/crud_guest_collection.json) содержит коллекцию запросов для Postman. Variable {{hostname}} по умолчанию "guestservice.localhost".

## GET /api/guest/{id}
Получение даннх о госте по id.
{id} - int, required

Response:
```js
{
    {
        "firstName": "Иван",
        "lastName": "Иванов",
        "phonenumber": "79000000001",
        "country": {
            "id": 177,
            "name": "Russian Federation",
            "phonePrefix": "7"
        },
        "email": null,
        "id": 2
    }
}
```

## POST /api/guest
Создание гостя

Request:

```js
{
    {
        "firstName": "Иван", // required, string
        "lastName": "Иванов", // required, string
        "phonenumber": "79000000001", // required, string, unique
        "country_id": null, // ?int, Если не указно или null, то выберется страна по префиксу номера телефона
        "email": null // ?string, unique
    }
}
```

## PUT /api/guest/{id}
Изменение данных гостя.
{id} - int, required

Request:
```js
{
    {
        "id": "2", // int, если не указан берется из {id}
        "firstName": "Иван", // required, string
        "lastName": "Иванов", // required, string
        "phonenumber": "79000000001", // required, string, unique
        "country_id": null, // ?int, Если не указно или null, то выберется страна по префиксу номера телефона
        "email": null // ?string, unique
    }
}
```

## DELETE /api/guest/{id}
Удаление гостя.
{id} - int, required

Response:
```js
[
    "Гость 2 удален."
]
```