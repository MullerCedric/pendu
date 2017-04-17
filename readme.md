# Le pendu - commencer à utiliser une base de données

La mécanique du jeu n’est plus fondamentalement changée. Les sessions sont toujours utilisées. Elles sont l’outil dont nous avions besoin. 

À présent, nous pouvons aussi améliorer la manière de récupérer le mot à deviner. Jusqu’ici, les mots provenaient d’un fichier. Ce n’est pas une mauvaise méthode, mais nous pouvons améliorer la manière de faire en utilisant une base de données. Ce faisant, nous pouvons même demander au SGBD de tirer un mot au hasard pour nous. Avec un fichier, nous devions récupérer la liste complète des mots du fichier et en choisir un au hasard avec PHP. La liste complète des mots était donc chargée dans la mémoire du serveur.

L’utilisation d’une base de données est aussi l’occasion d’ajouter une journalisation des parties jouées. Cela permettra notamment d’afficher à un joueur des statistiques de jeu (nombre de parties jouées et nombre de parties gagnées). 