# KiloWatts <img src="https://kilo-watts.com/assets-home/images/logo/transparent-logo.png" width="25">  

## Introduction

KiloWatts is an application that enables you to track electricity consumption in your buildings.
The production version of the application can be accessed on this link: https://kilo-watts.com/. 
The test account can be found in the end of this file.

The technologies used are:
- API: Laravel 8
- SPA: VueJS 2.6
- Database: MySQL 5.7
- API authentication: Sanctum 2.9

The folder structure of the application is a typical Laravel structure, with the SPA located
inside the *frontend/* folder.

## Prerequisites

For local development, Homestead is probably the best choice, but if you prefer other tools,
feel free to use them. For installation guide on Homestead, or to cross-reference what
Homestead has installed, please check this link: https://laravel.com/docs/8.x/homestead#introduction. 

General prerequisites for the application are:
- PHP **^7.3 | ^8.0** (8.0 is preferred)
- Composer **2.0.12**
- MySQL **5.7.32** (MySQL v8 supported)
- Node **12.20.0**
- NPM **6.14.9**
- Yarn **1.22.10**

## Installation

Steps:
1. Setup Homestead (follow Laravel documentation)
2. Clone project with GitHub and rename the project folder to **kilo-watts**.

3. Homestead setup DB and URLs mappings:
```
folders:
    - map: ~/development/projects/kilo-watts
      to: /home/vagrant/code/kilo-watts

sites:
    - map: kilo-watts.local
      to: /home/vagrant/code/kilo-watts/public
    - map: api.kilo-watts.local
      to: /home/vagrant/code/kilo-watts/public
    - map: app.kilo-watts.local
      to: /home/vagrant/code/kilo-watts/public
```

4. SSH to Homestead, go to */code/kilo-watts* folder and run next commands:

5. Install backend dependencies by running:
```
composer install
```

6. Copy .env file:
```
cp .env.example .env
```

7. Migrate database and seed with test data.
```
artisan migrate --seed
```

8. Run PHPUnit and check if the backend is working.
```
phpunit
```

9. Install frontend dependencies by running next commands one-by-one:
```
yarn
cd frontend/
yarn
yarn dev
```

10. Visit **http://kilo-watts.local** and check if everything is working.

## Test account
There is a test account for playing around, the credentials are:
```
E-mail: "regular@kilo-watts.com"
Password: "password"
```

## Postman collection
Link to the Postman collection: *https://documenter.getpostman.com/view/1066342/TzCL7ntG* 
There are multiple environments including local and production. For authenticating, use the 
**Get Api Token** endpoint to fetch the token, which Postman will automatically save for
all future requests.

