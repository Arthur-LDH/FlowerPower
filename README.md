# Symfony Docker + Multiple BDD

## Getting Started

1. Run `docker compose build --no-cache` to build fresh images
2. Run `docker compose up --pull always -d --wait` to start the project
3. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Migrations

1. To create a migration, run : `php bin/console doctrine:migrations:diff --em=orders --namespace=DoctrineMigrationsOrders`, the -em:`name` is used to specified which entities through the entity manager you wish to migrate to the database. The --namespace=DoctrineMigrations`Orders` is used to specified wich repository you want to save your migration, for each database you have a specific repository. The Entities Managers are defined in the the file config/packages/doctrine.yaml, about the namespace it's in the file config/packages/doctrine_migrations.yaml
2. To execute your migration, run : `php bin/console doctrine:migrations:migrate --em:orders --namespace=DoctrineMigrationsOrders`
