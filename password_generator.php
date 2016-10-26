<?PHP
	function randomizePassword()
    {
    $password = "";
	$size = 12;
	$choix = array
					(
					'a', 'A', 'b', 'B',
					'c', 'C', 'd', 'D',
					'e', 'E', 'f', 'F',
					'g', 'G', 'h', 'H',
					'i', 'I', 'j', 'J',
					'k', 'K', 'l', 'L',
					'm', 'M', 'n', 'N',
					'o', 'O', 'p', 'P',
					'q', 'Q', 'r', 'R',
					's', 'S', 't', 'T',
					'u', 'U', 'v', 'V',
					'w', 'W', 'x', 'X',
					'y', 'Y', 'z', 'Z',
					'1', '2', '3', '4',
					'5', '6', '7', '8',
					'9' , '?', '!', '$',
					'@', '_', '/', '#'
					);
	
	for($i = 0; $i < $size; $i++)
	{
		$password = $password.$choix[array_rand($choix)];
	}
	
	return $password;
    }
?>
