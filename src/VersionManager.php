<?php


namespace ComposerVersionPlugin;


class VersionManager
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function major(): Version
    {
        $version = $this->getCurrent();
        $version->major();
        $this->storage->set($version);
        return $version;
    }

    public function minor(): Version
    {
        $version = $this->getCurrent();
        $version->minor();
        $this->storage->set($version);
        return $version;
    }

    public function patch(): Version
    {
        $version = $this->getCurrent();
        $version->patch();
        $this->storage->set($version);
        return $version;
    }

    public function has(): bool
    {
        $this->assertStorageAccessible();
        return $this->storage->has();
    }

    public function getCurrent(): Version
    {
        $this->assertStorageAccessible();
        $string = $this->storage->get();
        return $this->parseStringVersion($string ?? '0.0.0');
    }

    private function assertStorageAccessible()
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