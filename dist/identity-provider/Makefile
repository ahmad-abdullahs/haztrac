SHELL := /bin/bash
APP_DEPLOY_DIR := app/deploy
LOCAL_COMPOSE_FILE := $(APP_DEPLOY_DIR)/local-compose.yml

default: test

###################
# Install #
###################

# Install all 3rd-party library dependencies
.PHONY: deps
deps:
	composer install


###################
# Build #
###################

# Build grpc php library
.PHONY: grpc
grpc:
	bin/protogen.sh

# Build and rebuild CSS from LESS files
.PHONY: css
css:
	bin/css.sh


###################
# Docker #
###################

# Build and push production docker image to all required registries
.PHONY: docker-deploy-prod
docker-deploy-prod:
	bin/deploy-images.sh

.PHONY: docker-dev
docker-dev:
	docker build --pull -t registry.sugarcrm.net/identity-provider/identity-provider:latest --build-arg DEV=true -f ./app/deploy/Dockerfile ./

# Run full dockerized production IdentityProvider service locally
.PHONY: docker-run-local
docker-run-local:
	docker-compose -f $(LOCAL_COMPOSE_FILE) build
	docker-compose -f $(LOCAL_COMPOSE_FILE) up -d
	docker-compose -f $(LOCAL_COMPOSE_FILE) exec idp /bin/bash -c \
		'./bin/console migrations:migrate --no-interaction && ./bin/console fixtures:load'
	trap 'docker-compose -f $(APP_DEPLOY_DIR)/local-compose.yml down' 2 && \
	docker-compose -f $(LOCAL_COMPOSE_FILE) logs -ft


###################
# Test #
###################

# Run all tests (except Behat E2E tests)
.PHONY: test
test: test-code-standards test-unit test-functional

# Run unit tests
.PHONY: test-unit
test-unit:
	./vendor/bin/phpunit --testsuite 'Unit Tests'

# Run functional tests
.PHONY: test-functional
test-functional:
	./vendor/bin/phpunit --testsuite 'Functional Tests'

# Run PSR code-style check test
.PHONY: test-code-standards
test-code-standards:
	./vendor/bin/php-cs-fixer fix --config=.php_cs.dist --diff --dry-run --verbose --using-cache=no
