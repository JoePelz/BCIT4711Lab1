<?php

$position = $_GET['board'];
$squares = str_split($position);

if (winner('x',$squares)) echo 'You (x) win.';
else if (winner('o',$squares)) echo 'I (o) win.';
else echo 'No winner yet.';

//Game Board (indices):
// 0 1 2
// 3 4 5
// 6 7 8
function winner($token, $position) {
	$result = true;

	//Check columns and rows
	for($col=0; $col<3; $col++) {
		//Check columns
		$result = true;
		for($row=0; $row<3; $row++) {
			if ($position[3*$row+$col] != $token) {
				$result = false;
			}
		}
		if ($result == true) {
			//echo "Victory on column $col. ";
			break;
		}
		//Check rows
		$result = true;
		for($row=0; $row<3; $row++) {
			if ($position[3*$col+$row] != $token) {
				$result = false;
			}
		}
		if ($result == true) {
			//echo "Victory on row $col. "; //$col is intentional.
			break;
		}
	}
	//Check Diagonals
	if ($position[4] == $token) {
		if ($position[0] == $token && $position[8] == $token) {
			//echo "Victory on backslash. ";
			$result = true;
		} else if ($position[2] == $token && $position[6] == $token) {
			//echo "Victory on forward slash. ";
			$result = true;
		}
	}

	return $result;
}
?>
