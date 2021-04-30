<?php
include_once "config\auth.php";
include_once "config\db_connect.php";

$link = get_link();
include "shop.php";

$products_json = '{"items":[
    {"id":"10","name":"Яблоко","price":50,"discount":10},
    {"id":"20","name":"Апельсин","price":80,"discount":15},
    {"id":"30","name":"Виноград","price":120,"discount":33},
    {"id":"40","name":"Банан","price":65,"discount":0},
    {"id":"50","name":"Груша","price":90,"discount":0},
    {"id":"60","name":"Арбуз","price":100,"discount":0}
    
    ]}';

$ProductRepository = new ProductRepository;
// <table>
//   <tr>
//     <td>...</td>
//   </tr>
// </table>

$ProductRepository->load(json_decode($products_json));
echo "<h3>Список товаров</h3>";
echo "<table><tr><td>id</td><td>name</td><td>price</td><td>discount</td><td>price_with_discount</td></tr>";
foreach($ProductRepository->Products as $Product){
    echo "<tr><td>".$Product->id."</td><td>".$Product->name."</td><td>".
        $Product->price."</td><td>".$Product->discount."</td><td>".$Product->price * (1-$Product->discount/100)."</td></tr>";
}
echo "</table>";
// <td>price_with_discount</td>
$curentUser = new User(get_auth());
$basket = new Basket($curentUser);

echo "<h3>Содержимое корзины</h3>";
echo "<h5>Добавим товар</h5>";
$basket->addProduct($ProductRepository->getProductByID(30));
var_dump($basket->goods_in_basket);
echo "<h5>Добавим 2 товара</h5>";
$basket->addProduct($ProductRepository->getProductByID(10));
$basket->addProduct($ProductRepository->getProductByID(10));
var_dump($basket->goods_in_basket);
echo "<h5>Добавим товар</h5>";
$basket->addProduct($ProductRepository->getProductByID(20));
var_dump($basket->goods_in_basket);
echo "<h5>Удалим товар</h5>";
$basket->delProduct($ProductRepository->getProductByID(10));
var_dump($basket->goods_in_basket);
echo "<h3>Содержимое заказа</h3>";

$order = new Order($basket->goods_in_basket, $basket->basketOwner);
echo "<table><tr><td>id</td><td>name</td><td>price</td><td>discount</td><td>price_with_discount</td></tr>";

$sum = 0;

foreach($order->items as $Product){
    echo "<tr><td>".$Product->id."</td><td>".$Product->name."</td><td>".
        $Product->price."</td><td>".$Product->discount."</td><td>".$Product->price * (1-$Product->discount/100)."</td></tr>";
    $sum += $Product->price * (1-$Product->discount/100);
}
echo "<tr><td></td>"."<td><b>Итого со скидкой по товарам</b></td><td></td><td></td><td><b>".$sum."</b></td></tr>";
echo "<tr><td></td>"."<td><b>Итого со скидкой клиента</b></td><td></td><td></td><td><b>".$sum * (1-$order->User->user_discount/100)."</b></td></tr>";
echo "</table>";
echo "Адрес доставки: ". $order->User->delivery_address."<br><br>";


?>