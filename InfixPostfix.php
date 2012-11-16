<?php 
require_once( '/Stack.php' );
class InfixPostfixConv {
	private $stack;
	private $postFix;
	private $ops = array( '+', '-', '*', '/' );
	private $leftBrace = '(';
	private $rightBrace = ')';	
	public function __construct( ) {
		$this->stack = new Stack();
		$this->postFix = '';
	}
	public function convert( $infixExpression ) {
		for ( $i = 0; $i < strlen( $infixExpression ); $i++ ) {
			$char = $infixExpression[$i];
			if ( in_array( $char,$this->ops ) ) {
				if ( $this->stack->isEmpty() ) {
					//empty stack
					$this->stack->push( $char );
				} else {
					//otherwise
					$size = $this->stack->size();
					for ( $j = 0;  $j < $size; $j++ ) {
						$stackItem = $this->stack->pop();
						if ( $stackItem == $this->leftBrace ) {
							$this->stack->push( $stackItem );
							break;
						} elseif ( in_array( $stackItem, $this->ops ) ) {
							if ( ( array_search( $stackItem, $this->ops ) > 1 && array_search( $char, $this->ops ) < 2 )
								|| ( array_search( $stackItem, $this->ops ) < 2 && array_search( $char, $this->ops ) < 2 ) 
								|| ( array_search( $stackItem, $this->ops ) > 2 && array_search( $char, $this->ops ) > 2 ) )  {
								$this->postFix .= $stackItem;
							} elseif ( array_search( $stackItem, $this->ops ) < 2 && array_search( $char, $this->ops ) > 1 ) {
								$this->stack->push( $stackItem );
								break;
							}
						}
					}
					$this->stack->push( $char );
				}

			} elseif ( $char == $this->leftBrace ) {
				$this->stack->push( $char );
			} elseif ( $char == $this->rightBrace && !$this->stack->isEmpty() ) {
				$size = $this->stack->size();
				for ( $k = 0;  $k < $size; $k++ ) {
					$stackItem = $this->stack->pop();
					if ( $stackItem == $this->leftBrace ) {
						break;
					} else {
						$this->postFix .= $stackItem;
					}
				}
			}
			else {
				//prepare the post fix string
				$this->postFix .= $char;
			}
		}
		$size = $this->stack->size();
		for ( $i = 0; $i < $size; $i++ ) {
			$this->postFix .= $this->stack->pop();
		}
		return $this->postFix;
	}
	public function calculateExpression( $postfixExpr ) {
		$result = 0;
		for ( $i = 0; $i < strlen( $postfixExpr ); $i++ ) {
			$char = $postfixExpr[$i];
			if ( in_array( $char, $this->ops ) ) {
				$first = $this->stack->pop();
				$second = $this->stack->pop();
				switch ( $char ) {
					case '/':
						$result = $second / $first;
						break;
					case '*':
						$result = $second * $first;
						break;
					case '+':
						$result = $second + $first;
						break;
					case '-':
						$result = $second - $first;
						break;
					default:
						break;				
				}
				$this->stack->push( $result );
			} else {
				$this->stack->push( $char );
			}
		}
		return $this->stack->pop();
	}
}
$inFixExpr = $argv[1];
$convertor = new InfixPostfixConv();
$postfix = $convertor->convert( $inFixExpr );
echo $postfix;
$result = $convertor->calculateExpression( $postfix );
echo $result;