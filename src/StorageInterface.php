<?php


namespace ComposerVersionPlugin;


interface StorageInterface
{
    public function set(Version $version): void;
    public function get(): ?string;
    public function has(): bool;
    public function isAccessible(): bool;
}