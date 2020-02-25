<?php


namespace Test\Mock;



use ComposerVersionPlugin\StorageInterface;
use ComposerVersionPlugin\Version;

class InMemoryVersionStorage implements StorageInterface
{
    private $version;
    public function set(Version $v): void
    {
        $this->version = $v;
    }

    public function get(): string
    {
        return $this->version->getString();
    }
}