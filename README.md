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
