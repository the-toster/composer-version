<?php


namespace Test\Mock;


use ComposerVersionPlugin\GitStorage\ExecInterface;

class Shell implements ExecInterface
{
    private $results = [], $commands = [];

    public function pushResult(array $output, $exit_code)
    {
        $this->results[] = [$output, $exit_code];
    }

    public function popCommand(): ?string
    {
        return array_pop($this->commands);
    }

    public function exec(string $command, array &$output = []): int
    {
        $this->commands[] = $command;
        $r = array_pop($this->results);
        $output = $r[0] ?? [];
        return $r[1] ?? 0;
    }
}