<?php
class DoubleEndedLinkList {
	private $first;
	private $last;
	private $size;
	public function __construct() {
		$this->first = null;
		$this->last = null;
		$this->size = 0;
	}
	public function getFirst() {
		return $this->first;
	}
	public function getLast() {
		return $this->last;
	}
	public function size() {
		return $this->size;
	}
	public function insertFirst( $link ) {
		$oldFirst = $this->first;
		$oldLast = $this->last;
		$link->next = isset( $oldFirst) ? $oldFirst : null;
		$this->first = $link;
		$this->last = isset( $oldLast ) ? $oldLast : $this->first;
		$this->size++;
		return true;
	}
	public function insertLast( $link ) {
		if ( $this->isEmpty() ) {
			return $this->insertFirst( $link );
		} else {
			$oldLast = $this->last;
			$oldLast->next = $link;
			$link->next = null;
			$this->last = $link;
			$this->size++;
			return true;
		}
	}
	public function deleteFirst() {
		$oldFirst = $this->first;
		$oldLast = $this->last;
		$this->first = isset( $oldFirst ) ? $oldFirst->next : null;
		$this->last = ( $oldFirst === $oldLast ) ? null : $oldLast;
		$this->size--;
		$oldFirst->next = null;
		return $oldFirst;
	}
	public function isEmpty() {
		return $this->size > 0 ? true : false;
	}
}
class LinkList {
	private $first;
	private $size;
	public function __construct() {
		$this->first = null;
		$this->size = 0;
	}
	public function size() {
		return $this->size;
	}
	public function isEmpty() {
		return $this->size > 0 ? true : false;
	}
	public function insertFirst( $link ) {
		$link->next = isset( $this->first ) ? $this->first : null;
		$this->first = $link;
		$this->size++;
	}
	public function deleteFirst() {
		if ( !$this->isEmpty() ) {
			$newFirst = $this->first->next;
			$oldFirst = $this->first;
			$this->first = $newFirst;
			$oldFirst->next = null;
			$this->size--;
		}
		return isset( $oldFirst ) ? $oldFirst : null;
	}
	public function find( $key ) {
		$curr = $this->first;
		while ( $curr ) {
			$data = $curr->getData();
			if ( $data == $key ) {
				return $curr;
			}
			$curr = $curr->next;
		}
		return null;
	}
	public function insertAfter( $key ) {
		$link = $this->find( $key );
		if ( $link ) {
			$curr = $link;
			$next = $curr->next;
			$curr->next = $link;
			$link->next = $next;
			$this->size++;
			return true;
		}
		return false;
	}
	public function deleteByKey( $key ) {
		if ( !$this->isEmpty() ) {
			$next = $this->first;
			$curr = $next;
			$prev = $next;
			while ( $curr ) {
				$data = $curr->getData();
				if ( $data == $key ) {
					/* 3 cases */
					if ( $curr === $next ) {
						/* first element */
						$this->first = isset( $curr->next ) ? $curr->next : null;
						$curr->next = null;
						return $curr;
						
					} elseif ( !is_null( $next ) ) {
						/* in between */
						$prev->next = $next;
						$curr->next = null;
						return $curr;
						
					} else {
						/* last element */
						$prev->next = null;
						$curr->next = null;
						return $curr;
					}
					$this->size--;
				}
			}
			$prev = $curr;
			$curr = $curr->next;
			$next = isset( $curr ) ? $curr->next : null;
		}
		
	}
	public function getFirst() {
		return $this->first;
	}
}

class Link {
	public $next;
	private $data;
	public function __construct( $data = null ) {
		$this->data = $data;
		$this->next = null;
	}
	public function getData() {
		return $this->data;
	}
	public function setData( $data ) {
		$this->data = $data;
	}
}
class DoubleLink {
	public $next;
	public $prev;
	private $data;
	public function __construct( $data = null ) {
		$this->data = $data;
		$this->next = null;
		$this->prev = null;
	}
	public function getData() {
		return $this->data;
	}
	public function setData( $data ) {
		$this->data = $data;
	}
}
class DoublyLinkedList {
	private $first;
	private $last;
	private $size;
	public function __construct() {
		$this->first = null;
		$this->last = null;
		$this->size = 0;
	}
	public function getIterator() {
		return new ListIterator( $this->first );
	}
	public function insertFirst( $element ) {
		$link = new DoubleLink( $element );
		$oldFirst = $this->first;
		$this->first = $link;
		$link->next = $oldFirst;
		if ( $oldFirst ) {
			$oldFirst->prev = $link;
		}
		$this->last = $this->last ? $this->last : $this->first;
		$this->size++;
	}
	public function insertLast( $element ) {
		$oldLast = $this->last;
		$link = new DoubleLink( $element );
		$link->prev = $oldLast;
		if ( !$oldLast ) {
			$this->first = $link;
		} else {
			$oldLast->next = $link;
		}
		$this->last = $link;
		$this->size++;
	}
	public function insertAfter( $element, $afterLink ) {
		$curr = $this->first;
		$link = new DoubleLink( $element );
		while ( $curr ) {
			if ( $curr->getData() == $afterLink->getData() ) {
				$next = $curr->next;
				$link->next = $next;
				$link->prev = $curr;
				$curr->next = $link;
				if ( $next ) {
					$next->prev = $link;
				}
				$this->last = ( $curr === $this->last ) ? $link : $this->last;
				$this->size++;
				return true; 
			}
			$curr = $curr->next;
		}
		return false;
	}
	public function deleteFirst() {
		if ( $oldFirst = $this->first ) {
			$next = $oldFirst->next;
			$this->first = $next;
			if ( $next ) {
				$next->prev = null;
			}
			$oldFirst->next = null;
			$this->size--;
			return $oldFirst;
		}
		return false;
	}
	public function deleteLast() {
		if ( $this->size > 0 ) {
			$oldLast = $this->last;
			if ( $prev = $oldLast->prev ) {
				$prev->next = null;
			}
			$oldLast->prev = null;
			$this->last = $prev;
			return $oldLast;
		}
		return false;
	}
	public function deleteKey( $element ) {
		$curr = $this->first;
		while ( $curr ) {
			if ( $curr->getData() == $element ) {
				$prev = $curr->prev;
				$next = $curr->next;
				if ( $this->size == 1 ) {
					/* only one element */
					$this->first = null;
					$this->last = null;
				} elseif ( !$prev ) {
					/* first element */
					$this->first = $next;
					$next->prev = null;
				} elseif ( !$next ) {
					/* last element */
					$this->last = $prev;
					$prev->next = null;
				} else {
					/* any element in between */
					$prev->next = $next;
					$next->prev = $prev;
				}
				$curr->prev = null;
				$curr->next = null;
				return $curr;
			}
			$curr = $curr->next;
		}
		return false;
	}
}
class ListIterator {
	private $current;
	public function __construct( $curr = null ) {
		$this->current = $curr;
	}
	public function next() {
		return isset( $this->current ) ? $this->current->next : null;
	}
	public function prev() {
		return isset( $this->current ) ? $this->current->prev : null;
	}
	public function hasNext() {
		return isset( $this->current ) ? ( $this->current->next ? true : false ) : false;
	}
	public function hasPrevious() {
		return isset( $this->current ) ? ( $this->current->prev ? true : false ) : false;
	}
	public function getCurrent() {
		return $this->current;
	}
}