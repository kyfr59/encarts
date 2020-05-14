Encarts
=============

**Encarts** est un plugin Wordpress qui permet l'insertion de code HTML (les encarts) dans des publications.

### Installation

  - Assurez-vous que le plugin [Custom Post Type UI](https://fr.wordpress.org/plugins/custom-post-type-ui) est installé et activé dans Wordpress.
  - Téléchargez l'archive du plugin et la dézippez là dans le dossier des plugins Wordpress.
  - Renommez le dossier "encarts-master" fraîchement dézippé en "encarts" et activez le.

### Utilisation

- Le plugin **Encarts** ajoute une entrée "encarts" dans l'espace d'administration de Wordpress.
- Vous pouvez ajouter et créer vos encarts via cette page.
- La page de gestion des encarts vous affiche le shortcode à utiliser pour ajouter un encart dans vos pages (cliquez dessus pour le coller dans votre presse-papier).
- Lorsque vous modifiez une page ou un article, une zone (en bas) vous permet d'afficher automatiquement un ou plusieurs encarts au début ou à la fin de votre article.


### Recherche parmi les pages ou articles

Il est possible de trouver les pages ou articles contenant un encart spécifique via un filtre ajouté par le plugin dans les listes d'articles ou de pages.
Ce filtre renvoi les encarts placés via un shortcode ou via les listes déroulantes de placement.
Ce même filtre permet de trouver les pages ou articles ne contenant aucun encart.


### Désactivation et suppression des encarts

Lorsqu'un encart est placé dans la corbeille, celui-ci est désactivé :

- Il n'apparait plus dans les listes déroulantes permettant le placement des encarts.
- Si il a été placé via une liste sur une page ou article, il n'apparait plus.
- Si il a été ajouté via un shortcode, celui-ci ne renvoi rien.
- La configuration n'est pas supprimée, ce qui signifie que si un encart est rétabli (sorti de la corbeille) il redevient actif dans les mêmes pages.

Lorsqu'un encart est supprimé définitivement :

- La configuration de placement (via les listes déroulantes) pour cet encart est supprimée.
- Les shortcodes concernant cet encart sont supprimés (ils sont supprimés du corps des pages et articles)


### Remarques

- Les encarts se gèrent comme des pages ou des articles, mais ne peuvent pas être publiés.
- Le plugin peut être utiisé pour ajouter du Javascript à vos pages, il faut alors utiliser l'onglet "texte" près de l'onglet "visuel" sur la page de création d'encart. Le code ci-dessous affichera par exemple une popup Javascript.


```
<script language="javascript">
  alert('du code javascript');
</script>
```

