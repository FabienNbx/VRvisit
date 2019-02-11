<?php

$dom = new DomDocument();
$dom->save('save.xml');

header('Location: accueil.php');
?>