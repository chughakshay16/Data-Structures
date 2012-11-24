<?php
class BinarySearch {
	private $int_arr;
	private $key;
	public function __construct( $arr, $key ) {
		$this->int_arr = $arr;
		$this->key = $key;
	}
	public function search() {
		$left = 0;
		$right = count( $this->int_arr ) - 1;
		while ( $left <= $right ) {
			$curr = intval( ( $left + $right )/2 );
			if ( $this->key == $this->int_arr[$curr] ) {
				return $curr;
			} elseif ( $this->key > $this->int_arr[$curr] ) {
				$left = $curr + 1;
			} else {
				$right = $curr - 1;
			}
		}
		return false;
	}
	public function recursiveSearch( $left, $right ) {
		if ( $left > $right ) {
			return false;
		}
		$curr = intval( ( $left + $right )/2 );
		if ( $this->key == $this->int_arr[$curr] ) {
			return $curr;
		} elseif ( $this->key > $this->int_arr[$curr] ) {
			$left = $curr + 1;
		} else {
			$right = $curr - 1;
		}
		return $this->recursiveSearch( $left, $right );
	}
}