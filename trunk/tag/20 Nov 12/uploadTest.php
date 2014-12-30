<?php

/**
 * Author: Ian Pitts
 * File: uploadTest.php
 * Purpose: vertical protoype - enters sample recipes into database and retrieves them for display
 */

include 'includes/Database.php';

$db  =  new Database();

$iList = '1.Heat oil.
2.Cook onions, garlic and meat until brown.
3.Add tomatoes, beer, coffee, tomato paste and beef broth.
4.Add spices Stir in 2 cans of kidney beans and peppers.
5.Reduce heat and simmer for 1 1/2 hours.
6.Add 2 remaining cans of kidney beans and simmer for another 30 minutes.';


$recipeNames = array('Tacos','Steak','Lasguna','Salad','Soup','Sandwich');
#INSERT RECIPE INTO DATABASE
for($i = 0;$i < 10;$i++){

    $fields = array('ID','userID','name','uploadDate','difficulty','serves','approxTime','pictureID','instructions');
    $values = array($db->newID(),$db->newID(),$recipeNames[(rand(0, count($recipeNames)-1))],date('Y-m-d H:i:s'),  rand(2, 5),rand(2, 5),rand(25,60),$db->newID(),addSlashes($iList));
    $db->insert('Recipe', $fields, $values);
}

$set = $db->select('Recipe', '*','1');

echo '<style>';
echo '.Field{
    width :80%;
    height:200px;
	border:1px solid #000000;
	}
	li{
    padding:5px;
	display:inline-block;
    border:solid black 1px;
	}
';
echo '</style>';

while($row = mysqli_fetch_assoc($set)){
    echo '<div class="Field">';
    echo '<ul>';
    echo '<li> ID '.$row['ID'].'</li>';
    echo '<li> userID '.$row['userID'].'</li>';
    echo '<li> name '.$row['name'].'</li>';
    echo '<li> uploadDate '.$row['uploadDate'].'</li>';
    echo '<li> difficulty '.$row['difficulty'].'</li>';
    echo '<li> serves '.$row['serves'].'</li>';
    echo '<li> approxTime '.$row['approxTime'].'</li>';
    echo '<li> pictureID '.$row['pictureID'].'</li>';
    echo '</ul>';
    echo '<div> <hr style="clear:both"> instructions '.stripcslashes($row['instructions']).'</div>';
    echo '</div><br>';
}
?>
