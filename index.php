<DOCTYPE html>
<html lang="en-CA">
<head>
	<title>Tic Tac Toe</title>
	<link rel="stylesheet" href="TTT.css">
</head>
<body>
<?php

$squares = $_GET['board'];
$game = new Game($squares);

echo '<h1>Tic Tac Toe</h1>';
echo '<h3>World Championship Simulator</h3>';
echo "<h4>You are 'x'</h4>";

if ($game->is_empty())
	echo 'You have the first move.';
else if ($game->winner('x'))
	echo 'You win. Lucky guesses!';
else if ($game->winner('o'))
	echo 'I win. Muahahaaa';
else if ($game->pick_move() && $game->winner('o'))
	echo 'I win. Muahahahaha';
else if ($game->is_full()) 
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
		$corners = array(0, 2, 6, 8);

		//The middle square is the most vital to success!
		if ($this->position[4] == '-') {
			$this->position[4] = 'o';
			return true;
		}

		//If an pos would cause victory, grab it.
		//If a pos could cause defeat, steal it.
		//Otherwise hold off for a corners.
		for ($pos=0; $pos<9; $pos++) {
			if ($this->position[$pos] == '-') {
				$this->position[$pos] = 'o';
				if ($this->winner('o')) {
					return true;
				} else {
					$this->position[$pos] = 'x';
					if ($this->winner('x')) {
						$this->position[$pos] = 'o';
						return true;
					} else {
						$this->position[$pos] = '-';
					}
				}
			}
		}

		//Check corners. If they're free, take them.
		foreach ($corners as $pos) {
			if ($this->position[$pos] == '-') {
				$this->position[$pos] = 'o';
				return true;
			}
		}
		
		//Check edges again and take them if they're free.
		for ($pos=1; $pos<9; $pos += 2) {
			if ($this->position[$pos] == '-') {
				$this->position[$pos] = 'o';
				return true;
			}
		}
		return false;
	}

	//Echo the game board as a table
	//to display
	function display() {
		echo '<table cols="3">';
		echo '<tr>';
		for ($pos=0; $pos<9; $pos++) {
			echo $this->show_cell($pos);
			if ($pos % 3 == 2) 
				echo '</tr><tr>';
		}
		echo '</tr>';
		echo '</table>';
	}

	//Echo the contents of each table cell, 
	//  as a <td> element.
	//If a position is a viable play, 
	//	echo it as an anchor to making that play.
	function show_cell($n) {
		$token = $this->position[$n];

		//TODO: make game state a Game property. track gameover.
		if ($token <> '-' || $this->winner('o') || $this->winner('x')) 
			return '<td class="'.$token.'">'.$token.'</td>';

		$this->newposition = $this->position;
		$this->newposition[$n] = 'x';
		$move = implode($this->newposition);
		$link = './?board='.$move;
		return '<td><a href="'.$link.'">-</a></td>';
	}

	//Determine if the given token occurs in as three-in-a-row
	// on the 3x3 game board.
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

?>
</body>
</html>