COMPOSE_PROJECT_NAME?=test-driven-drupal-app

destroy:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose down --volumes --remove-orphans

disable:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose down

enable:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose up --detach --build

ps:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose ps

test:
	COMPOSE_PROJECT_NAME=$(COMPOSE_PROJECT_NAME) docker-compose exec --user www-data php phpunit

.PHONY: *

# vim: noexpandtab filetype=make
