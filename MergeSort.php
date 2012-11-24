<?php
function mergeSort( $left, $right, $arr ) {
	if ( $left == $right ) {
		return array( $arr[$left] );
	}
	$center = intval( ( $left + $right )/2 );
	$arr1 = mergeSort( $left, $center, $arr );
	$arr2 = mergeSort( $center + 1, $right, $arr );
	return sortArray( $arr1, $arr2 );
}
function sortArray( $a, $b ) {
	$c = array();
	$size = count( $a ) + count( $b );
	$new = 0;
	$aPtr = 0;
	$bPtr = 0;
	while ( $new < $size ) {
		if ( isset( $a[$aPtr] ) && isset( $b[$bPtr] ) ) {
			if ( $a[$aPtr] < $b[$bPtr] ) {
				$c[$new] = $a[$aPtr++];
			} else {
				$c[$new] = $b[$bPtr++];
			}
		} else {
			$c[$new] = isset( $b[$bPtr] ) ? $b[$bPtr++] : $a[$aPtr++];
		}
		$new++;
	}
	return $c;
	
}