# KiloWatts <img src="https://kilo-watts.com/assets-home/images/logo/transparent-logo.png" width="25">  

## Introduction

KiloWatts is an application that enables you to track electricity consumption in your buildings.
The production version of the application can be accessed on this link: https://kilo-watts.com/.

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
- Setup Homestead
- Clone project
- Homestead setup DB and URLs
- Show hosts file and Homestead file content.
- SSH to Homestead
- Install Composer
- Check if .env exists
- Add credentials to .env (copy from my)
- Migrate database with seeders
- Install FE dependencies.
- Run phpunit tests.
- Visit http://kilo-watts.local

- Install dependencies

## Test account
There is a test account for playing around, the credentials are:
```
E-mail: regular@kilo-watts.com
Password: password
```

## Postman collection

## ERD
