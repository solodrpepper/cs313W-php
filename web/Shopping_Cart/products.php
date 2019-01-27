<?php

// create a product object
class product
{
    public $name;
    public $price;
    public $id;
    public $image_path;
    public $type;
}

$product_array = array();

$color_array = array(Red, Blue, Green, Teal);
$lightsaber_image_path_array = array("photos/red-lightsaber.png",
                                     "photos/blue-lightsaber.png",
                                     "photos/green-lightsaber",
                                     "photos/teal-lightsaber");

for ($i = 0; $i < sizeof($color_array); $i++) {
    $product_array[$i]             = new product();
    $product_array[$i]->name       = $color_array[$i] . " Lightsaber";
    $product_array[$i]->price      = 100000000;
    $product_array[$i]->id         = $i;
    $product_array[$i]->image_path = $lightsaber_image_path_array[$i];
    $product_array[$i]->type       = "lightsaber";
}

?>