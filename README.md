# test-driven-drupal-example-app

## Installing Drupal

    docker-compose exec php drush site:install -y --account-pass=admin120 --site-name="TestConf"

## Running tests

    docker-compose exec -u www-data php phpunit
