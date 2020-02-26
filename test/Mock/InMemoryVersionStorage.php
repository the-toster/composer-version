<?php


namespace Test\Mock;



use ComposerVersionPlugin\StorageInterface;
use ComposerVersionPlugin\Version;

class InMemoryVersionStorage implements StorageInterface
{
    private $version, $accessible = true;
    public function set(Version $v = null): void
    {
        $this->version = $v;
    }

    public function has(): bool
    {
        return $this->version !== null;
    }

    public function get(): string
    {
        return $this->version->getString();
    }

    public function setAccessible(bool $v): void
    {
        $this->accessible = $v;
    }

    public function isAccessible(): bool
    {
        return $this->accessible;
    }
}