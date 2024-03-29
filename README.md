# Symfony Docker + Multiple BDD

## Getting Started

1. Run `docker compose build --no-cache` to build fresh images
2. Run `docker compose up --pull always -d --wait` to start the project
3. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Migrations

1. Place yourself inside the php docker container with : `docker exec -it flowerpower-php-1 bash`
2. The migrations are already created in their specific directories, but if you need to create a migration, run `php bin/console doctrine:migrations:diff --em=orders --namespace=DoctrineMigrationsOrders`.  The `-em:name` option is used to specify which entities, through the entity manager, you wish to migrate to the database. The `--namespace=DoctrineMigrationsOrders` option is used to specify which repository you want to save your migration in. For each database, you have a specific repository. The Entity Managers are defined in the file config/packages/doctrine.yaml, while the namespace is defined in the file config/packages/doctrine_migrations.yaml. Please change the word Orders by the specific database you want to use.
3. To execute the migrations, run
`
php bin/console doctrine:migrations:execute --em=default --up 'DoctrineMigrations\Version20240328155424' &&
php bin/console doctrine:migrations:execute --em=orders --up 'DoctrineMigrationsOrders\Version20240328155304' &&
php bin/console doctrine:migrations:execute --em=products --up 'DoctrineMigrationsProducts\Version20240328155411' &&
php bin/console doctrine:migrations:execute --em=reviews --up 'DoctrineMigrationsReviews\Version20240328155336' &&
php bin/console doctrine:migrations:execute --em=erp --up 'DoctrineMigrationsErp\Version20240328155356' &&
php bin/console doctrine:migrations:execute --em=promotions --up 'DoctrineMigrationsPromotions\Version20240328155347'
`

## Fixtures

1. To execute the fixtures, place yourself inside the php docker container with : `docker exec -it flowerpower-php-1 bash`
2. Then run the command `php bin/console doctrine:fixtures:load`
