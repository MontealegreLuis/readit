SHELL = /bin/bash

.PHONY: install

install:
	@echo "Creating database..."
	@php create-database.php $(RUSER) $(RPSWD) $(HOST) $(DB) $(USER) $(PSWD)
	@composer install
	@php artisan migrate
