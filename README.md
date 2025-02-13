<div align="center">

# QCM Project with Symfony 

</div>

## Informations

This project is for educational purposes only. It is a simple QCM project with Symfony.

* **php:** `8.2.12`
* **symfony:** `7.2.2`
* **composer:** `2.7.9`

## Requirements

> [!important]
> This project works with the symfony API in the following repository
> <a href="https://github.com/AuroreMOMYM22004066/R6_A_05_DevAvance_Api.git">API Repository</a><br>
> To run this project properly, you need to have the API running.

> [!important]
> The API have to be running on the port `127.0.0.1:8001`.<br>
> add in .env : <br>
> ```API_FLAG_URL="http://localhost:8001"``` 

You also need to have the following tools installed on your machine:
* **php:** `8.2.12`
* **symfony:** `7.2.2`
* **composer:** `2.7.9`
* **mysql** : `8.0.41`

## Installation

### step 1: Clone the project
```bash
git clone git@github.com:AuroreMOMYM22004066/R6_A_05_DevAvance_Project.git
```

### step 2: Install dependencies

```bash
composer install
```

### step 3: Database setup

```bash
php bin/console doctrine:database:create
```
```bash
php bin/console doctrine:migrations:migrate
```
```bash
php bin/console doctrine:fixtures:load
```

### step 4: Run the project

```bash
symfony server:start
```
