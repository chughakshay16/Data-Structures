<?php
require_once '/List.php';
function radixSort( $unsortedArray ) {
	$digindex = 1;
	$max = maxDigits( $unsortedArray );
	while ( $digindex <= $max ) {
		foreach ( $unsortedArray as $index => $value ) {
			$sortedArray[getDigit( $digindex, $value )][] = $value;
		}
		$list = new SortedList();
		foreach ( array_keys( $sortedArray ) as $key ) {
			$list->insert( $key );
		}
		/* flatten out the array */
		$unsortedArray = array();
		while ( $link = $list->remove() ) {
			if ( is_array( $sortedArray[$link->getData()] ) ) {
				foreach ( $sortedArray[$link->getData()]  as $subvalue ) {
					$unsortedArray[] = $subvalue;
				}
			} else {
				$unsortedArray[] = $sortedArray[$link->getData()];
			}
		}
		$digindex = $digindex + 1;
		$sortedArray = array();
	}
	return $unsortedArray;
}
function maxDigits( $arr ) {
	$max = 0;
	foreach ( $arr as $index => $value ) {
		if ( strlen( $value ) > $max ) {
			$max = strlen( $value );
		}
	}
	return $max;
}
function getDigit( $index, $value ) {
	$numberString = "" . $value;
	$digitString = isset( $numberString[strlen( $numberString )- $index] ) ? $numberString[strlen( $numberString )- $index] : 0;
	return intval( $digitString ); 
}