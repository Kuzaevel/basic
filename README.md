RestFull Api

Книжная полка

Схема БД:
ShemeBD.jpg


git clone https://github.com/Kuzaevel/basic.git

Устанавливаем зависимости с помощью composer
- composer install

Восстановить базу данных из файла в корне проекта
- basic_server.sql 


Примеры запросов в файле в корне проекта:
- Basic.postman_collection.json



Для авторизации используется HttpBearerAuth:
1) Авторизуемся post-запросом http://basic.host1297870.ru/auth
передаем в body json data : 
{
    "username": "admin",
    "password": "admin"
}
получаем и копируем token

2) в дальнейшем для авторизации используем token
Authorization->type->Bearer Token

