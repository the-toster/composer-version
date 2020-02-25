<?php


namespace ComposerVersionPlugin;


class VersionManager
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function major(): void
    {
        $version = $this->getCurrent();
        $version->bump();
        $this->storage->set($version);

    }

    public function getCurrent(): Version
    {
        $string = $this->storage->get();
        return $this->parseStringVersion($string);
    }

    private function parseStringVersion(string $input): Version
    {
        if(substr($input, 0, 1) === 'v'){
            $input = substr($input, 1);
        }
        $parts = explode('.', $input);
        $major = (int) ($parts[0] ?? 0);
        $minor = (int) ($parts[1] ?? 0);
        $patch = (int) ($parts[2] ?? 0);
        return new Version($major, $minor, $patch);
    }
}