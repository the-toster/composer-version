<?php
namespace ComposerVersionPlugin\GitStorage;

use ComposerVersionPlugin\StorageInterface;
use ComposerVersionPlugin\Version;
use ComposerVersionPlugin\StorageWriteError;

class GitStorage implements StorageInterface
{
    private $shell;
    private $noPush;

    public function __construct(ExecInterface $shell, bool $noPush)
    {
        $this->shell = $shell;
        $this->noPush = $noPush;
    }


    public function set(Version $version, string $annotation = null): void
    {
        $this->assertWorkingDirectoryClean();

        $tag = $version->getString();
        $annotation = $annotation ?? "Version $tag";
        $returnCode = $this->shell->exec("git tag -a $tag -m \"$annotation\"");
        if($returnCode !== 0) {
            throw new StorageWriteError;
        }

        if(!$this->noPush) {
            $this->pushTags();
        }
    }

    public function get(): ?string
    {
        $r = [];
        $exit_code = $this->shell->exec("git describe", $r);
        if($exit_code === 0) {
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
        $exit_code = $this->shell->exec("git rev-parse --is-inside-work-tree", $r);
        return $exit_code === 0 && trim($r[0] ?? '') === 'true';
    }

    private function pushTags(): void
    {

        $this->shell->exec('git push --tags', []);
    }

    private function assertWorkingDirectoryClean(): void
    {
        $r = [];
        $this->shell->exec('git status --porcelain', $r);
        $clean = trim(implode('', $r));
        if($clean !== '') {
            throw new WorkingDirectoryNotClean;
        }
    }
}