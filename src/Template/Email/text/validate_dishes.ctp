# EasyFood
<?= "\r\n\r\n" ?>
## Refus de validation du plat <?=  $dish_name ?>
<?= "\r\n\r\n" ?>
Bonjour <?= $fullname ?>,
<?= "\r\n\r\n" ?>
Vous avez soumis l'ajout du plat <?= $dish_name ?> de votre restaurant <?= $restaurant_name ?>, cependant ce plat ne respecte pas les conditions d'utilisation de notre site. Par conséquant sont ajout est reporté jusqu'à ce que vous corrigiez les erreurs.
<?= "\r\n" ?>
Ci-dessous une explication des erreurs à corriger:
<?= "\r\n\r\n" ?>
<?= $reason ?>
<?= "\r\n\r\n" ?>
Vous pouvez corriger les erreurs dès maintenant, il vous suffit de copier/coller ce lien dans votre navigateur:
<?= "\r\n" ?>
<?= $link ?>
<?= "\r\n\r\n" ?>
Cordialement, EasyFood.
