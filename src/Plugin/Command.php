<?php


namespace ComposerVersionPlugin\Plugin;

use ComposerVersionPlugin\GitStorage\GitStorage;
use ComposerVersionPlugin\GitStorage\Shell;
use ComposerVersionPlugin\GitStorage\WorkingDirectoryNotClean;
use ComposerVersionPlugin\StorageInaccessible;
use ComposerVersionPlugin\StorageWriteError;
use ComposerVersionPlugin\Version;
use ComposerVersionPlugin\VersionManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class Command extends BaseCommand
{
    protected function configure()
    {
        $this->setName('version');
        $this->setDescription("Manage project version with git tags");
        $this->setHelp('Provides commands to increment version numbers or set version directly (Major.Minor.Patch format)');
        $this->addArgument('action', InputArgument::OPTIONAL, '[<newversion> | major | minor | patch | get]', 'get');
        $this->addOption('no-push', null,InputOption::VALUE_NONE, 'Prevent `git push --tags`');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /**
         * @psalm-suppress PossiblyInvalidCast
         */
        $action = (string) $input->getArgument('action');
        $noPush = (bool) $input->getOption('no-push');
        try {
            return $this->performAction($action, $io, $noPush);
        } catch (WorkingDirectoryNotClean $e) {
            $io->error('Working directory is not clean, please commit your changes first');
        } catch (StorageInaccessible $e) {
            $io->error('No suitable git repository found, cant use git storage');
        } catch (StorageWriteError $e) {
            $io->error('Cant create git tag. Maybe no commits?');
        }

        return 0;
    }

    private function performAction(string $action, SymfonyStyle $io, bool $noPush): int
    {
        $versionManager = new VersionManager(new GitStorage(new Shell(), $noPush));

        if (in_array($action, ['major', 'minor', 'patch', 'get'])) {
            $version = call_user_func([$versionManager, $action]);
            return $this->outputVersion($version, $io);
        }

        if (!$versionManager->validateVersionString($action)) {
            $io->error("Invalid version format. Only MAJOR.MINOR.PATCH supported");
            return 1;
        }

        $version = $versionManager->setNewVersion($action);
        return $this->outputVersion($version, $io);

    }

    private function outputVersion(Version $version, SymfonyStyle $output): int
    {
        $output->writeln($version->getString());
        return 0;
    }
}