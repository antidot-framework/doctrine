# Antidot Doctrine Integration

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/antidot-framework/doctrine/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/antidot-framework/doctrine/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/antidot-framework/doctrine/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/antidot-framework/doctrine/?branch=master)
[![type-coverage](https://shepherd.dev/github/antidot-framework/doctrine/coverage.svg)](https://shepherd.dev/github/antidot-framework/doctrine)
[![Build Status](https://scrutinizer-ci.com/g/antidot-framework/doctrine/badges/build.png?b=master)](https://scrutinizer-ci.com/g/antidot-framework/doctrine/build-status/master)

Integration library between [Doctrine ORM](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/index.html) and 
[Antidot Framework](https://antidotfw.io/#/framework/getting-started) using [Roave PSR-11 Doctrine factories](https://github.com/Roave/psr-container-doctrine).

## Requirements

* PHP >= 7.2.13 for 0.0.x
* PHP >= 7.4.0 for current

## Install

Install using [composer](https://getcomposer.org/download/).

```bash
composer require antidot-fw/doctrine
```

## Default Config in Antidot Framework Starter

Doctrine integration requires a minimum config to work, by default it is configured with [the `SimplifiedYamlDriver`](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/yaml-mapping.html#simplified-yaml-driver). 
When you need more complex or more custom config you can implement it without ani issues following [doctrine docs](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/index.html).

```yaml
# Example using PDOSqliteDriver, and allocating yaml files at `config/doctrine` 
# directory for `App\Domain\Model` namespace.
parameters:
  doctrine:
    connection:
      orm_default:
        driver_class: Doctrine\DBAL\Driver\PDOSqlite\Driver
        params:
          path: var/database.sqlite
    driver:
      orm_default:
        paths:
          config/doctrine: App\Domain\Model
```


[ico-version]: https://img.shields.io/packagist/v/antidot-fw/doctrine.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/antidot-fw/doctrine

