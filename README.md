symfony_angular
======================

Project Bootstrap for Symfony 2 + Angularjs. 
There is a test 'Post' module implemented like REST API. 
Created on December 11, 2015, 6:17 am.

TECHNICAL REQUIREMENTS
========================

* git  
* composer
* bower
* compass
* gulp
* php >= 5.4  
* APC enabled  
* intl php extension

GIT REPO BRANCHES
========================

* master - main work branch

* production - branch for production server. Do not merge untested changes to it

* others - working branches for different features - must be merged to master after they are ready.

TECHNOLOGIES
========================

## Back-end

* Symfony2
* mysql

## SYMFONY BUNDLES

* stof/doctrine-extensions-bundle [https://github.com/stof/StofDoctrineExtensionsBundle] - useful entity annotations like slugable

* friendsofsymfony/jsrouting-bundle [https://github.com/FriendsOfSymfony/FOSJsRoutingBundle] - helps to generate routes in js files

* FriendsOfSymfony/FOSRestBundle [https://github.com/FriendsOfSymfony/FOSRestBundle] - This bundle provides various tools to rapidly develop RESTful API's & applications with Symfony2.

* nelmio/NelmioApiDocBundle [https://github.com/nelmio/NelmioApiDocBundle] - The NelmioApiDocBundle bundle allows you to generate a decent documentation for your APIs.

* JMSSerializerBundle

## Frontend

* Twitter Bootstrap 3
* jQuery
* angularJS
* compass
* gulp

## Gulp plugins
* gulp-ng-annotate [https://www.npmjs.com/package/gulp-ng-annotate] - Add angularjs dependency injection annotations with ng-annotate
* gulp-rigger [https://www.npmjs.com/package/gulp-rigger] - Rigger is a build time include engine for Javascript, CSS, CoffeeScript and in general any type of text file that you wish to might want to "include" other files into.
* gulp-watch [https://www.npmjs.com/package/gulp-watch] - File watcher that uses super-fast chokidar and emits vinyl objects.
* gulp-uglify [https://www.npmjs.com/package/gulp-uglify] - Minify files with UglifyJS.
* gulp-compass [https://www.npmjs.com/package/gulp-compass] - Compile Compass files
* gulp-imagemin [https://www.npmjs.com/package/gulp-imagemin] - Minify PNG, JPEG, GIF and SVG images
* imagemin-pngquant [https://www.npmjs.com/package/imagemin-pngquant] - pngquant imagemin plugin
* gulp-util [https://www.npmjs.com/package/gulp-util] - Utility functions for gulp plugins
* gulp-plumber [https://www.npmjs.com/package/gulp-plumber] - Prevent pipe breaking caused by errors from gulp plugins
* gulp-autoprefixer [https://www.npmjs.com/package/gulp-autoprefixer] - Prefix CSS
* rimraf [https://www.npmjs.com/package/rimraf] - A deep deletion module for node

Set Up
========================

### Install compass 

    $ sudo gem update --system
    $ gem install compass


### Install gulp globally 

    $ npm install --global gulp

### Install node modules 

    $ npm install

Useful commands
========================

* gulp (track changes)

* gulp clean

* gulp build

* php app/console fos:js-routing:dump (build js routes)

DEPLOYMENT INSTRUCTIONS
========================

### Clone the repo 

    $ git clone

### Install vendors & configure parameters

    $ composer install

### Change the permissions of the next directories so that the web server can write into them:

    app/cache/
    app/logs/    

> the ways to do it are described [here](http://symfony.com/doc/master/book/installation.html#configuration-and-setup) 

    $ sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs web/media web/uploads web/media
    $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs web/media web/uploads web/media

### Install assets

    $ php app/console assets:install web --symlink

    $ php app/console assetic:dump --env=prod

## Create configured databases

    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:update --force

## Load fixtures:

ORM fixtures:

    $ php app/console doctrine:fixtures:load 

## Check against requirements to run the application:

In web browser run:  
    
    /check.php
