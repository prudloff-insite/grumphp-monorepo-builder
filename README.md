# GrumPHP monorepo-builder

This [GrumPHP](https://github.com/phpro/grumphp) task
runs `monorepo-builder validate` command
from [monorepo-builder](https://github.com/symplify/monorepo-builder).

It can be used to detect inconsistencies in Composer constraints between
the different projects of a monorepo.

It can be used like this:

```yaml
---
grumphp:
  extensions:
    - GrumphpMonorepoBuilder\Loader
  tasks:
    monorepo_builder: ~
```
