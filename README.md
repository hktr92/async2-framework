# async2 framework

it's a concept of modular and easy to use php framework, aimed for both learning purposes and small to medium projects.

the main target is to be fast. how fast? blazing fast. it should execute in <100ms.

in order to achieve this, the framework will make use of an async php extension.

currently, the development is done in classic synchronous php for rapid development.

## features

currently, it has:

- complete request / response flow
- event bus to dispatch events

## tbd

- logger
- orm from scratch
- unit tests
- add an extendable context class for cleaner callbacks.

## development

- start the `docker-compose.yml`
- install dependencies: `docker/run composer install`

an example app is listening on `localhost:6980`
demo routes:

- `GET /` -> html output
    - optional query parameter: `name` with any string value
- `GET /index.json` -> json output