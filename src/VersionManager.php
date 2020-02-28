<?php


namespace ComposerVersionPlugin;


class VersionManager
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function validateVersionString(string $s): bool
    {
        return preg_match("~^\d+\.\d+\.\d+$~", $s) === 1;
    }

    public function setNewVersion(string $s): Version
    {
        $version = $this->parseStringVersion($s);
        $this->storage->set($version);
        return $version;
    }

    public function major(): Version
    {
        $version = $this->get();
        $version->major();
        $this->storage->set($version);
        return $version;
    }

    public function minor(): Version
    {
        $version = $this->get();
        $version->minor();
        $this->storage->set($version);
        return $version;
    }

    public function patch(): Version
    {
        $version = $this->get();
        $version->patch();
        $this->storage->set($version);
        return $version;
    }

    public function has(): bool
    {
        $this->assertStorageAccessible();
        return $this->storage->has();
    }

    public function get(): Version
    {
        $this->assertStorageAccessible();
        $string = $this->storage->get();
        return $this->parseStringVersion($string ?? '0.0.0');
    }

    private function assertStorageAccessible(): void
    {
        if (!$this->storage->isAccessible()) {
            throw new StorageInaccessible;
        }
    }

    private function parseStringVersion(string $input): Version
    {
        if (substr($input, 0, 1) === 'v') {
            $input = substr($input, 1);
        }
        $parts = explode('.', $input);
        $major = (int)($parts[0] ?? 0);
        $minor = (int)($parts[1] ?? 0);
        $patch = (int)($parts[2] ?? 0);
        return new Version($major, $minor, $patch);
    }
}