<?php
namespace Test\Feature;

use ComposerVersionPlugin\Version;
use ComposerVersionPlugin\VersionManager;
use PHPUnit\Framework\TestCase;
use Test\Mock\InMemoryVersionStorage;

class VersionManagerTest extends TestCase
{
    private function getManager($major, $minor, $patch): VersionManager
    {
        $versionStorage = new InMemoryVersionStorage();
        $versionStorage->set(new Version($major, $minor, $patch));
        return new VersionManager($versionStorage);
    }

    public function testGetVersion()
    {
        $versionManager = $this->getManager(1,3,5);
        $this->assertEquals('1.3.5', $versionManager->getCurrent()->getString());
    }

    public function testMajor()
    {
        $versionManager = $this->getManager(1,3,5);
        $versionManager->major();
        $this->assertEquals('2.0.0', $versionManager->getCurrent()->getString());
    }


    public function testMinor()
    {
        $versionManager = $this->getManager(1,3,5);
        $versionManager->minor();
        $this->assertEquals('1.4.0', $versionManager->getCurrent()->getString());
    }

    public function testPatch()
    {
        $versionManager = $this->getManager(1,3,5);
        $versionManager->patch();
        $this->assertEquals('1.3.6', $versionManager->getCurrent()->getString());
    }
}