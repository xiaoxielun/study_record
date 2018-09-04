<?php
use PHPUnit\Framework\TestCase;

class Example
{
    protected $id;
    protected $directory;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory . DIRECTORY_SEPARATOR . $this->id;

        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0700, true);
        }
    }
}

class ExampleTest extends TestCase
{
    public function setUp()
    {
        org\bovigo\vfs\vfsStreamWrapper::register();
        org\bovigo\vfs\vfsStreamWrapper::setRoot(new org\bovigo\vfs\vfsStreamDirectory('exampleDir'));
    }

    public function testDirectoryIsCreated()
    {
        $example = new Example('id');
        $this->assertFalse(org\bovigo\vfs\vfsStreamWrapper::getRoot()->hasChild('id'));

        $example->setDirectory(org\bovigo\vfs\vfsStream::url('exampleDir'));
        $this->assertTrue(org\bovigo\vfs\vfsStreamWrapper::getRoot()->hasChild('id'));
    }
}
