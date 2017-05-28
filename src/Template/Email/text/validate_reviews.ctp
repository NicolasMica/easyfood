# EasyFood
<?= "\r\n\r\n" ?>
## Refus de validation de l'avis de la commande n°<?= $order_id ?>
<?= "\r\n\r\n" ?>
Bonjour <?= $fullname ?>,
<?= "\r\n\r\n" ?>
Vous avez soumis un avis concernant la commande n°<?= $order_id ?> et le restaurant <?= $restaurant_name ?>, cependant cet avis ne respecte pas les conditions d'utilisation de notre site. Par conséquant sont ajout est reporté jusqu'à ce que vous corrigiez les erreurs.
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
