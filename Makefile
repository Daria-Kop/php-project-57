start:
	php artisan serve --host 0.0.0.0

start-npm:
	npm run dev

setup:
	composer install

db-create:
	touch database/database.sqlite

migrate:
	php artisan migrate

seed:
	php artisan db:seed

test:
	php artisan test

test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml

lint-fix:
	composer exec --verbose phpcbf

ide-helper:
	php artisan ide-helper:eloquent
	php artisan ide-helper:gen
	php artisan ide-helper:meta
	php artisan ide-helper:mod -n

lint:
	composer exec --verbose phpcs
inspect:
	composer exec --verbose phpstan analyse -- --memory-limit 512M
install-test:
	@echo "Установка тестовых зависимостей..."
	composer install --dev
