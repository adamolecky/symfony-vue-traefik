# Symfony app with Vue.js and traefik

## Init
1. download repo
2. copy .env.template to .env in root folder
3. add mysql config:<br>
3.1 folder structure: /services/mysql/ to root folder<br>
3.2 add file utf8mb4.cnf to created folder<br>
3.3 fill it with basic configuration: 
   ````
    [client]
    default-character-set = utf8mb4
    
    [mysql]
    default-character-set = utf8mb4
    
    [mysqld]
    character-set-client-handshake = FALSE
    character-set-server = utf8mb4
    collation-server = utf8mb4_unicode_ci
   ````
3. exec `docker-compose up -d` in root folder
4. connect and install dependecies:<br>
4.1 `docker-compose exec app bash`<br>
4.2 `composer install`<br>
4.3 `yarn add`
5. run migrations inside app container `bin/console doctrine:migrations:migrate`
6. now you can see app running on port 80. 

## URLs
There are some URLs, which you can visit from browser: 
### Humanly readable
- http://app.localhost/ shows you basic landing page of symfony app. 
- http://app.localhost/home leads to main page of Vue.js app, contains form for storing new user
- http://app.localhost/list leads to list page of Vue.js app, contains lists of user already added to DB via form

### API

- http://app.localhost/api/user/create is POST endpoint which excpects data in JSON format:
````
  {
      "fullName": "My Name",
      "password": "My Password",
      "email": "my@email.com",
      "roleString": "admin"
  }
````
If are data OK, returns 200 + saved user with id in response. If data doesn't pass validation, returns error messages: 
for example: 
````
{"errors":[["This value is not a valid email address.",{"{{ value }}":"\u0022adam.oleckyemail.com\u0022"}]]}
````
or
````
{"errors":[["This value should not be blank.",{"{{ value }}":"\u0022\u0022"}]]}
````
or returns all errors what have been detected: 
````
{"errors":[["This value should not be blank.",{"{{ value }}":"\u0022\u0022"}],["This value is not a valid email address.",{"{{ value }}":"\u0022adam.oleckyemail.com\u0022"}]]}
````

- http://app.localhost/api/user/list is GET endpoint which returns JSON with all users including passwords and roles
for example: 
  ````
  [
    {"id":1,"fullName":"My name","password":"$2y$12$ls5b7\/5tfUiv9pvcXrCS6.NAje0UCn2Fs29.Y9stX49DCYOKXwntu","email":"my@email.com","role":"admin"},
    {"id":2,"fullName":"My name","password":"$2y$12$I8hq37x9fSVLYKRLocGKGuKXnIMcqzh3U8Dx5rNFNl284P.7xB3By","email":"my@email.com","role":"admin"},
    {"id":3,"fullName":"My name","password":"$2y$12$2b7lja5IHOIWfkUGO1TJd.xvkSbNzrDwlpt8ikTxH4s9hlU93HCai","email":"my@email.com","role":"admin"},
    {"id":4,"fullName":"My name","password":"$2y$12$poU128IAgfCwxe0O8d6sTenpTV6VGOyVgqU\/NQewrV5RBfWFJ97ra","email":"my@email.com","role":"admin"}
  ]
  ````
## Development

1. Before push to repo run `composer csfix && composer cscheck && composer phpstan`
2. Run lint before commiting Javascript `yarn csfix`
3. if you can, just add it to git commit hooks

## Possible improvements: 
  - Unit tests
  - tests for vue.js
  - adding uuid to DB insted of incementing ids (in case of heavy usage there is high probability of rising costs on the DB which is connected to locking index for counting...etc.)
  - refactoridng to cleaner code...

