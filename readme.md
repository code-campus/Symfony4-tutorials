# Création d'un projet Symfony 4
> ### Objectifs :
> Savoir créer un nouveau projet Symfony 4 avec le gestionaire Composer
> ### Notes :
> Dans ce cours, le terme **my-project** réprésente le nom du projet. Remplacez ce terme par le nom de votre projet.




# Création d'un projet 

Vous pouvez créer votre projet Symfony de deux façons :

## Pour une architecture basique

```bash
composer create-project symfony/website-skeleton my-project
```

Le gestionnaire **Composer** prépare votre nouveau projet Symfony dans un répertoire `my-project`.  
Se projet sera basé sur l'architecture `symfony/website-skeleton`.


## Pour une architecture minimaliste

```bash
composer create-project symfony/skeleton my-project
```

Le gestionnaire **Composer** prépare votre nouveau projet Symfony dans un répertoire `my-project`.  
Se projet sera basé sur l'architecture `symfony/skeleton`.

L'architecture minimaliste de Symfony est plus adapté pour des projets orienté WebService.




# Se rendre dans le répertoire du projet

Pensez maintenant à pointer votre Terminal dans le répertoire de votre nouveau projet pour pouvoir travailler.

```bash
cd my-project
```