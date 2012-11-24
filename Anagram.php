<?php
class Anagram {
	public function doAnagram( $word ) {
		for( $i = 0; $i < strlen( $word ); $i++ ) {
			$wordArray[] = $word[$i];
		}
		if ( count( $wordArray ) == 1 ) {
			return $wordArray;
		}
		$combinations = $this->rotate( $wordArray );
		foreach ( $combinations as $combo ) {
			$left = array_splice( $combo, 0, 1 );
			$left = implode( '', $left );
			$anagrams = $this->doAnagram( implode( '', $combo ) );
			foreach ( $anagrams as $anagram ) {
				$temps[] = $left . $anagram;
			}
		}
		return $temps;
	}
	private function rotate( $wordArray ) {
		$i = count( $wordArray );
		$combinations = array();
		while ( $i > 0 ) {
			$first = array_shift( $wordArray );
			array_push( $wordArray, $first );
			$combinations[] = $wordArray;
			$i--;
		}
		return $combinations;
	}
}