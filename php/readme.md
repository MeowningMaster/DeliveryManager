#Руководство по запросам
##Основное
Запросы пересылаються способом `GET` и обрабатываються php на сервере.
Важно! Все поля в запросе дожны быть закодированы (URL encode) [онлайн форма для кодировки](https://www.urlencoder.org/).
* php: [urlencode](https://www.php.net/manual/en/function.urlencode.php)  
* javascript: [encodeURIComponent](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent)  
* c#: [HttpUtility.UrlEncode](https://docs.microsoft.com/en-us/dotnet/api/system.web.httputility.urlencode?view=netcore-3.1)

В запросах нужно указывать аккаунт с которого выполняется запрос, для тестов можно использовать админку: 
```
login: admin
password: %pvx6+;4vz6pUc4+
```

Ответ от сервера приходит в виде json обьекта (больше инфы в разделе `Ответ от сервера`).
* php: [jsondecode](https://www.php.net/manual/en/function.json-decode.php)
* javascript: [JSON.parse](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON/parse)
* c#: [json.net](https://www.newtonsoft.com/json)


##Доступ к данным
###Пользователи
####Поля
```javascript
uid, type, login, password, name, status, phone_number, telegram_id
```
`type` — число от 1 до 4:
1. Админ
2. Координатор
3. Оператор
4. Курьер

`status` — статус работника (Работает, Заболел, Отпуск, Пол дня...)

####Правила доступа
Получить данные другого пользователя может только пользователь тип которого меньше (чем меньше тип тем больше привилегии). Операторы не могут узнать логин или пароль курьеров.
Только админы и координаторы могут добавлять, изменять и удалять аккаунты, видеть логины и пароли. Координаторы не могут менять или видеть список координаторов и админа.

####Получить данные пользователя по логину и паролю
```http request
{host}/php/account_interface.php?request_type=login&sender_login={тут логин}&sender_password={тут пароль}
```

####Получить данные другого пользователя
```http request
{host}/php/account_interface.php?request_type=get&sender_login={тут логин отправителя}&sender_password={тут пароль отправителя}&uid={тут uid запрашиваемого пользователя}
```

####Добавить пользователя
```http request
{host}/php/account_interface.php?request_type=add&sender_login={тут логин отправителя}&sender_password={тут пароль отправителя}&type={тип нового пользователя}&login={логин нового пользователя}&password={пароль нового пользователя} и так для всех полей нового пользователя кроме uid
```

####Удалить пользователя
```http request
{host}/php/account_interface.php?request_type=delete&sender_login={тут логин отправителя}&sender_password={тут пароль отправителя}&uid={uid удаляемого пользователя}
```

####Редактировать пользователя
```http request
{host}/php/account_interface.php?request_type=edit&sender_login={тут логин отправителя}&sender_password={тут пароль отправителя}&type={новый тип}&login={новый логин}&password={новый пароль} и так для всех полей пользователя кроме uid
```

###Заказы
####Поля
```javascript
uid, status, client, contacts, city, address, date, time, cost, details, operator_uid, courier_uid
```

##Ответ от сервера
Если все верно, сервер вернет json:
```json
{"status":200,"data":{тут ответ}}
```

Если ошибка, то:
```json
{"status":3**,"err_text":"тут текст ошибки"}
```
где статус — код ошибки, список которых можно найти в `php/error.php`.

Я не отключал вывод предупреждений и ошибок php, так что может вернуть не валидный json. Если это произошло — отправь мне запрос при котором оно сломалось.