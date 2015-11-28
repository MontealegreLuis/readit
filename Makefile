SHELL = /bin/bash

.PHONY: install database

database:
	@echo "Creating database..."
	@php create-database.php $(RUSER) $(RPSWD) $(HOST) $(DB) $(USER) $(PSWD)

install: database
	@composer install
	@php artisan migrate
