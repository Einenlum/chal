# chal

## Install

The project uses docker and docker-compose.

`make install`

## Tests

The project is statically checked thanks to [phpstan](https://github.com/phpstan/phpstan) and tested with [phpspec](https://github.com/phpspec/phpspec).

`make test`

## Some personal choices in this project

### Entities

I decided to use annotations instead of yaml to define my schema. I would prefer to decouple my models from my entities, but Yaml is deprecated in Doctrine and [will be dropped in Doctrine 3](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/yaml-mapping.html). Therefore (since I'm not really an XML fan), annotations are used here.

### Validation

Since the DTO are defined in the `Application` part, they should in theory know nothing about the infrastructure. The `Domain` should only know about itself. The `Application` can know about itself and the `Domain`. The `Infrastructure` can know about itself, the `Application` and the `Domain`.
This is why the validation part is defined in `Yaml` in `config/validation.yaml`.
In practice though, it happens that DTO have annotations containing constraints. This can be considered sometimes as a correct trade-off.
