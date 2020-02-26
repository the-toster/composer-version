<?php
namespace ComposerVersionPlugin\GitStorage;

use ComposerVersionPlugin\StorageInterface;
use ComposerVersionPlugin\Version;

class GitStorage implements StorageInterface
{

    public function set(Version $version, string $annotation = null): void
    {
        $tag = $version->getString();
        $annotation = $annotation ?? "Version $tag";
        passthru("git tag -a $tag -m $annotation");
        //passthru("git push --tag");
    }

    public function get(): ?string
    {
        $r = [];
        $return_val = 0;
        exec("git describe", $r, $return_val);
        if($return_val === 0) {
            return $r[0] ?? '';
        }
        return null;
    }

    public function has(): bool
    {
        return $this->get() !== null;
    }

    public function isAccessible(): bool
    {
        $r = [];
        exec("git rev-parse --is-inside-work-tree", $r, $return_val);
        return $return_val === 0 && trim($r[0] ?? '') === 'true';
    }
}