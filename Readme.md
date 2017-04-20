Http Headers
====

Fetch HTTP Response Headers with listed URLs.

## Description
Fetch HTTP Response Headers with listed URLs. It shows Response headers as table or CSV. 

## Demo

```php
>  php artisan HttpHeaders:get  \
   --fetch-headers=Server,Location \
   --urls=http://www.github.com/,\
http://www.github.com/about

Headers Server,Location
+-------------------------+------------------+--------+--------------------------+
| URL                     | HTTP Status Code | Server | Location                 |
+-------------------------+------------------+--------+--------------------------+
| http://github.com/      | 301              |        | https://github.com/      |
| http://github.com/about | 301              |        | https://github.com/about |
+-------------------------+------------------+--------+--------------------------+
```

## Requirement
* PHP
* Laravel Envrironment

## Usage
```
>  php artisan HttpHeaders:get --fetch-headers= --urls
```

## Install

## Licence

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)
