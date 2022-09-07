# Time Tracker Project

This is the main repo of the time tracker.

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

- [Docker repository](https://github.com/PerezRaul/docker)

### Installation

1 - Add aliases to your _.bash_profile_ or _.zshrc_:

```shell
alias timetrackerup="~/Sites/docker ; docker-compose up -d php-worker-time-tracker"
alias timetrackerdown="~/Sites/docker ; docker-compose stop php-worker-time-tracker"
alias timetrackerbuild="~/Sites/docker ; docker-compose build php-worker-time-tracker"
```

2. Add `127.0.0.1 time-tracker.localhost` on `/etc/hosts`.
3. Clone repository inside `~/Sites`:
4. Copy the file **.env.example** to **.env**.
    ```shell
    > cp .env.example .env
    ```
5. Start the time tracker containers:
    ```shell
    > timetrackerup
    ```
6. Go inside the workspace with the following command:
    ```shell
    > dockerbash
    ```
7. Execute the following commands on backend backoffice folder _/var/www/time-tracker_:
    ```shell
    > composer install
    > php artisan time-tracker:domain-events:rabbitmq:configure #Creates exchanges and queue for each subscriber
    > php artisan migrate:fresh --seed
    > npm install
    ```

## RabbitMQ Events

### Generate supervisord config files

```shell
> php artisan time-tracker:domain-events:rabbitmq:generate-supervisor-files
```

## Code analysis

### All code analysis

```shell
> sh analysis.sh
```
