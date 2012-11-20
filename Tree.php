<?php
class BinaryTreeByArray {
	
}
class BinaryTree {
	private $root;
	public function __construct( $root = null ) {
		$this->root = $root;
	}
	public function find( $data ) {
		$node = $this->root;
		while ( $node ) {
			if ( $node->getData() == $data ) {
				return $node;
			} elseif ( $data < $node->getData() ) {
				$node = $node->leftChild;
			} elseif ( $data > $node->getData() ) {
				$node = $node->rightChild;
			}
		}
		return false;
	}
	public function insert( $data ) {
		$node = new Node( $data );
		$curr = $this->root;
		while ( $curr ) {
			if ( $data > $curr->getData() ) {
				if ( $curr->rightChild ) {
					$curr = $curr->rightChild;
				} else {
					$curr->rightChild = $node;
					break;
				}
			} elseif ( $data < $curr->getData() ) {
				if ( $curr->leftChild ) {
					$curr = $curr->leftChild;
				} else {
					$curr->leftChild = $node;
					break;
				}
			} else {
				/* how do we treat the equal elements */
			}
		}
	}
	public function delete( $data ) {
		$curr = $this->root;
		$parent = $curr;
		while ( $curr ) {
			if ( $data < $curr->getData() ) {
				$parent = $curr;
				$curr = $curr->leftChild;
			} elseif ( $data < $curr->getData() ) {
				$parent = $curr;
				$curr = $curr->rightChild;
			} elseif ( $curr->getData == $data ) {
				/* three cases */
				if ( !$curr->leftChild && !$curr->rightChild ) {
					/* leaf node */
					if ( $curr->getData() < $parent->getData() ) { /* left side child */
						$parent->leftChild = null;
					} elseif ( $curr->getData() > $parent->getData() ) { /* right side child */
						$parent->rightChild = null;
					} else { /* the root element */
						$this->root = null;
					}
				} elseif ( !$curr->leftChild || !$curr->rightChild ) {
					/* one child */
					if ( $curr->getData() < $parent->getData() ) { /* left side child */
						$parent->leftChild = $curr->leftChild ? $curr->leftChild : $curr->rightChild;
					} elseif ( $curr->getData() > $parent->getData() ) { /* right side child */
						$parent->rightChild = $curr->leftChild ? $curr->leftChild : $curr->rightChild;
					} else { /* the root element */
						$this->root = $curr->leftChild ? $curr->leftChild : $curr->rightChild;
					}
				} else {
					/* two children */
					$successor = $curr->rightChild;
					while ( $successor ) {
						if ( $successor->leftChild ) {
							$successorParent = $successor;
							$successor = $successor->leftChild;
						} else {
							break;
						}
					}
					/* two special cases */
					
					if ( $curr->getData() < $parent->getData() ) { /* left side child */
						/*if ( $successor === $curr->rightChild ) {
							$parent->leftChild = $successor;
							$successor->leftChild = $curr->leftChild;
						} else {
							$successorParent->leftChild = $successor->rightChild;
							$successor->rightChild = $curr->rightChild;
							$parent->leftChild = $successor;
							$successor->leftChild = $curr->leftChild;
						}*/
						if ( $successor !== $curr->rightChild ) {
							$successorParent->leftChild = $successor->rightChild;
							$successor->rightChild = $curr->rightChild;
						}
						$parent->leftChild = $successor;
						$successor->leftChild = $curr->leftChild;
					} elseif ( $curr->getData() > $parent->getData() ) { /* right side child */
						/*if ( $successor === $curr->rightChild ) {
							$parent->rightChild = $successor;
							$successor->leftChild = $curr->leftChild;
						} else {
							$successorParent->leftChild = $successor->rightChild;
							$successor->rightChild = $curr->rightChild;
							$parent->rightChild = $successor;
							$successor->leftChild = $curr->leftChild;
						}*/
						if ( $successor !== $curr->rightChild ) {
							$successorParent->leftChild = $successor->rightChild;
							$successor->rightChild = $curr->rightChild;
						}
						$parent->rightChild = $successor;
						$successor->leftChild = $curr->leftChild;
					} else { /* the root element */
						/*if ( $successor === $curr->rightChild ) {
							$this->root = $successor;
						} else {
							$successorParent->leftChild = $successor->rightChild;
							$successor->rightChild = $curr->rightChild;
							$this->root = $successor;
							$successor->leftChild = $curr->leftChild;
							
						}*/
						if ( $successor !== $curr->rightChild ) {
							$successorParent->leftChild = $successor->rightChild;
							$successor->rightChild = $curr->rightChild;
						}
						$this->root = $successor;
						$successor->leftChild = $curr->leftChild;
					}
				}
			}
			
		}
	}
	private function getSuccessor( $curr ) {
		$curr = $curr->rightChild;
		while ( $curr ) {
			if ( $curr->leftChild ) {
				$curr = $curr->leftChild;
			} else {
				break;
			}
		}
		return $curr;
	}
	public function traverseInOrder( $root ) {
		if ( $root ) {
			$this->traverseInOrder( $root->leftChild );
			echo "The data for this node is : " . $root->getData();
			$this->traverseInOrder( $root->rightChild );
		}
		return ;
	}
	public function traversePreOrder( $root ) {
		if ( $root ) {
			echo "The data for this node is : " . $root->getData();
			$this->traversePreOrder( $root->leftChild );
			$this->traversePreOrder( $root->rightChild );
		}
		return ;
	}
	public function traversePostOrder( $root ) {
		if ( $root ) {
			$this->traversePostOrder( $root->leftChild );
			$this->traversePostOrder( $root->rightChild );
			echo "The data for this node is : " . $root->getData();
			echo $root->getData();
		}
		return ;
	}
	public function minimum() {
		
	}
	public function maximum() {
		
	}
}
class Node {
	public $leftChild;
	public $rightChild;
	private $data;
	public function __construct( $data = null ) {
		$this->data = $data;
		$this->leftChild = null;
		$this->rightChild = null;
	}
	public function getData() {
		return $this->data;
	}
	public function setData( $data ) {
		$this->data = $data;
	}
}