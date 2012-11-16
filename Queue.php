<?php
class Queue {
	private $head;
	private $tail;
	private $structure;
	public function __construct() {
		$this->head = null;
		$this->tail = null;
		$this->structure = array();
	}
	public function insert( $element ) {
		$this->structure[] = $element;
		$tailIndex = count( $this->structure ) - 1;
		$this->tail = $this->structure[$tailIndex];
		$this->head = $this->structure[0];
	}
	public function remove() {
		$element = array_shift( $this->structure );
		$this->head = $this->structure[0];
		$tailIndex = count( $this->structure ) - 1;
		$this->tail = $this->structure[$tailIndex];
		return $element;
	}
	public function peek() {
		return $this->head;
	}
	public function isEmpty() {
		return count( $this->structure ) ? true : false;
	}
	public function size() {
		return count( $this->structure );
	}
}
class QueueByLinkList {
	private $data_str;
	public function __construct() {
		$this->data_str = new DoubleEndedLinkList();
	}
	public function insert( $element ) {
		$link = new Link( $element );
		return $this->data_str->insertLast( $link );
	}
	public function remove() {
		return $this->data_str->deleteFirst();
	}
	public function peek() {
		return $this->data_str->getFirst();
	}
	public function isEmpty() {
		return $this->data_str->isEmpty();
	}
	public function size() {
		return $this->data_str->size();
	}
}