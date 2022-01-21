.PHONY: shell-run install cc test-all test-unit start build run down stop

shell-run:
	docker-compose exec app bash

install:
	docker-compose exec app bash -c 'composer install'

cc:
	docker-compose exec app bash -c 'php bin/console cache:clear'

test-unit:
	docker-compose exec app bash -c 'php vendor/bin/codecept run unit'

start: build run install

build:
	docker-compose build

run:
	docker-compose up -d

down:
	docker-compose down

stop:
	docker-compose stop
