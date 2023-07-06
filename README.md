# About Task

## 1.Push to github
Url: https://github.com/jesse7866/ayd_task

## 2.Return Json
```json
{
    "code": 0,
    "msg": "success",
    "data": {
        "is_valid": false
    }
}
```

```json
{
    "code": 422,
    "message": "参数s只允许包含()[]{}这些字符中的一个或多个！",
    "data": {}
}
```

```json
{
    "code": 500,
    "message": "Internal Server Error",
    "data": {}
}
```

```json
{
    "code": 500,
    "message": "意外错误",
    "data": {
        "message": "意外错误",
        "exception": "Exception",
        "file": "/var/www/task/app/Http/Controllers/TaskController.php",
        "line": 35,
        "trace": [
            {
                "file": "/var/www/task/vendor/laravel/framework/src/Illuminate/Routing/Controller.php",
                "line": 54,
                "function": "exception",
                "class": "App/Http/Controllers/TaskController",
                "type": "->"
            },
            {
                "file": "/var/www/task/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php",
                "line": 43,
                "function": "callAction",
                "class": "Illuminate/Routing/Controller",
                "type": "->"
            },
            {
                "file": "/var/www/task/vendor/laravel/framework/src/Illuminate/Routing/Route.php",
                "line": 260,
                "function": "dispatch",
                "class": "Illuminate/Routing/ControllerDispatcher",
                "type": "->"
            }
        ]
    }
}
```

## 3.Save errors message into the database, view error message by APP_DEBUG
table: loggers_20230706、loggers_20230707
```PHP
Schema::create('loggers', function (Blueprint $table) {
    $table->id();
    $table->longText('message');
    $table->string('channel')->index();
    $table->string('level')->index();
    $table->string('level_name');
    $table->longText('context')->nullable();
    $table->longText('extra')->nullable();
    $table->longText('formatted');
    $table->string('remote_addr')->nullable();
    $table->string('user_agent', 500)->nullable();
    $table->timestamp('created_at');
});
```

## 4.Record all the request information
table: request_logs
```PHP
Schema::create('request_logs', function (Blueprint $table) {
    $table->id();
    $table->string('request_id')->index();
    $table->string('path')->index();
    $table->string('method');
    $table->text('query')->nullable();
    $table->longText('request_body')->nullable();
    $table->longText('response_body')->nullable();
    $table->string('ip');
    $table->string('url');
    $table->text('headers');
    $table->timestamp('created_at');
});
```

## 5.Provide 3 API routes
```shell
GET 'https://domain.com/api/task/valid/parentheses?s=()[]{()}'
POST 'https://domain.com/api/task/valid/parentheses?s=()[]{()}'
GET 'https://domain.com/api/task/valid/parentheses?s=()]}'
GET 'https://domain.com/api/task/valid/parentheses?s=()]}123'
GET 'https://domain.com/api/task/exception'
```

## 6.Logical test
```shell
GET 'https://domain.com/api/task/valid/parentheses?s=()[]{()}'
```

## 7.Deploy the project and phpmyadmin
