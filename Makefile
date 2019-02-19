install:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

up:
	docker-compose up -d

test:
	docker-compose exec php composer test
