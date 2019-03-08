<?php 

echo password_hash('secret', PASSWORD_BCYRPT, array('cost' => 12)); // Third parameter creates an associative array and the 10 makes function give a new hash slower according to the 10 - denotes the algorithm cost

?>