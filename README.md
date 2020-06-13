# Antidot Doctrine Integration

Integration library between [Doctrine ORM](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/index.html) and 
[Antidot Framework](https://antidotfw.io/#/framework/getting-started) using [Roave PSR-11 Doctrine factories](https://github.com/Roave/psr-container-doctrine).

## Install

Install using [composer]().

```bash
composer require antidot-fw/doctrine
```

## Default Config fot Antidot Framework Starter

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


