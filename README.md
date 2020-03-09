# Simple API avec le composant Serializer de Symfony

## Création

`composer create-project symfony/skeleton ynov-b2-api-cars`

## Dépendances

| Package | Description | Option |
|---|---|---|
|symfony/orm-pack|L'ORM Doctrine||
|symfony/maker-bundle|Le maker pour faire des entités, contrôleurs, etc...|`--dev`|
|doctrine/doctrine-fixtures-bundle|Pour permettre la création de données de tests|`--dev`|
|fzaninotto/faker|Pour simuler des données dans nos fixtures|`--dev`|
|pelmered/fake-car|Travaille avec Faker, simule des données concernant des voitures|`--dev`|
|symfony/serializer-pack|Nous permettra de sérialiser/désérialiser des données (les passer d'objet PHP à un type linéarisé, et vice versa)||
