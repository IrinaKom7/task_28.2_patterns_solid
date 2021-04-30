<?php


class Order {

	public $items = array();
	public $User;

	function __construct($Products, $User){
		$this->User = $User;
		foreach($Products as $prod){
			$this->items[] = $prod;
		}
	}

	public function addItem( $item ) {
		$this->items[] = $item;
	} 


	public function deleteItem( $item ) {/*...*/}
	public function calculateDiscount() {/*...*/} 
}


class Product {

    private $currentOrder = null;
	public $id = -1;
	public $name = '';
	public $price = -1;
	public $discount;
	public function  __construct($id, $name, $price, $discount = 0){
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->discount = $discount;

		//echo $id ."	". $name."	". $price."<br>";
	}
		
    public function add2Basket ($item){
        if(is_null($this->currentOrder)){
			$this->currentOrder = new Order();
		}
		return $this->currentOrder->addItem($item);
    }

}


class ProductRepository {
	public $Products = array();
	public function load( $items ) {
		$this->Products = array();
		foreach($items->items as $Prod){
			$this->Products[] = new Product($Prod->id, $Prod->name, $Prod->price,  $Prod->discount );
		}

	} 

	public function getProductByID( $prodID ){
		foreach($this->Products as $Product) {
			if ($Product->id == $prodID){
				return $Product;
			}
		}
	}
	public function save( $order ) {/*...*/} 
	public function update( $order ) {/*...*/}
	public function delete( $order ) {/*...*/}
	//public Products;
}


class User {
	public $user_id = -1;
	public $login = '';
	public int $user_discount = 0;
	public $delivery_address = '';
	function __construct(int $new_user_id){
		global $link;
		$result = mysqli_query($link, "SELECT USER_ID, LOGIN, DISCOUNT, delivery_address FROM users_29m WHERE user_id='" . $new_user_id . "'");
		
		if ($result->num_rows < 1)
		{
			echo 'User with id = ' . $new_user_id . " not found<br>";
			exit;
		}
		$row = mysqli_fetch_assoc($result);

		$this->user_id = $row['USER_ID'];
		$this->login = $row['LOGIN'];
		$this->user_discount = $row['DISCOUNT'];
		$this->delivery_address = $row['delivery_address'];
		
	}
}

class Basket{
	public $goods_in_basket = array();
	public $basketOwner;
	function __construct($new_user){
		$this->basketOwner = $new_user;
	}
	public function addProduct($product, int $qty = 1) {
		$this->goods_in_basket[] = $product;
	}
	public function delProduct($product, int $qty = 1) {
		foreach($this->goods_in_basket as $prod){
			if ($product->id == $prod->id){
				$key = array_search($prod, $this->goods_in_basket);
				unset($this->goods_in_basket[$key]);
				break;
			}
		}

	}


}