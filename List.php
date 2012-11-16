<?php
require_once( '/LinkList.php' );
class SortedList {
	private $first;
	private $size;
	public function __construct() {
		$this->size = 0;
		$this->first = null;
	}
	public function insert( $element ) {
		$link = new Link( $element );
		$curr = $this->first;
		$prev = null;
		while ( $curr ) {
			$data = $curr->getData();
			if ( $element > $data ) {
				$prev = $curr;
				$curr = $curr->next;
			} elseif ( $element < $data || $element == $data ) {
				break; 
			}
		}
		$link->next = $curr;
		if ( !$prev ) {
			$this->first = $link;
		} else {
			$prev->next = $link;
		}
		$this->size++;
	}
	public function remove() {
		/* similar to normal LinkList */
		$oldFirst = $this->first;
		$this->first = isset( $oldFirst) ? $oldFirst->next : null;
		if ( $oldFirst ) {
			$oldFirst->next = null;
		}
		$this->size--;
		return $oldFirst;
	}
}