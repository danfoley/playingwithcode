<html>
<body>
<form method="post" action="encode-decode.php">
Enter int to encode: <input type="text" name="int">
<input type="submit">
</form>
<form method="post" action="encode-decode.php">
Enter hex to decode: <input type="text" name="hex">
<input type="submit">
</form>
<? 
if (isset($_POST["int"])) { 
	echo "<BR>".$_POST['int']." encoded is: ".encode($_POST["int"]);
}
?>
<? 
if (isset($_POST["hex"])) { 
	echo "<BR>".$_POST['hex']." decoded is: ".decode($_POST["hex"]);
}
?>
<?
function encode($int) {

	$int+=8192;

	// convert to binary
	$binary = decbin($int);

	// pad with leading zero to make 2 bytes
	$binary = substr("0000000000000000",0,16 - strlen($binary)) . $binary;

	// convert into two bytes
	$byte1 = substr($binary,0,8);
	$byte2 = substr($binary,-8);

	// pop off MSB btye 1 add MSB byte1
	$byte1 = substr($byte1,1).substr($byte2,0,1);
	$byte2 = "0".substr($byte2,1);

	// convert to hex
	$hex_converted = dechex(bindec($byte1.$byte2));
	$hex_converted = substr("0000",0,4 - strlen($hex_converted)) . $hex_converted;
	return $hex_converted;

}

function decode($hex) {

	// convert hex to binary
	$binary = base_convert($hex,16,2);

	// pad with leading zero to make 2 bytes
	$binary = substr("0000000000000000",0,16 - strlen($binary)) . $binary;

	// convert into two bytes
	$byte1 = substr($binary,0,8);
	$byte2 = substr($binary,-8);

	// covert byte back
	$byte2 = substr($byte1,-1).substr($byte2,1);
	$byte1 = "0".substr($byte1,0,7);

	// covert back to in
	$int = bindec($byte1.$byte2);

	$int-=8192;

	return $int;
}

?>
</body>
</html>

