<!DOCTYPE php>
<html>
<body>

<?php

$backgroung_image = @imagecreatefromjpeg("C:\xampp\htdocs\zoid test\Haemonculus");  
$text_color = imagecolorallocate($background_image, 0,0,0); 
$font_file = 'font.TTF'; // link in a font file

$text = "sample Text";

$text_size = 10; //in points

$X_position = 20; // top left of text
$Y_position = 20; 

$translated_image = imagettftext($background_image, $text_size, 0, $X_position, $Y_position, $font_file, $text); //create image object with text

imagejpeg($translated_image); 


imagedestroy($translated_image);
imagedestroy($background_image);

?>

</body>
</html>
 
