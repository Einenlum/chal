install:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php doctrine:database:create
	docker-compose exec php doctrine:migrations:migrate --no-interaction --all-or-nothing

up:
	docker-compose up -d

test:
	docker-compose exec php composer test
