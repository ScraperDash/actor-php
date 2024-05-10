FROM php:8.2-cli-alpine

RUN apk add --no-cache \
		acl \
		file \
		gettext \
		git \
	;

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer:2 --link /usr/bin/install-php-extensions /usr/local/bin/

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY --from=composer/composer:2-bin --link /composer /usr/bin/composer

RUN sh -c "$(curl --location https://taskfile.dev/install.sh)" -- -d -b /usr/local/bin

# Install Dependencies

RUN install-php-extensions bcmath intl

COPY . /srv/app

WORKDIR /srv/app

RUN adduser -D -g '' -u 1000 localdevuser

ENTRYPOINT ["tail", "-f", "/dev/null"]
