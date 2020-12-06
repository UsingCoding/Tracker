all: boot-env boot-app

.PHONY: boot-env
boot-env:
	php bin/console app:boot

.PHONY: boot-app
boot-app:
	docker-php-entrypoint php-fpm