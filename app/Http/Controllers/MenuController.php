<?php

namespace App\Http\Controllers;

class MenuController extends Controller
{
    /**
     * Display the main menu page
     */
    public function index()
    {
        return view('menu.index');
    }

    /**
     * Get appetizers menu data
     */
    public function getAppetizers()
    {
        return [
            'title' => 'Appetizers',
            'items' => [
                ['name' => 'Spring Rolls', 'description' => 'Crispy rolls filled with vegetables and shrimp', 'price' => 4.90],
                ['name' => 'Dumplings', 'description' => 'Steamed pork and vegetable dumplings', 'price' => 5.90],
                ['name' => 'Chicken Wings', 'description' => 'Crispy wings with spicy sauce', 'price' => 6.90],
                ['name' => 'Fried Wonton', 'description' => 'Golden fried wontons with sweet and sour sauce', 'price' => 4.50],
            ]
        ];
    }

    /**
     * Get main courses menu data
     */
    public function getMainCourses()
    {
        return [
            'title' => 'Main Courses',
            'items' => [
                ['name' => 'Sweet and Sour Chicken', 'description' => 'Tender chicken in a tangy sweet and sour sauce', 'price' => 9.90],
                ['name' => 'Kung Pao Chicken', 'description' => 'Spicy chicken with peanuts and vegetables', 'price' => 10.90],
                ['name' => 'Beef with Broccoli', 'description' => 'Tender beef and fresh broccoli in oyster sauce', 'price' => 11.90],
                ['name' => 'Mapo Tofu', 'description' => 'Silky tofu in spicy sauce with ground pork', 'price' => 9.50],
                ['name' => 'Orange Chicken', 'description' => 'Crispy chicken with fresh orange flavor', 'price' => 10.50],
                ['name' => 'Shrimp with Garlic', 'description' => 'Fresh shrimp with aromatic garlic sauce', 'price' => 12.90],
            ]
        ];
    }

    /**
     * Get noodles & rice menu data
     */
    public function getNoodles()
    {
        return [
            'title' => 'Noodles & Rice',
            'items' => [
                ['name' => 'Fried Rice', 'description' => 'Aromatic fried rice with egg and vegetables', 'price' => 7.90],
                ['name' => 'Chow Mein', 'description' => 'Crispy noodles with stir-fried vegetables', 'price' => 8.00],
                ['name' => 'Lo Mein', 'description' => 'Soft noodles in savory sauce with protein', 'price' => 8.50],
                ['name' => 'Rice Noodles', 'description' => 'Thin rice noodles with classic stir-fry', 'price' => 7.50],
                ['name' => 'Chicken Fried Rice', 'description' => 'Fried rice loaded with chicken and vegetables', 'price' => 8.90],
                ['name' => 'Shrimp Pad Thai', 'description' => 'Thai-style noodles with shrimp and peanuts', 'price' => 9.50],
            ]
        ];
    }

    /**
     * Get desserts menu data
     */
    public function getDesserts()
    {
        return [
            'title' => 'Desserts',
            'items' => [
                ['name' => 'Mango Pudding', 'description' => 'Silky smooth mango pudding with whipped cream', 'price' => 3.50],
                ['name' => 'Lychee Sorbet', 'description' => 'Refreshing lychee sorbet served in its shell', 'price' => 3.90],
                ['name' => 'Fortune Cookies', 'description' => 'Crispy cookies with lucky messages inside', 'price' => 1.50],
                ['name' => 'Black Sesame Ball', 'description' => 'Glutinous rice ball with black sesame paste', 'price' => 2.90],
                ['name' => 'Banana Foster', 'description' => 'Caramelized bananas with ice cream', 'price' => 4.50],
                ['name' => 'Dragon Fruit Bowl', 'description' => 'Fresh dragon fruit with tropical fruits', 'price' => 3.50],
            ]
        ];
    }

    /**
     * Get beverages menu data
     */
    public function getBeverages()
    {
        return [
            'title' => 'Beverages',
            'items' => [
                ['name' => 'Green Tea', 'description' => 'Freshly brewed Chinese green tea', 'price' => 2.50],
                ['name' => 'Jasmine Tea', 'description' => 'Fragrant jasmine flower tea', 'price' => 2.50],
                ['name' => 'Oolong Tea', 'description' => 'Premium oolong tea with rich flavor', 'price' => 3.00],
                ['name' => 'Mango Juice', 'description' => 'Fresh tropical mango juice', 'price' => 2.80],
                ['name' => 'Lychee Drink', 'description' => 'Sweet lychee juice with ice', 'price' => 2.90],
                ['name' => 'Ginger Coffee', 'description' => 'Strong coffee with spiced ginger', 'price' => 2.80],
            ]
        ];
    }
}
