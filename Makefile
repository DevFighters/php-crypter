# --------------------------------#
# Makefile for the "make" command
# --------------------------------#

# ----- Colors -----
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

# ----- Programs -----
PHP_UNIT = vendor/bin/phpunit
COMPOSER = composer

## ----- UseCase -----

## Test project
test:
	$(PHP_UNIT)
	@$(call GREEN, "MakeFile : tests completed !")

## Analyze PHP code
phploc:
	wget https://phar.phpunit.de/phploc.phar
	php phploc.phar --version
	php phploc.phar src