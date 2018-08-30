phpunit学习笔记
===
目录
---

[安装phpunit](#安装phpunit)  
[参考](#参考)  
[编写 PHPUnit 测试](#编写_PHPUnit_测试)  

安装phpunit
---
* PHP 档案包 (PHAR)
    
    >详细见 : [安装 PHPUnit](https://phpunit.readthedocs.io/zh_CN/latest/installation.html)
* Composer

    >如果用 Composer 来管理项目的依赖关系，只要在项目的 composer.json 文件中简单地加上对 phpunit/phpunit 的依赖关系即可：
    `composer require --dev phpunit/phpunit ^6.5`

编写 PHPUnit 测试
---
* 用PHPUnit编写测试的基本惯例与步骤 [@](examples/NumTest.php)

    1. 测试类都写在 `ClassTest` 中，比如 `UserTest`
    2. 测试类都继承自 `PHPUnit\Framework\TestCase`
    3. 具体测试都写在 `test*` 的方法中
    4. 在测试方法中使用断言方法来判断实际结果与预期值是否匹配
    
* 测试的依赖关系 [@](examples/DependsTest.php)

    * 每个测试方法并不一定必须是一个独立的测试单元，也可以作为其它测试的依赖
    * **生产者在代码中必须位于依赖于它的消费者上方**  
    * 允许多重依赖

    * 生产者(producer)，是能生成被测单元并将其作为返回值的测试方法
    * 消费者(consumer)，是依赖于一个或多个生产者及其返回值的测试方法
    
    >默认情况下，生产者所产生的返回值将“原样”传递给相应的消费者。这意味着，如果生产者返回的是一个对象，那么传递给消费者的将是一个指向此对象的引用。如果需要传递对象的副本而非引用，则应当用 `@depends clone` 替代 `@depends`

* 数据供给器 [@](examples/ProviderTest.php)

    * 测试方法可以接受任意参数。用 `@dataProvider` 标注来指定使用哪个数据供给器方法
    * 数据供给器方法必须声明为 public，其返回值要么是一个数组，其每个元素也是数组；要么是一个实现了 `Iterator` 接口的对象，在对它进行迭代时每步产生一个数组。每个数组都是测试数据集的一部分，将以它的内容作为参数来调用测试方法
    * 数据供给器返回的数组可以使用字符串作为键名，在某一组数据测试出错时有友好提示
    * 如果测试同时从 `@dataProvider` 方法和一个或多个 `@depends` 测试接收数据，数据供给器的参数先于依赖传入，依赖对应位置的参数每次都是一样的。
    * 使用了数据供给器的测试，该测试的返回数据不能传入依赖于该数据的测试

* 对异常进行测试 [@](examples/ExceptionTest.php)

    * 在测试中调用 `expectException()` 、`expectExceptionCode()`、`expectExceptionMessage()` 或 `expectExceptionMessageRegExp()`方法为被测代码所抛出的异常建立预期，如果之后抛出指定异常，则测试成功
    * 使用标注可以完成同样的测试 : `@expectedException` 、 `@expectedExceptionCode` 、 `@expectedExceptionMessage` 和 `@expectedExceptionMessageRegExp`

* 对错误进行测试 [@](examples/ExceptionTest.php)
    * 默认情况下，PHPUnit 将测试在执行中触发的 PHP 错误、警告、通知都转换为异常。利用这些异常，预期测试将触发 PHP 错误
    * PHP 的 error_reporting 运行时配置会对 PHPUnit 将哪些错误转换为异常有所限制

* 对输出进行测试 [@](examples/ExceptionTest.php)
    * PHPUnit使用 PHP 的 **`输出缓冲`** 特性来为此提供必要的功能支持
    
    ![方法](1.png)
    
* 错误相关信息的输出
    >当有测试失败时，PHPUnit 全力提供尽可能多的有助于找出问题所在的上下文信息

* 边缘情况
    >当比较失败时（测试已经failure），PHPUnit 为输入值建立文本表示，然后以此进行对比，输出错误对比信息，所以可能输出的信息中，错误的地方比实际不匹配的地方多

参考
---
[PHPUnit Manual](https://phpunit.readthedocs.io/zh_CN/latest/)