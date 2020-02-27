<?php


namespace ComposerVersionPlugin\GitStorage;


class Shell implements ExecInterface
{
    public function exec(string $command, array &$output = []): int
    {
        $exit_code = 0;
        exec($command, $output, $exit_code);
        return $exit_code;
    }
}