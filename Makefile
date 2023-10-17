# --------------------------------#
# Makefile for the "make" command
# --------------------------------#

# ----- Colors -----
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

# ----- Programs -----
PHP_UNIT = vendor/bin/phpunit

## ----- Test -----

test: ## test project
	$(PHP_UNIT)
	@$(call GREEN, "MakeFile : tests completed !")
