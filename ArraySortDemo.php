<?php
require_once ( '/List.php' );
$unsortedArr = array();
$sortedArr = array();
$sortedList = new SortedList();
for ( $i = 1; $i < count( $argv ); $i++ ) {
	$unsortedArr[] = $argv[$i];
	$sortedList->insert( $argv[$i] );
}
while ( $link = $sortedList->remove() ) {
	$sortedArr[] = $link->getData();
}
var_dump( $sortedArr );

