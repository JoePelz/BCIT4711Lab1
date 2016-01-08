<?php

$squares = $_GET['board'];
$game = new Game($squares);

$game->display();

if ($game->winner('x'))
	echo 'You win. Lucky guesses!';
else if ($game->winner('o'))
	echo 'I win. Muahahaaa';
else
	echo 'No winner yet, but you are losing!';


class Game {
	var $position;
	var $newposition;

	function __construct($squares) {
		$this->position = str_split($squares);
	}

	function display() {
		echo '<h1>Tic Tac Toe</h1>';
		echo '<h3>World Championship Simulator</h3>';
		echo '<table cols="3" style="font-size:large; font-weight:bold">';
		echo '<tr>';
		for ($pos=0; $pos<9; $pos++) {
			echo $this->show_cell($pos);
			if ($pos % 3 == 2) 
				echo '</tr><tr>';
		}
		echo '</tr>';
		echo '</table>';
	}

	function show_cell($n) {
		$token = $this->position[$n];

		if ($token <> '-') 
			return '<td>'.$token.'</td>';

		$this->newposition = $this->position;
		$this->newposition[$n] = 'o';
		$move = implode($this->newposition);
		$link = './?board='.$move;
		return '<td><a href="'.$link.'">-</a></td>';
	}

	function winner($token) {
		$result = true;

		//Check columns and rows
		for($col=0; $col<3; $col++) {
			//Check columns
			$result = true;
			for($row=0; $row<3; $row++) {
				if ($this->position[3*$row+$col] != $token) {
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
				if ($this->position[3*$col+$row] != $token) {
					$result = false;
				}
			}
			if ($result == true) {
				//echo "Victory on row $col. "; //$col is intentional.
				break;
			}
		}
		//Check Diagonals
		if ($this->position[4] == $token) {
			if ($this->position[0] == $token && $this->position[8] == $token) {
				//echo "Victory on backslash. ";
				$result = true;
			} else if ($this->position[2] == $token && $this->position[6] == $token) {
				//echo "Victory on forward slash. ";
				$result = true;
			}
		}
		return $result;
	}
}


//Game Board (indices):
// 0 1 2
// 3 4 5
// 6 7 8

?>
