<?php

/**
 * Author: Kay Choi
 * File: categories.php
 * Purpose: lists the recipe categories, the associated sub-categories, and what the category list in the left sidebar will display for each category label
 */

function getCat() {
    return array('course', 'cuisine', 'lifestyle', 'season', 'all');
}

function getSubCat() {
    return array(
        'course' => array('appetizer', 'breakfast', 'dessert', 'drink', 'lunch', 'main', 'salad', 'side'),
        'cuisine' => array('chinese', 'greek','indian', 'mexican', 'japanese', 'southern', 'thai', 'other'),
        'lifestyle' => array('bbq', 'healthy', 'easy', 'vegetarian'),
        'season' => array('spring', 'summer', 'fall', 'winter'),
        'all' => array()
    );
}

function getCatLabels() {
    return array(
        'course' => 'Courses',
        'cuisine' => 'Cuisine',
        'lifestyle' => 'Lifestyles',
        'season' => 'Seasonal',
        'appetizer' => 'Appetizers',
        'breakfast' => 'Breakfast',
        'dessert' => 'Desserts',
        'drink' => 'Drinks',
        'lunch' => 'Lunch',
        'main' => 'Main Dishes',
        'salad' => 'Salads',
        'side' => 'Side Dishes',
        'chinese' => 'Chinese',
        'greek'=> 'Greek',
        'indian' => 'Indian',
        'mexican' => 'Mexican',
        'japanese' => 'Japanese',
        'southern' => 'Southern',
        'thai' => 'Thai',
        'other' => 'Other',
        'bbq' => 'BBQ and Grill',
        'healthy' => 'Healthy',
        'easy' => "Quick'n'Easy",
        'vegetarian' => 'Vegetarian',
        'spring' => 'Spring',
        'summer' => 'Summer',
        'fall' => 'Fall',
        'winter' => 'Winter',
        'all' => 'All'
    );
}
?>
