<?php
class Tree234 {
	private $root;
	public function __construct() {
		$this->root = null;
	}
	private function split( $node, $parent ) {
		$items = $node->getItems();
		$children = $node->getChildren();
		$itemSibling = array_pop( $items );
		$itemParent = array_pop( $items );
		$node->setItems( $items );
		$rightSibling = new Node( array( $itemSibling ) );
		if ( $node === $this->root ) {
			$newParent = new Node( array( $itemParent ) );
			$newParent->setChildren( array( $node, $rightSibling ) );
			$this->root = $newParent;
		} else {
			$parent->insertItem( $itemParent );
			$parent->pushChild( $rightSibling );
		}
		$newChildren = array_splice( $children, 2 );
		$rightSibling->setChildren( $newChildren );
		$node->setChildren( $children );
		
	}
	public function find( $key ) {
		$curr = $this->root;
		$parent = null;
		while ( $curr && $curr instanceof Node ) {
			if ( $index = $curr->findItem( $key ) ) {
				return array( 'parent' => $parent,
					'curr' => $curr,
					'index' => $index
				);
			}
			$parent = $curr;
			$curr = $curr->getChild( $key );
		}
		return null;
	}
	public function insert( $key ) {
		$curr = $this->root;
		$parent = null;
		while ( $curr ) {
			/* 3 cases
			 * case 1: split
			 * case 2: move to the next child
			 * case 3: insert the item in the current node
			 */
			if ( $curr->isFull() ) {
				$this->split( $curr );
				$this->insert( $key );
				break;
			} elseif ( count( $curr->getChildren() ) ) {
				/*$child = $curr->getChild( $key );
				if ( $child instanceOf Node ) {
					$curr = $child;
				} else {
					$curr->connectChild( $key );
				}*/
				$curr = $curr->getChild( $key );
			} else {
				$curr->insertItem( $key );
				break;
			}
		}
	}
}
class DataItem {
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
class Node {
	private $parent;
	private $children;
	private $dataItems;
	const ORDER = 4;
	public function setChildren( $children ) {
		$this->children = $children;
	}
	public function pushChild( $child ) {
		$this->children[] = $child;
	}
	public function popChild() {
		return array_pop( $this->children );
	}
	public function getChildren() {
		return $this->children;
	}
	public function __construct( $dataItems = array() ) {
		$this->dataItems = $dataItems;
		$this->children = array();
	}
	public function findItem( $key ) {
		/* sorted array; do a binary search */
		foreach ( $this->dataItems as $index => $value ) {
			if ( $key == $value ) {
				return $index;
			}
		}
		
	}
	public function removeItem( $key ) {
		if ( $index = $this->findItem( $key ) ) {
			/* remove operation */
			$item = array_splice( $this->dataItems, $index, 1 );
			$this->dataItems = array_values( $this->dataItems );
			return $item;
		}
		return false;
		
	}
	/**
	 * It assumes a simple fact that we will never call this function
	 * on a completely filled $dataItem array.
	 * @param Mixed $key: Data to be inserted in the node
	 */
	public function insertItem( $key ) {
		for ( $i = 0; $i < count( $this->dataItems ); $i++ ) {
			if ( $key < $this->dataItems[$i] ) {
				$extra = array_splice( $this->dataItems, $i );
				$this->dataItems[$i] = $key;
				$this->dataItems = array_merge( $this->dataItems, $extra );
				return ;
			}
		}
		$this->dataItems[$i] = $key;
	}
	public function displayNode() {
		
	}
	public function isFull() {
		return count( $this->dataItems ) == Node::ORDER - 1;
	}
	public function getItem( $key ) {
		if ( $index =  $this->findItem( $key ) ) {
			return $this->dataItems[$index];
		}
		return null;
	}
	public function getItems() {
		return $this->dataItems;
	}
	public function setItems( $items ) {
		$this->dataItems = $items;
	}
	public function getNumItems() {
		return count( $this->dataItems );
	}
	public function isLeaf() {
		return count( $this->children ) == 0;
	}
	public function getParent() {
		return $this->parent;
	}
	/**
	 * 
	 * @param Mixed $key: The key we are searching for
	 * @return Node, null or the probable index value
	 */
	public function getChild( $key ) {
		for ( $i = 0; $i <= count( $this->dataItems ); $i++ ) {
			/*if ( $i == 0 ) {
				if ( $key < $this->dataItems[$i] ) {
					return $this->children[$i];
				}
			} elseif ( count( $this->dataItems ) == $i ) {
				if ( $key > $this->dataItems[$i - 1] ) {
					return $this->children[$i];
				}
			} else {
				if ( $key > $this->dataItems[$i - 1] && $key < $this->dataItems[$i] ) {
					return $this->children[$i];
				}
			}*/
			if ( ( $i == 0 && $key < $this->dataItems[$i] )
					|| ( count( $this->dataItems ) == $i && $key > $this->dataItems[$i - 1] )
					|| $key > $this->dataItems[$i - 1] && $key < $this->dataItems[$i] ) {
				$found = true;
				break;
			}
		}
		return isset( $found ) && $found ? ( isset( $this->children[$i] ) ? $this->children[$i] : $i ) : null;
	}
	public function connectChild( $key ) {
		for ( $i = 0; $i <= count( $this->dataItems ); $i++ ) {
			/*if ( $i == 0 ) {
				if ( $key < $this->dataItems[$i] ) {
					break;
				}
			} elseif ( count( $this->dataItems ) == $i ) {
				if ( $key > $this->dataItems[$i - 1] ) {
					break;
				}
			} else {
				if ( $key > $this->dataItems[$i - 1] && $key < $this->dataItems[$i] ) {
					break;
				}
			}*/
			if ( ( $i == 0 && $key < $this->dataItems[$i] )
					|| ( count( $this->dataItems ) == $i && $key > $this->dataItems[$i - 1] )
					|| $key > $this->dataItems[$i - 1] && $key < $this->dataItems[$i] ) {
				break;
					}
		}
		if ( isset( $this->children[$i] ) ) {
			return false;
		}
		return $this->children[$i] = new Node( array( $key ) );
	}
	public function disconnectChild() {
		for ( $i = 0; $i <= count( $this->dataItems ); $i++ ) {
			/*if ( $i == 0 ) {
			 if ( $key < $this->dataItems[$i] ) {
			break;
			}
			} elseif ( count( $this->dataItems ) == $i ) {
			if ( $key > $this->dataItems[$i - 1] ) {
			break;
			}
			} else {
			if ( $key > $this->dataItems[$i - 1] && $key < $this->dataItems[$i] ) {
			break;
			}
			}*/
			if ( ( $i == 0 && $key < $this->dataItems[$i] )
					|| ( count( $this->dataItems ) == $i && $key > $this->dataItems[$i - 1] )
					|| $key > $this->dataItems[$i - 1] && $key < $this->dataItems[$i] ) {
				break;
			}
		}
		array_splice( $this->children , $i, 1 );
		$this->children = array_values( $this->children );
	}
}