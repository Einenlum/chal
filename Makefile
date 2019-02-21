install:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php doctrine:database:create
	docker-compose exec php doctrine:migrations:migrate --no-interaction --all-or-nothing

up:
	docker-compose up -d

unit-test:
	docker-compose exec php composer unit-test

prepare-e2e-test:
	docker-compose exec -e APP_ENV=test php bin/console doctrine:database:drop --if-exists --force
	docker-compose exec -e APP_ENV=test php bin/console doctrine:database:create
	docker-compose exec -e APP_ENV=test php bin/console doctrine:schema:create

e2e-test:
	docker-compose exec php composer e2e-test

test:
	make unit-test
	make prepare-e2e-test
	make e2e-test
