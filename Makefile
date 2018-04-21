PHPUNIT=vendor/bin/phpunit
PSALM=vendor/bin/psalm

all: build

.PHONY: build
build:
	${PSALM}

.PHONY: test
test: build
	${PHPUNIT} test
