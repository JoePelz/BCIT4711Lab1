<?php
$name = 'Joe';
$what = 'CST student';
$level = 4;
echo 'Hi, my name is '.$name.' and I am a level '.$level.' '.$what.'.';

$hoursworked = 10;
$rate = 12;
if ($hoursworked > 40) {
	$total = $hoursworked * $rate * 1.5;
} else {
	$total = $hoursworked * $rate;
}
echo "<br />";
echo ($total > 0) ? 'You owe me '.$total : "You're welcome";
?>
