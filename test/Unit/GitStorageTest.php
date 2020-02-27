<?php


namespace Test\Unit;


use ComposerVersionPlugin\GitStorage\GitStorage;
use ComposerVersionPlugin\Version;
use PHPUnit\Framework\TestCase;
use Test\Mock\Shell;

class GitStorageTest extends TestCase
{
    public function testSet()
    {
        $shell = new Shell();
        $storage = new GitStorage($shell);

        $storage->set(new Version(1,1,3));

        $this->assertEquals('git push --tag', $shell->popCommand());
        $this->assertEquals('git tag -a 1.1.3 -m "Version 1.1.3"', $shell->popCommand());
    }

    public function testGet()
    {
        $shell = new Shell();
        $storage = new GitStorage($shell);

        $shell->pushResult(['1.1.3'], 0);
        $r = $storage->get();

        $this->assertEquals('1.1.3', $r);
        $this->assertEquals('git describe', $shell->popCommand());
    }

}