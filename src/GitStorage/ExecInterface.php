<?php


namespace ComposerVersionPlugin\GitStorage;


interface ExecInterface
{
    public function exec(string $command, array &$output = []): int;
}