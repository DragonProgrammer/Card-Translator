<html>
<head>
<title>PHP File Upload example</title>
</head>
<body>


<?php

header('content-type: image/jpeg');
$background_image = imagecreatefromjpeg('01.jpg');  



echo get_resource_type($background_image) . "n";
$text_color = imagecolorallocate($background_image, 0,0,0); 
$font_file = 'times.TTF'; // link in a font file

$text = "sample Text";

$text_size = 10; //in points

$X_position = 20; // top left of text
$Y_position = 20; 

imagettftext($background_image, $text_size, 0, $X_position, $Y_position, $text_color ,$font_file, $text); //create image object with text

print '<input type="image" src="'.$background_image.'/>';

imagejpeg($background_image); 

imagedestroy($background_image);
?>

</body>
</html>