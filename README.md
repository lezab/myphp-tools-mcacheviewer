# MCacheViewer

> [!WARNING]
> **Cet outil fait partie de l'écosystème MyLib et est conçu pour fonctionner en complément de la classe MCache.**


## Présentation
MCacheViewer est un outil en ligne de commande qui permet de visualiser et d'inspecter le contenu des fichiers de cache créés par la classe MCache de la librairie mlib. Cet outil est particulièrement utile pour le débogage et l'analyse des données mises en cache.

## Installation

mcacheviewer se présente comme ceci :

		- mcacheview		<-- fichier bash
		- mcacheviewer/
			- mcacheview.php

1. Copiez le tout dans un répertoire de votre choix (par exemple `/usr/local/bin/`)
2. Rendez le script exécutable :
   ```bash
   chmod +x /chemin/vers/mcacheviewer/mcacheview
   ```
3. Si le répertoire n'est pas dans votre PATH, ajoutez-le ou utilisez le chemin complet


## Utilisation

```bash
mcacheview -f <fichier_cache>
```


