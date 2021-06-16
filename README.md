# Twig & Live Components Demo

## Setup

```
git clone git@github.com:weaverryan/live-demo.git
cd live-demo

./clone.sh
composer install
yarn install --force
yarn watch
```

Prep the SQLite database:

```
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load
```

Then start the built-in web server:

```
symfony serve -d
symfony open:local
```

Have fun!
