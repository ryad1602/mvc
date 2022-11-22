<h2> Bienvenue dans votre école</h2>
<h4>M./MM.
<?= $_SESSION['nom']." ".$_SESSION['prenom']. 
"<br> Vous avez le rôle :".$_SESSION['role'] ?>
</h4>
<h4>
	<<?php 
	$unControleur->setTable ("classe");
	$nbClasses = $unControleur->count()['nb'];

	echo "<br/>Le nombre de classes est de: ".$nbClasses;

	$unControleur->setTable ("etudiant");
	$nbEtudiants = $unControleur->count()['nb'];

	echo "<br/>Le nombre d'etudiants est de: ".$nbEtudiants;

	$unControleur->setTable ("professeur");
	$nbProfesseurs = $unControleur->count()['nb'];

	echo "<br/>Le nombre de professeurs est de: ".$nbProfesseurs;

	 ?>
</h4>
<img src="images/iris.png" height="400" width="600">

<br/>
<a href="https://ecoleiris.fr">Veuillez nous rejoindre<a/>