
Laravel
==============

## 数字

Yii

v1 4404 + 1901 = 6305

v2 5929 + 3362 = 9291

Yii两个版本共计: 15596

Laravel 有多少呢？

？

[更多参考](https://github.com/search?l=PHP&o=desc&q=php+framework&s=stars&type=Repositories&utf8=%E2%9C%93)

## 环境安装

### composer

https://getcomposer.org/download/
下载 composer.phar
创建 composer.bat，内容是"%~dp0composer.phar"
以上两个文件放到 php.exe 所在目录
确保在命令行可以执行 "php -v"

### 安装 Git

### 翻墙
http://www.shayugo.net/

### 下载 Laravel
https://github.com/laravel/laravel/archive/master.zip

### 设置 Redis 安装配置
在 composer.json 文件的 require 下增加

    "predis/predis": "1.0.*"

同时注释PHP的redis扩展

    ;extension=php_redis.dll
    
### composer install
大约6分钟左右


## 访问

### 本机配置 vhost todos.cn

### 创建密钥
php artisan key:generate

### 访问 http://todos.cn


## 实战练习

### 创建模板文件
resources/views/todos.blade.php

    <html>
    <head>
    <title>Todos</title>
    <link rel="stylesheet" href="css/todos.css" />
    </head>
    <body>
    <div class="container">
        <h1>Todos</h1>
        <input id="new-todo" type="text" placeholder="What needs to be done?">
        <ol id="list">
            
        </ol>
    </div>
    <script src="/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
    var CSRF_TOKEN = '{{ csrf_token() }}'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        }
    })
    </script>
    <script src="/js/todos.js"></script>
    </body>
    </html>


### CSS
public/css/todos.css

    body{background-color:#eeeeee; padding:0; margin:0;}
    .container {
        margin: 0 auto;
        padding: 10px;
        width: 520px;
        height: 100%;
        text-align: center;
        background-color:#fff;
        box-shadow: rgba(0, 0, 0, 0.2) 0 2px 6px 0;
    }
    h1 {padding-top: 20px; }
    input {width:90%; height:50px; padding:6px; font-size:24px; }
    ol {font-size:24px; margin-left:20px; width: 433px;}
    li {text-align: left; height:40px; line-height:40px;}

### 创建控制器文件
php artisan make:controller --plain TodoController

### 路由
Route::controller('todos', 'TodosController');
参考:
http://www.golaravel.com/laravel/docs/5.0/controllers/#implicit-controllers

### 创建表
php artisan make:migration create_todos_table

### 创建模型文件
php artisan make:model Models/Todo

### 完成保存操作

    public function postSave(Request $request)
    {
        $title = $request->input('title');
        
        $todo = new Todo;
        $todo->title = $title;
        $todo->save();
        
        return json_encode($todo);
    }
    
### 完成AJAX发送数据
public/js/jquery-*.js（自己下载）
public/js/todos.js 文件：

    !function($){
        
        $('#new-todo').keyup(function(e){
            var o = $(this)
            if (e.keyCode === 13) {
                var value = $.trim(o.val())
                value && save(value)
                o.val('')
            }
        })
        
        function save(value) {
            var list = $('#list')
            list.append('<li>'+ value +'</li>')
            $.post('todos/save', {title: value}, function(data, status) {
                alert(data)
            })
        }
        
    }(jQuery)

### 实现首页数据列表
参考 http://www.golaravel.com/laravel/docs/5.0/templates/

### 实现搞定和删除操作

* 控制器，完善修改和删除两个方法
* 模板，增加搞定和删除按钮
* js，增加搞定和删除相关ajax代码

### 模板
将模板拆分，有一个主文件 main.blade.php，todos.blade.php模板继承自 main

### 表单验证
    
    $this->validate($request, [
        'title' => 'required|unique:todos|max:20'
    ], ['title.max'=>'标题长度不能超过:max']);

### 服务
php artisan make:provider CmsServiceProvider

### 队列
    
创建一个队列处理类

    php artisan make:command SendCms --queued

启动队列处理程序：
    php artisan queue:listen

队列项：
    {"job":"Illuminate\\Queue\\CallQueuedHandler@call","data":{"command":"O:20:\"App\\Commands\\SendCms\":2:{s:6:\"\u0000*\u0000msg\";s:5:\"hello\";s:6:\"\u0000*\u0000job\";N;}"},"id":"tHsLXpI8jhq64BuKJTk3cCWqUTZidaGJ","attempts":1}
    

### 事件

在 EventServiceProvider 文件添加
    
    'App\Events\AfterTodoDeleted' => [
        'App\Listeners\AfterTodoDeletedListener',
    ],

然后执行
    
    php artisan event:generate
    
    
在控制的删除方法触发事件，记得先 use 一下

    event(new AfterTodoDeleted($id));
    
    
    
    
