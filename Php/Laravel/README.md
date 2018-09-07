Laravel学习笔记
===
目录
---
[Facades](#Facades)

Facades
---

### 简介

Facades（读音：/fəˈsäd/ ）为应用程序的 服务容器 中可用的类提供了一个「静态」接口。所有的 Laravel Facades 都在 `Illuminate\Support\Facades` 命名空间中定义。

    use Illuminate\Support\Facades\Cache;
    
    Route::get('/cache', function () {
        return Cache::get('key');
    });

### 何时使用 Facades

Facades 简单、易用。使得我们不经意间在单个类中使用许多 Facades，从而导致类变的越来越大。因此在使用 Facades的时候，要特别注意控制类的大小，让类的作用范围保持短小。

>:four_leaf_clover:官方文档提示: 在开发与 Laravel 进行交互的第三方扩展包时， 建立最好选择注入 Laravel 契约 ，而不是使用 Facades的方法来使用类。因为扩展包是在 Laravel 本身之外构建，所以你无法使用 Laravel Facades 测试辅助函数。

Laravel 还包含各种 『辅助函数』来实现一些常用功能，许多辅助函数都有与之对应的 Facade。在底层，辅助函数实际上就是调用了对应 Facade提供的方法。

### Facades 工作原理

不管是 Laravel 自带的 Facades ， 还是自定义的 Facades ，都继承自 `Illuminate\Support\Facades\Facade` 类。`Facade` 基类使用了 `__callStatic()` 魔术方法，解析容器中相应的对象，然后进行调用。

### 实时 Facades

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