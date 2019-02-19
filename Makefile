install:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php doctrine:database:create

up:
	docker-compose up -d

test:
	docker-compose exec php composer test
