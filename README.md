# Composer version plugin
Add NPM-like version commands to composer
It uses git tags to store version information

## Installation
```
composer global require the-toster/composer-version
```

## Usage
```
$ composer version 0.0.1
0.0.1
$ composer version patch
0.0.2
$ composer version minor
0.1.0
$ composer version major
1.0.0
```

## What it does


```shell script
composer version get 
# parse `git describe` to get version numbers (major.minor.patch) from latest tag 

composer version 1.0.1
# creates new annotated tag: `git tag 1.0.1 -a "Version 1.0.1"`

composer version minor
# use `git describe` to extract current version, 
# increments minor: 1.0.1 -> 1.1.0
# creates new annotated tag 1.1.0

# and so on
```

