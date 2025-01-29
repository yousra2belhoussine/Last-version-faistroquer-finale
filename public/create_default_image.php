<?php

// Créer une image 200x200
$image = imagecreatetruecolor(200, 200);

// Définir les couleurs
$bg = imagecolorallocate($image, 53, 167, 155); // #35a79b
$text_color = imagecolorallocate($image, 255, 255, 255);

// Remplir le fond
imagefill($image, 0, 0, $bg);

// Ajouter du texte
$text = "Image";
$font_size = 5;
$text_box = imagettfbbox($font_size, 0, 5, $text);
$text_width = abs($text_box[4] - $text_box[0]);
$text_height = abs($text_box[5] - $text_box[1]);
$x = (200 - $text_width) / 2;
$y = (200 - $text_height) / 2;
imagestring($image, $font_size, $x, $y, $text, $text_color);

// Sauvegarder l'image
header('Content-Type: image/png');
imagepng($image, __DIR__ . '/images/default-avatar.png');
imagedestroy($image);

echo "Image créée avec succès !";
