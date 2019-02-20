# chal

## Install

The project uses docker and docker-compose.

`make install`

## Tests

The project is statically checked thanks to [phpstan](https://github.com/phpstan/phpstan) and tested with [phpspec](https://github.com/phpspec/phpspec).

`make test`

## Architecture

The project follow the Hexagonal architecture: the project is divided between:

- The `domain` part (all the core knowledge of the domain: here all the core bricks of the app, all the rules concerning places, events, etc.)
- The `application` part (the parts that will contain the DTOs and some handlers which can apply some actions on the model)
- The `infrastructure` part: all the third party layers (the adapters) that are implementation details (framework, IO…).

The bricks of the domain know nothing about the infrastructure. The `Domain` should only know about itself. The `Application` can know about itself and the `Domain`. The `Infrastructure` can know about itself, the `Application` and the `Domain`.

This architecture helps building solid and maintainable code: the core of the app is not dependant in any way from the third party tools. This means that the project can be focused first on the domain knowledge (which can be unit tested) and the implementation choices (which message broker or database to use…) can be done later with a better understanding of the requirements.

## Some personal choices in this project

### Entities

I decided to use annotations instead of yaml to define my schema. I would prefer to decouple my models from my entities, but Yaml is deprecated in Doctrine and [will be dropped in Doctrine 3](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/yaml-mapping.html). Therefore (since I'm not really an XML fan), annotations are used here.

### Validation

Since the DTO are defined in the `Application` part, they should in theory know nothing about the infrastructure (cf. supra). This is why the validation part is defined in `Yaml` in `config/validation.yaml`.
In practice though, it happens that DTO have annotations containing constraints. This can be considered sometimes as an acceptable trade-off.

### Request lifecycle

Because decoding the request and validating it is a repetitive and tedious task, I decided to implement two event subscribers dedicated to these tasks.

The first one (`App\Infrastructure\Symfony\Request\Subscriber\DecodeJson`) is taking the request json content and tries to decode it. If it fails, then we can already throw a `BadRequestHttpException` (400), because it means the JSON is malformed.

The second one (`App\Infrastructure\Symfony\Request\Subscriber\InjectDTOIfNeeded`) runs after the first one. If the Controller has a custom `@InjectDTO` annotation on the method, it will transform the decoded data from the `Request` to the requested DTO, and it will inject it into the `Request`'s attributes so that it is available in the controller arguments.

It's maybe a bit overkill, but it's always fun to play with the listeners.
Also `EventSubscriber`s are preferred to `EventListener`s because we know right away in the class which events they're listening at. Plus, the use of constants avoid typo mistakes.
