<?php


namespace ComposerVersionPlugin;


interface StorageInterface
{
    public function set(Version $version): void;
    public function get(): string;
}