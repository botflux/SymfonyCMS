# TODO
#### Mockups
Faire le mockups pour les projets
#### Développement
Créer une entité pour les informations du site tel que le nom.
# Installation
## Clone the repo
`git clone https://github.com/botflux/SymfonyCMS.git`
## Install dependencies
`composer install`
## Create database
Enter your database credentials into the .env file.
`php bin/console doctrine:database:create`
`php bin/console doctrine:migrations:migrate`
## Install front-end dependencies
`yarn install`
## Run
`php bin/console server:run
yarn encore dev-server`