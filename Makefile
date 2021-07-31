args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

.PHONY: run
run: build start deps

.PHONY: build
build:
	@docker-compose build

.PHONY: start
start:
	@docker-compose up --detach

.PHONY: deps
deps: composer/install

.PHONY: database
database:
	# here wait for database service
	@docker-compose exec --user $$(id -u):$$(id -g) web php bin/console doctrine:database:create --if-not-exists
	@docker-compose exec --user $$(id -u):$$(id -g) web php bin/console doctrine:migrations:migrate --no-interaction

.PHONY: stop
stop:
	@docker-compose stop

composer/install:
	@docker-compose exec --user $$(id -u):$$(id -g) web composer install --prefer-dist

.PHONY: tests
tests:
	@docker-compose exec web php vendor/phpunit/phpunit/phpunit \
	--bootstrap ./tests/bootstrap.php \
	--configuration ./phpunit.xml.dist \
	./tests

.PHONY: console
console:
	@docker-compose exec --user $$(id -u):$$(id -g) web php bin/console $(call args)
