<?php
namespace ComposerVersionPlugin;

class Version
{
    private $major, $minor, $patch;


    public function __construct(int $major, int $minor, int $patch)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
    }

    public function getString(): string
    {
        return implode('.', [$this->major, $this->minor, $this->patch]);
    }

    public function bump(): void
    {
        $this->major++;
        $this->minor = 0;
        $this->patch = 0;
    }

    public function patch(): void
    {
        $this->patch++;
    }

}