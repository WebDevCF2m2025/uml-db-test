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

### Création de la base de donnée :

```bash
php bin/console doctrine:database:create
```

### Création de la première entité :
```bash
php bin/console make:entity Recipe
# puis les champs désirés
```

2 fichiers sont créés :
- `src/Entity/Recipe.php` (propriétés + getters et setters)
- `src/Repository/RecipeRepository.php` (Manager de Recipe)

Création de la première migration :

```bash
php bin/console make:migration
```

Puis migration vers la DB :

```bash
php bin/console doctrine:migrations:migrate
```

Puis 'yes'.

La première table est créée, mais elle ne respecte pas tous les critères, nous pouvons la modifier :

```php
// src/Entity/Recipe.php
# ...
#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    # ajout du unsigned
    #[ORM\Column(options: 
    [
        'unsigned' => true
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $title = null;
    
    # champ unique
    #[ORM\Column(length: 125, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    # temps actuel à l'insertion
    #[ORM\Column(nullable: true, options:
    [
        'default' => 'CURRENT_TIMESTAMP',
    ])]
    private ?\DateTimeImmutable $dateCreated = null;
#...
```

### On régénère les setters et getters

```bash
php bin/console make:entity --regenerate
# puis enter
```

Création de la deuxième migration :

```bash
php bin/console make:migration
```

Puis migration vers la DB :

```bash
php bin/console doctrine:migrations:migrate
```

Puis 'yes'.
