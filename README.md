# Symfony Docker + Multiple BDD

## Getting Started

1. Run `docker compose build --no-cache` to build fresh images
2. Run `docker compose up --pull always -d --wait` to start the project
3. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Migrations

1. To create a migration, run : `php bin/console doctrine:migrations:diff --em=orders --namespace=DoctrineMigrationsOrders`, the -em:`name` is used to specified which entities through the entity manager you wish to migrate to the database. The --namespace=DoctrineMigrations`Orders` is used to specified wich repository you want to save your migration, for each database you have a specific repository. The Entities Managers are defined in the the file config/packages/doctrine.yaml, about the namespace it's in the file config/packages/doctrine_migrations.yaml
2. To execute the migration, run : 
`php bin/console doctrine:migrations:execute --em=default --up 'DoctrineMigrations\Version2024032815542' &&
php bin/console doctrine:migrations:execute --em=orders --up 'DoctrineMigrationsOrders\Version20240328155304' &&
php bin/console doctrine:migrations:execute --em=products --up 'DoctrineMigrationsProducts\Version20240328155411' &&
php bin/console doctrine:migrations:execute --em=reviews --up 'DoctrineMigrationsReviews\Version20240328155336' &&
php bin/console doctrine:migrations:execute --em=erp --up 'DoctrineMigrationsErp\Version20240328155356' &&
php bin/console doctrine:migrations:execute --em=promotions --up 'DoctrineMigrationsPromotions\Version20240328155347'`
