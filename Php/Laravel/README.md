Laravel学习笔记
===
目录
---

[服务容器](#服务容器)
[Facades](#facades)  
[Artisan](#Artisan)  
[参考](#参考)

服务容器 [@](https://laravel-china.org/docs/laravel/5.6/container/1359)
---

#### 简介
Laravel 服务容器是用于管理类的依赖和执行依赖注入的工具。在构造函数中指明参数类型，服务容器会自动注入所需依赖。
容器使用反射自动解析对象进行注入。

#### 绑定
一般在服务提供器的 ` register ` 方法中进行绑定
* 简单绑定

        $this->app->bind('HelpSpot\API', function ($app) {
            return new HelpSpot\API($app->make('HttpClient'));
        });

* 绑定一个单例

        $this->app->singleton('HelpSpot\API', function ($app) {
            return new HelpSpot\API($app->make('HttpClient'));
        });
    之后只会解析同一个对象实例。

* 绑定实例

        $api = new HelpSpot\API(new HttpClient);

        $this->app->instance('HelpSpot\API', $api);

* 绑定接口到实现

        $this->app->bind(
            'App\Contracts\EventPusher',
            'App\Services\RedisEventPusher'
        );
    某个类需要 `App\Contracts\EventPusher` 接口时，就会自动注入 `App\Services\RedisEventPusher` 实现。

Facades
---
#### 简介

Facades（读音：/fəˈsäd/ ）为应用程序的 服务容器 中可用的类提供了一个「静态」接口。所有的 Laravel Facades 都在 `Illuminate\Support\Facades` 命名空间中定义。

    use Illuminate\Support\Facades\Cache;
    
    Route::get('/cache', function () {
        return Cache::get('key');
    });

#### 何时使用 Facades

Facades 简单、易用。使得我们不经意间在单个类中使用许多 Facades，从而导致类变的越来越大。因此在使用 Facades的时候，要特别注意控制类的大小，让类的作用范围保持短小。

>:four_leaf_clover:官方文档提示: 在开发与 Laravel 进行交互的第三方扩展包时， 建立最好选择注入 Laravel 契约 ，而不是使用 Facades的方法来使用类。因为扩展包是在 Laravel 本身之外构建，所以你无法使用 Laravel Facades 测试辅助函数。

Laravel 还包含各种 『辅助函数』来实现一些常用功能，许多辅助函数都有与之对应的 Facade。在底层，辅助函数实际上就是调用了对应 Facade提供的方法。

#### Facades 工作原理

不管是 Laravel 自带的 Facades ， 还是自定义的 Facades ，都继承自 `Illuminate\Support\Facades\Facade` 类。`Facade` 基类使用了 `__callStatic()` 魔术方法，解析容器中相应的对象，然后进行调用。

#### 实时 Facades

有时通过注入来使用某一功能类：
    
    <?php
    
    namespace App;
    
    use App\AClass;
    
    class Podcast extends Model
    {
        public function test(AClass $a)
        {
            $a -> b($this);
        }
    }

可以把任何类视为 Facades：

    <?php
        
    namespace App;
    
    use Facades\App\AClass;
    
    class Podcast extends Model
    {
        public function test()
        {
            AClass::b($this);
        }
    }

要生成实时 Facades，请在导入类的名称空间中加上 Facades。

在测试时，我们可以使用 Laravel 的内置 facade 测试辅助函数来模拟这种方法调用:

    <?php
    
    namespace Tests\Feature;
    
    use App\Podcast;
    use Tests\TestCase;
    use Facades\App\AClass;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    
    class PodcastTest extends TestCase
    {
        use RefreshDatabase;
    
        public function test_podcast_can_be_published()
        {
            $podcast = factory(Podcast::class)->create();
    
            AClass::shouldReceive('b')->once()->with($podcast);
    
            $podcast->test();
        }
    }

Artisan [@](https://laravel-china.org/docs/laravel/5.6/artisan/1385)
---
#### 简介
Artisan 是 Laravel 自带的命令行接口，它提供了许多实用的命令来帮助你构建 Laravel 应用。查看所有可用的 Artisan 命令的列表:
        
    php artisan list

#### 编写命令
除 Artisan 提供的命令外，还可以构建自己的自定义命令。 命令通常存储在 app/Console/Commands 目录中。

* 生成命令

    使用 Artisan 命令 `make:command` 创建新命令。这个命令会在 `app/Console/Commands` 目录中创建一个新的命令类。生成的命令会包括所有命令中默认存在的属性和方法：

        php artisan make:command SendEmails

* 命令结构 [@](演示文件/SendEmails.php)
    
    自动生成的命令类会有 ` signature ` 和 ` description ` 属性，填写后，在使用 ` php artisan list ` 命令时会显示出用法。方法 ` handle ` 用来定义命令逻辑。

* 定义输入期望 [@](https://laravel-china.org/docs/laravel/5.6/artisan/1385#defining-input-expectations)

    通过配置 ` signature ` 属性的格式，可以定义命令在使用时的参数，可用选项等。

* I/O命令

    * 在 ` handle ` 方法中可以使用 ` argument ` 和 ` option ` 方法来获取命令的参数和选项。还有 ` arguments ` 和 ` options ` 。

    * 可以使用 ` ask ` 方法来接收用户输入。

    * 如果需要用户输入敏感的内容，可以使用 ` secret ` 方法。

    * 使用 ` confirm ` 方法让用户确认。

#### 另一种定义自定义命令的方法

在 ` app/Console/Kernel.php ` 文件的 ` commands ` 方法中， Laravel 加载了 ` routes/console.php ` 文件。在这个文件中，可以使用 ` Artisan::command ` 方法定义基于闭包的路由(闭包命令)。` command ` 方法接收两个参数：命令签名 和一个接收命令参数和选项的闭包：

    Artisan::command('build {project}', function ($project) {
        $this->info("Building {$project}!");
    });
* 类型提示依赖
    
    闭包命令也可以使用类型提示从服务容器中解析你想要的其他依赖关系:

        use App\User;
        use App\DripEmailer;

        Artisan::command('email:send {user}', function (DripEmailer $drip, $user) {
            $drip->send(User::find($user));
        });
* 闭包命令描述

    可以像类命令一样，在使用 ` php artisan list ` 命令时显示使用方法:
        Artisan::command('build {project}', function ($project) {
            $this->info("Building {$project}!");
        })->describe('Build the project');

#### 注册命令
在 ` app/Console/Kernel.php ` 文件的 ` commands ` 方法中使用 ` load ` 方法加载的文件，都会进行命令注册。也可以在 ` app/Console/Kernel.php ` 文件的 ` $commands ` 属性中手动注册命令的类名。

#### 使用命令

* CLI中执行命令

* 使用 Artisan 的 ` facades `(门面)来在程序中使用命令:
    
        Route::get('/foo', function () {
            
            $exitCode = Artisan::call('email:send', [
                'user' => 1, '--queue' => 'default'
            ]);
        }); 

* 在 命令类的 ` handle ` 方法或闭包命令的闭包中使用 ` $this->call() ` 来调用其它命令。

* 调用 ` callSilent() ` 在调用命令时屏蔽输出。

#### 常用命令

* 创建新命令

        php artisan make:command

* 创建控制器或其他文件

        php artisan make:controller

* 缓存配置文件
    
        php artisan config:cache

* 缓存路由
    
        php artisan route:cache
* 在 ` public ` 目录下创建到 ` storage ` 目录的软连接
        
        php artisan storage:link

参考
---
[Laravel 5.6 中文文档](https://laravel-china.org/docs/laravel/5.6)