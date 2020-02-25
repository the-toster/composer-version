<?php
namespace Test\Feature;

use ComposerVersionPlugin\Version;
use ComposerVersionPlugin\VersionManager;
use PHPUnit\Framework\TestCase;
use Test\Mock\InMemoryVersionStorage;

class VersionManagerTest extends TestCase
{
    public function testGetVersion()
    {
        $versionStorage = new InMemoryVersionStorage();
        $versionStorage->set(new Version(1, 3, 5));
        $versionManager = new VersionManager($versionStorage);
        $this->assertEquals('1.3.5', $versionManager->getCurrent()->getString());

    }
}