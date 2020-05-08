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

### Remarques

- Les encarts se gèrent comme des pages ou des articles, mais ne peuvent pas être publiés.
- Le plugin peut être utiisé pour ajouter du Javascript à vos pages, il faut alors utiliser l'onglet "texte" près de l'onglet "visuel" sur la page de création d'encart. Le code ci-dessous affichera par exemple une popup Javascript.


```
<script language="javascript">
  alert('du code javascript');
</script>
```

