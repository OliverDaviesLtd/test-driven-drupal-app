# Do not edit this file. It is automatically generated by https://www.oliverdavies.uk/build-configs.

default:
  @just --list

# Start the project
start:
  cp -v --no-clobber .env.example .env
  docker compose up -d

# Stop the project
stop:
  docker compose down

composer *args:
  just _exec php composer {{ args }}

alias phpunit := test

test *args:
  just _exec php phpunit --colors=always {{ args }}

test-watch *args:
  nodemon --ext "*" --watch "." --exec "just test  || exit 1" --ignore */sites/simpletest

drush *args:
  just _exec php drush {{ args }}

install *args:
  just _exec php drush site:install -y {{ args }}





_exec +args:
  docker compose exec -T {{ args }}

_run service command *args:
  docker compose run \
    --entrypoint {{ command }} \
    --no-deps \
    --rm \
    -T \
    {{ service }} {{ args }}

# vim: ft=just
