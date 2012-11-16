<?php
class Stack {
	private $size;
	private $top;
	private $internal_str;
	public function __construct() {
		$this->internal_str = array();
		$this->size = 0;
		$this->top = null;
	}
	public function push( $element ) {
		$this->internal_str[] = $element;
		$this->size = count( $this->internal_str );
		$this->top = $this->internal_str[$this->size - 1];
	}
	public function pop( ) {
		if ( $this->size > 0 ) {
			$element = array_pop( $this->internal_str );
			$this->size = count( $this->internal_str );
			$this->top = $this->size > 0 ? $this->internal_str[$this->size - 1] : null;
		}
		return isset( $element ) ? $element : false;
	}
	public function peek() {
		return $this->top;
	}
	public function isEmpty() {
		return $this->size > 0 ? false : true;
	}
	public function size() {
		return count( $this->internal_str );
	}
}
class StackByLinkList {
	private $data_str;
	public function __construct() {
		$this->data_str = new LinkList();
	}
	public function push( $element ) {
		$link = new Link( $element );
		$this->data_str->insertFirst( $link );
	}
	public function pop() {
		$link = $this->data_str->deleteFirst();
		return $link->getData();
	}
	public function peek() {
		return $this->data_str->getFirst();
	}
	public function isEmpty() {
		return $this->data_str->isEmpty() ? false : true;
	}
	public function size() {
		return $this->data_str->size();
	}
}