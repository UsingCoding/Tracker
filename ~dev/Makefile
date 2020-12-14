all: build boot-env boot-app

.PHONY: build
build:
	composer install & (yarn install && yarn run dev)

.PHONY: boot-env
boot-env:
	php bin/console app:boot

.PHONY: boot-app
boot-app:
	docker-php-entrypoint php-fpm