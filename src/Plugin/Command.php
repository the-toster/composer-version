<?php


namespace ComposerVersionPlugin\Plugin;

use ComposerVersionPlugin\GitStorage\GitStorage;
use ComposerVersionPlugin\GitStorage\Shell;
use ComposerVersionPlugin\StorageInaccessible;
use ComposerVersionPlugin\Version;
use ComposerVersionPlugin\VersionManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class Command extends BaseCommand
{
    protected function configure()
    {
        $this->setName('version');
        $this->addArgument('action', InputArgument::OPTIONAL, '[<newversion> | major | minor | patch]');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $versionManager = new VersionManager(new GitStorage(new Shell()));
        $action = $input->getArgument('action');
        try {
            if (in_array($action, ['major', 'minor', 'patch', null])) {
                $action = $action ?? 'getCurrent';
                $version = call_user_func([$versionManager, $action]);
                return $this->outputVersion($version, $io);
            } else {

            }
        } catch (StorageInaccessible $e) {
            $io->getErrorStyle()->writeln('No git repository found, cant use git storage');

        }


        return 0;
    }

    private function outputVersion(Version $version, SymfonyStyle $output)
    {
        $output->writeln($version->getString());
        return 0;
    }
}