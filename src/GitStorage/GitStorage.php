<?php
namespace ComposerVersionPlugin\GitStorage;

use ComposerVersionPlugin\StorageInterface;
use ComposerVersionPlugin\Version;
use ComposerVersionPlugin\StorageWriteError;

class GitStorage implements StorageInterface
{
    private $shell;

    public function __construct(ExecInterface $shell)
    {
        $this->shell = $shell;
    }


    public function set(Version $version, string $annotation = null): void
    {
        $tag = $version->getString();
        $annotation = $annotation ?? "Version $tag";
        $returnCode = $this->shell->exec("git tag -a $tag -m \"$annotation\"");
        if($returnCode !== 0) {
            throw new StorageWriteError;
        }
    }

    /**
     * @psalm-suppress MixedReturnStatement
     * @psalm-suppress MixedInferredReturnType
     */
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
        /** @psalm-suppress MixedArgument */
        return $exit_code === 0 && trim($r[0] ?? '') === 'true';
    }
}