<?php


namespace ComposerVersionPlugin\Plugin;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\Capable;

class Plugin implements PluginInterface, Capable, CommandProvider
{

    public function deactivate(Composer $composer, IOInterface $io)
    {

    }

    public function uninstall(Composer $composer, IOInterface $io)
    {

    }

    public function activate(Composer $composer, IOInterface $io)
    {

    }

    public function getCapabilities()
    {
        return [CommandProvider::class => self::class];
    }

    public function getCommands()
    {
        return [new Command()];
    }

}