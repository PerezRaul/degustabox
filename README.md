# Degusta Box Project

This is the main repo of the Degusta Box test.

## Table of contents

- [Setup in local development](#setup-in-local-development)
    - [Requirements](#requirements)
    - [Installation](#installation)
- [RabbitMQ Events](#rabbitmq-events)
    - [Generate supervisord config files](#generate-supervisord-config-files)
- [Code analysis](#code-analysis)
    - [All code analysis](#all-code-analysis)

## Setup in local development

### Requirements

- [Docker repository](https://github.com/PerezRaul/degustabox-docker)

### Installation

1 - Add aliases to your _.bash_profile_ or _.zshrc_:

```shell
alias degustaboxup="~/Sites/degustabox-docker ; docker-compose up -d php-worker-degustabox"
alias degustaboxdown="~/Sites/degustabox-docker ; docker-compose stop php-worker-degustabox"
alias degustaboxbuild="~/Sites/degustabox-docker ; docker-compose build php-worker-degustabox"
```

2. Add `127.0.0.1 degustabox.localhost` on `/etc/hosts`.
3. Clone repository inside `~/Sites/degustabox`:
4. Copy the file **.env.example** to **.env**.
    ```shell
    > cp .env.example .env
    ```
5. Start the degustabox containers:
    ```shell
    > degustaboxup
    ```
6. Go inside the workspace with the following command:
    ```shell
    > dockerbash
    ```
7. Execute the following commands on backend backoffice folder _/var/www/degustabox_:
    ```shell
    > composer install
    > php artisan degustabox:domain-events:rabbitmq:configure #Creates exchanges and queue for each subscriber
    > php artisan migrate:fresh --seed
    > npm install
    ```

## RabbitMQ Events

### Generate supervisord config files

```shell
> php artisan degustabox:domain-events:rabbitmq:generate-supervisor-files
```

## Code analysis

### All code analysis

```shell
> sh analysis.sh
```
