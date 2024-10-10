# Variables
DOCKER = docker
DOCKER_COMPOSE = $(shell if command -v docker-compose > /dev/null; then echo "docker-compose"; else echo "docker compose"; fi)
PHP_CONTAINER = symfony-app-php

.PHONY: build up stop shell install test

# Start the Docker containers
up:
	@echo "Starting Docker containers..."
	$(DOCKER_COMPOSE) up -d --build

# Open a shell inside the PHP container
shell:
	@echo "Opening a shell inside the PHP container..."
	$(DOCKER) exec -it $(PHP_CONTAINER) sh

# Install Composer dependencies
install:
	@echo "Installing Composer dependencies..."
	$(DOCKER) exec $(PHP_CONTAINER) composer install

# Run PHPUnit tests
unit_test:
	@echo "Running PHPUnit tests..."
	$(DOCKER) exec $(PHP_CONTAINER) vendor/bin/phpunit

# Run behat tests
behat_test:
	@echo "Running PHPUnit tests..."
	$(DOCKER) exec $(PHP_CONTAINER) vendor/bin/behat

# Clean up the Docker containers and volumes
down:
	@echo "Cleaning up..."
	$(DOCKER_COMPOSE) down -v