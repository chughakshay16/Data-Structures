<?php

class DelimeterMatch
{
	private $stack;
	private $opening = array( '[', '(', '{' );
	private $closing = array( ']', ')', '}' );
	public function __construct() {
		$this->stack =  new Stack();
	}
	public function parse( $str ) {
		for ( $i = 0; $i < strlen( $str ); $i++ ) {
			if ( in_array( $str[$i], $this->opening ) ) {
				$this->stack->push( $str[$i] );
			} elseif ( in_array( $str[$i], $this->closing ) ) {
				$popped = $this->stack->pop();
				if ( $popped !== false && ( array_search( $popped, $this->opening ) == array_search( $str[$i], $this->closing ) ) ) {
					continue;
				} else {
					echo "Unmatched delimeter " . $str[$i];
					return;
				}
			}
		}
		return $this->stack->isEmpty() ? true : false;
	}
}

$str = $argv[1];
require_once( '/Stack.php' );
$processor = new DelimeterMatch();
var_dump( $processor->parse( $str ) );