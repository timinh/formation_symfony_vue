## Programme formation SF :

#### Pré-requis :

- Docker installé (v 26.1.1 conseillée)
  
- 1 IDE (PhpStorm ou VSCode)
  

#### Jour 1 (après-midi) :

- installation complète (**10 min**)
  
  - sous linux : cloner repo git [Formation symfony-vue](https://github.com/timinh/formation_symfony_vue.git)
- controleurs + routes + twig ( **25 min** )
  
  - créer un controleur via le maker-bundle
    
  - 1ère interface
    
  - ajouter un bootstrap pour améliorer l'interface
    
  - découpage des templates / réutilisation
    
  - afficher des informations dans les templates
    
- doctrine + entités ( **35 min** )
  
  - créer ses entités via le maker-bundle
    
  - migrations :
    
    - fichiers de migrations
      
    - création et suivi des migrations
      
  - page master -> detail
    
    - find
      
    - findBy
      
  - remplacer findBy par Mapping automatique
    
- formulaires + crud ( **20min** )
  
  - création / validation d'un formulaire via les attributs sur les entités
    
  - afficher les erreurs
    
  - personnaliser le formulaire (dans le fichier form -> fonctionnement et dans twig -> affichage)
    
  - suppression des datas + affichage des messages (route delete avec deleteById doctrine)
    
- tester avec plus de data : fixtures ( **10min** )
  
- authentification des users ( **20min** )
  
  - security
    
  - rôles / héritage des rôles
    
- gestion des droits d'accès ( **40min** )
  
  - voters
    
  - via is_granted() dans la méthode du controleur,
    
  - sur les routes (attribut isGranted)
    
- ~~( déclencher des actions avec messenger )~~
  

#### Jour 2 : Api-platform

##### Matinée :

- le serializer symfony et les groupes de serialization ( **20min**)
  
- installation d'api-platform sur symfony "light" ( **5min**)
  
  - (installer maker-bundle + profiler)
- créer un crud sur une entité doctrine ( **15min** )
  
  - types de routes (GET, POST, PUT, PATCH, DELETE)
    
  - client api (postman, insomnia, ...)
    
- ajouter des filtres et la pagination (**10min**)
  
- Installation vite bundle ( **15min** )
  
  - paramétrage pentatrion_vite bundle + config vite.config.js
    
  - ajout nodejs dans la stack (redémarrer)
    
  - ajoute js dans twig (et tester le console.log)
    
- Installation vue 3 ( **60 min** )
  
  - install vue
    
  - installation vue-router
    
  - 1ers composants
    
    - template + script + styles
      
    - ~~rappel es6:~~
      
      - ~~const, let, fonctions flechées~~
    - cycles onMounted(), beforeMount(), etc.
      
    - ref, reactive
      
- crud complet sur les projets et taches ( **60 min** )
  
  - installation pinia.
    
  - store Projects -> crud fontionnel (presque)
    
  - creation page index ( **liste des projets via le store) en ul > li** )
    
  - lien avec api-platform
    
    - ajouter axios dans le(s) store(s)

##### Après-midi :

- ajout page d'un projet (**10 min**)
  
  - routage (/{id}) + get sur api
    
  - pas d'interface propre
    
- installation unplugin-vue-router pour les autres pages (**10min**)
  
- installation quasar (**60min**)
  
  - [Layout Builder | Quasar Framework](https://quasar.dev/layout-builder/)
  - layout dans App.vue
  - mise en forme des pages déja faites
- ajouter auth par token dans symfony
  
  - cf lexik/jwt-authentication-bundle

#### Mercredi :

- créer un state provider
  
  - trouver un exemple pertinent ?
- Bundle d'envoi de mails ?
  
  - mails depuis symfony
    
  - templating de mails
    
  - creation de bundle
    
  - intégrer bundle dans l'application
    

#### A aborder ? :

- Messenger + bus
  
- Events (listener + subscriber)
  
- Commandes
  
- Workflows
  

#### Composants cool :

- Filesystem
  
- Notifier