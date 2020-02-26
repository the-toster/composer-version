<?php
require __DIR__.'/vendor/autoload.php';

$manager = new \ComposerVersionPlugin\VersionManager(new \ComposerVersionPlugin\GitStorage\GitStorage());

if(!$manager->has()){
    echo "No version tag found".PHP_EOL;
} else {
    echo $manager->getCurrent()->getString().PHP_EOL;
}
