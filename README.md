# uml-db-test

```bash
cp .env .env.local
```

Pour créer la clef dans `.env.local` qui ne sera pas commité (gardez le contenu de ce fichier dans un endroit sûr)

```bash
php -r 'echo bin2hex(random_bytes(32));'
```

La mettre dans `.env.local` :

```dotenv
#...
APP_SECRET=b6fe361964380a9f1f68262b3bcd09400cd8ec6720d842d5858dc3a2f1f7a6c4
#...
```

Dans le même fichier, commentez la ligne Postgresql et décommentez la ligne MariaDB

```dotenv
#...
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/dbname?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
#...
```

Puis modifions avec les paramètres de connexion :
```dotenv
DATABASE_URL="mysql://root:@127.0.0.1:3307/uml_db_test?serverVersion=11.5.2-MariaDB&charset=utf8mb4"
```

Dans le fichier `config/packages/doctrine.yaml`, précisons qu'on veut utiliser `MariaDB`

```yaml
doctrine:
    dbal:
        # ...
    orm:
        # ...
        identity_generation_preferences:
            #Doctrine\DBAL\Platforms\PostgreSQLPlatform: identity
            Doctrine\DBAL\Platforms\MariaDBPlatform: identity
        auto_mapping: true
```


