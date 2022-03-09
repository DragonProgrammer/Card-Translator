<html>
<body>
<?php 

$file = "page1.png";
#$place_holder = imagecreatefromfile("gilvader.png");
print '<form method=post>';


# Make it work with width dynamics. 10

$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";


# 20

$im = imagecreatefrompng($file);
#$size = min(imagesx($im), imagesy($im));
$im2 = imagecrop($im, ['x' => 407, 'y' => 0, 'width' => $width-407, 'height' => '1392']);
if ($im2 !== FALSE) {
    imagejpeg($im2, 'out.jpg');
}
#imagejpeg( $im2, NULL, 100 );

#30

$row_hieght = imagesy($im2)/2;
$column_width = imagesx($im2)/6;
#$cards_in_row = array($place_holder, $place_holder, $place_holder, $place_holder, $place_holder, $place_holder);
for($r = 0; $r< 2; $r++){
	$im3 = imagecrop($im2, ['x' => 0, 'y' => $r*$row_hieght, 'width' => imagesx($im2), 'height' => $row_hieght]);
	ob_start();
  	imagejpeg( $im3, NULL, 100 );
	  $i = ob_get_clean();
	echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>";
#40	
	print "<br><br>";
	for($c = 0; $c < 6; $c++){
		$im4 = imagecrop($im3, ['x' => $c*$column_width, 'y' => 0, 'width' => $column_width, 'height' => $row_hieght]);
	ob_start();
  	imagejpeg( $im4, NULL, 100 );
	  $i = ob_get_clean();
	print "<br> Card: $r / $c <br>";
	#echo $r 
	#print "/";
	#echo $c;
	echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>";
}
}
	

 
?>



</body>
</html>