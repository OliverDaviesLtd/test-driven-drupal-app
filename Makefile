COMPOSE_PROJECT_NAME?=test-driven-drupal-app

destroy:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose down --volumes --remove-orphans

disable:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose down

enable:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose up --detach --build

ps:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose ps

static-code-analysis: vendor
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec -T php bash -c 'phpstan analyze'

tests: vendor
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec -T php bash -c 'mkdir -p web/sites/default/files web/sites/simpletest'
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec -T php bash -c 'chown -R www-data:www-data web/sites/default/files web/sites/simpletest'
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec -T --user www-data php bash -c 'phpunit --testdox --colors=always'

vendor:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec -T php bash -c 'composer validate --strict'
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec -T php bash -c 'composer install'
.PHONY: *

# vim: noexpandtab filetype=make
