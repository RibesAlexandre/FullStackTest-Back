<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://www.optidigital.com/wp-content/uploads/2020/02/negative-blue2-1.png" width="400" alt="Opti Digital Logo"></a></p>



## A propos du test

Le test a été réalisé sous Laravel 10 et TailwindCSS 3. Il reprend les principales fonctionnalités détaillées dans les consignes.

## Processus d'installation

Pour lancer le projet, il suffit de télécharger l'archive et de lancer les commandes suivantes :

```
composer install
```

Copier le contenu du fichier .env.example vers un nouveau fichier .env, et remplacer les champs suivants :

````
APP_NAME="Opti Digital"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://optidigitalapi.test
APP_SERVICE=optidigitalapi.test

...

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=optidigitalapi
DB_USERNAME=sail
DB_PASSWORD=password
````

Il faudra également rajouter la clé suivante pour OpenExchangeApi à la fin du fichier :

```
OPENEXCHANGE_APP_ID={CLE_API}
```

Une fois le fichier .env configuré, il suffit de lancer les commande suivante :

```
./vendor/bin/sail up -d
./vendor/bin/sail yarn
./vendor/bin/sail yarn build
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

Vous pouvez désormais vous rendre sur l'adresse suivante pour accéder à l'application : https://optidigitalapi.test
