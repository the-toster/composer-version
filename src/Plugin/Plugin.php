<?php


namespace ComposerVersionPlugin\Plugin;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\Capable;

class Plugin implements PluginInterface, Capable, CommandProvider
{

    /** @return void */
    public function activate(Composer $composer, IOInterface $io)
    {

    }

    /** @return array<array-key, string> */
    public function getCapabilities()
    {
        return [CommandProvider::class => self::class];
    }

    /** @return array<array-key, \Composer\Command\BaseCommand> */
    public function getCommands()
    {
        return [new Command()];
    }

    /** @return void */
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    /** @return void */
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}