<?php
class Node {
	private $data;
	public function __construct( $data = null ) {
		$this->data = $data;
	}
	public function getData() {
		return $this->data;
	}
	public function setData( $data ) {
		$this->data = $data;
	}
}
class Heap {
	private $structure;
	private $size;
	public function __construct() {
		$this->structure = array();
		$this->size = 0;
	}
	public function insert( $key ) {
		$node = new Node( $key );
		$this->structure[$this->size] = $node;
		$this->trickleUp( $this->size++ );
	}
	private function trickleUp( $index ) {
		$curr = $index;
		$parent = $index != 0 ? ( $index - 1 )/2 : $index;
		while ( $this->structure[$curr] > $this->structure[$parent] ) {
			/* swap */
			$temp = $this->structure[$parent];
			$this->structure[$parent] = $this->structure[$curr];
			$this->structure[$curr] = $temp;
			$curr = $parent;
			$parent = ( $curr - 1 )/2;
		}
	}
	/**
	 * Here the assumption is that the internal structure is not empty
	 * @param Int $index : index of the element which needs to trickle down
	 */
	private function trickleDown( $index ) {
		$curr = isset( $this->structure[$index] ) ? $this->structure[$index] : null;
		while ( $curr ) {
			$left = 2 * $index + 1;
			$right = 2 * $index + 2;
			$leftChild = isset( $this->structure[$left] ) ? $this->structure[$left] : null;
			$rightChild = isset( $this->structure[$right] ) ? $this->structure[$right] : null;
			if ( $leftChild && $rightChild ) {
				if ( $curr->getData() > $leftChild->getData()
						&& $curr->getData() > $rightChild->getData() ) {
					return ;
					
				} elseif ( $leftChild->getData() > $rightChild->getData() ) {
					/*$temp = $leftChild;
					$this->structure[$left] = $curr;
					$index = $left;*/
					//$this->swap( $curr, $leftChild, $left, $index );
					$this->swap( $index, $left );
				} else {
					/*$temp = $rightChild;
					$this->structure[$right] = $curr;
					$index = $right;*/
					//$this->swap( $curr, $rightChild, $right, $index );
					$this->swap( $index, $right );
				}
				//$curr = $temp;
			} elseif ( $leftChild && $leftChild->getData() > $curr->getData() ) {
				/*$temp = $leftChild;
				$this->structure[$left] = $curr;
				$curr = $temp;
				$index = $left;*/
				//$this->swap( $curr, $leftChild, $left, $index );
				$this->swap( $index, $left );
			} elseif ( $rightChild && $rightChild->getData() > $curr->getData() ) {
				/*$temp = $rightChild;
				$this->structure[$right] = $curr;
				$curr = $temp;
				$index = $right;*/
				//$this->swap( $curr, $rightChild, $right, $index );
				$this->swap( $index, $right );
			}
		}
	}
	/*private function swap( $curr, $child, $childIndex, &$index ) {
		$temp = $child;
		$this->structure[$childIndex] = $curr;
		$curr = $temp;
		$index = $childIndex;
	}*/
	private function swap( &$index, $childIndex ) {
		$temp = $this->structure[$childIndex];
		$this->structure[$childIndex] = $this->structure[$index];
		$this->structure[$index] = $temp;
		$index = $childIndex;
		
	}
	public function remove() {
		$first = array_shift( $this->structure );
		if ( count( $this->structure ) > 1 ) {
			$last = array_pop( $this->structure );
			array_unshift( $this->structure , $last );
			/*if ( count( $this->structure ) > 1 ) {
				$this->trickleDown( 0 );
			}*/
			$this->trickleDown( 0 );
		}
		$this->size = count( $this->structure );
		return $first;
	}
	public function change( $index, $newKey ) {
		$oldValue = $this->structure[$index];
		$this->structure[$index] = $newKey;
		if ( $oldValue < $newKey ) {
			$this->trickleUp( $index );
		} else {
			$this->trickleDown( $index );
		}
	}
}
class TreeHeap {
	
}