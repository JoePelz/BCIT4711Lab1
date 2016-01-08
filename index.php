<DOCTYPE html>
<html lang="en-CA">
<head>
	<title>Tic Tac Toe</title>
</head>
<body>
<?php

$squares = $_GET['board'];
$game = new Game($squares);

echo '<h1>Tic Tac Toe</h1>';
echo '<h3>World Championship Simulator</h3>';
echo "<h5>You are 'x'</h5>";

if ($game->is_empty())
	echo 'You have the first move.';
else if ($game->winner('x'))
	echo 'You win. Lucky guesses!';
else if ($game->winner('o'))
	echo 'I win. Muahahaaa';
else if ($game->pick_move() && $game->winner('o'))
	echo 'I win. Muahahahaha';
else if ($game->no_moves()) 
	echo "Game over. It's a tie this time....";
else
	echo 'So far so good. Your move, if you dare...';


$game->display();

echo '<br/>';
echo '<a href="./?board=---------">New Game</a>';


// 0 1 2
// 3 4 5
// 6 7 8
class Game {
	var $position;
	var $newposition;

	//Constructor for the game object.
	//builds an array of positions out of the given string.
	function __construct($squares) {
		$this->position = str_split($squares);
	}

	//Check if the board is empty (i.e. a new-game state)
	//returns true if the board is full of '-' only
	function is_empty() {
		for ($pos=0; $pos<9; $pos++) {
			if ($this->position[$pos] <> '-')
				return false;
		}
		return true;
	}

	//Check if the board is full (i.e. no moves possible)
	//returns true if there are no '-' on the board.
	function is_full() {
		for ($pos=0; $pos<9; $pos++) {
			if ($this->position[$pos] == '-')
				return false;
		}
		return true;
	}

	//Places an 'o' on behalf of the computer.
	//
	//returns true if a token is placed. false otherwise.
	function pick_move() {
		//The middle square is the most vital to success!
		if ($this->position[4] == '-') {
			$this->position[$pos] = 'o';
			return true;
		}

		for ($pos=0; $pos<9; $pos++) {
			if ($this->position[$pos] == '-') {
				$this->position[$pos] = 'o';
				return true;
			}
		}
		return false;
	}

	function display() {
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
		$this->newposition[$n] = 'x';
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
</body>
</html>