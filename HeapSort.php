<?php
require_once( '/Heap.php' );
class HeapSort {
	private $heap;
	public function __construct( $arr ) {
		$this->heap = new Heap( $arr );
	}
	public function sort() {
		$n = $this->heap->size();
		for ( $j = $n/2 - 1; $j >= 0; $j-- ) {
			$this->heap->trickleDown( $j );
		}
		$prevSize = $this->heap->size();
		for ( $j = 0; $j < $n; $j++ ) {
			$first = $this->heap->remove();
			$this->heap->indexAt( $prevSize - $j - 1, $first, false );
		}
	}
	public function output() {
		foreach ( $this->heap->structure as $value ) {
			echo $value->getData() . "\n";
		}
	}
}

$arr = array();
$arr[] = new Node( 9 );
$arr[] = new Node( 2 );
$arr[] = new Node( 8 );
$arr[] = new Node( 1 );
$arr[] = new Node( 16 );
$arr[] = new Node( 23 ); 
$sorter = new HeapSort( $arr );
echo "Before sorting : \n";
$sorter->output();
$sorter->sort();
echo "After sorting: \n";
$sorter->output();