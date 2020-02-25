<?php
namespace ComposerVersionPlugin\GitStorage;

use ComposerVersionPlugin\StorageInterface;
use ComposerVersionPlugin\Version;
use http\Exception\UnexpectedValueException;

class GitStorage implements StorageInterface
{

    public function set(Version $version): void
    {
        $tag = $version->getString();
        $annotation = "Version $tag";
        passthru("git tag -a $tag -m $annotation");
        passthru("git push -tag");
    }

    public function get(): string
    {
        $r = '';
        $return_val = 0;
        exec("git describe", $r, $return_val);
        if($return_val === 0) {
            return $r;
        }
        throw new UnexpectedValueException("git describe return error");
    }
}