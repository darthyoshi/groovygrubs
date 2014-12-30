
/**Task: checks the input of the map search form. If there is no input, a message
 *   that the form needs to be filled is displayed, and the function returns
 *   FALSE. Otherwise, the function returns TRUE.
 * @param form the map search form
 * @return TRUE if the input is not the empty string
 */
function mapSearchCheck(form) {
    if(form.location.value == "") {
        alert("Please enter your location.");
        form.location.focus();

        return false;
    }
    else
        return true;
}

function add(){

   var counter = $('#counter').val();
   counter = (+counter) + 1;
   var ingredient = '<div id="ingredient_'+counter+'">';
   ingredient += '<input type="text" name="ingredient_'+counter+'" id="recipe-ingredients" value=""/>';
   ingredient += '<input type="text" name="ingredientQuantity_'+counter+'" id="recipe-equipment-amount" style="position:absolute; left:160px;" value=""/>';
   ingredient += '<select name="ingredientUnit_'+counter+'" style="position:absolute; left:320px;">';
   ingredient += '<option selected="selected">Select one</option>';
   ingredient += '<option>Unit</option>';
   ingredient += '<option>Tablespoon</option>';
   ingredient += '<option>Teaspoon</option>';
   ingredient += '<option>Cup</option>';
   ingredient += '<option>Pounds(lb)</option>';
   ingredient += '<option>Ounce(oz)</option>';
   ingredient += '<option>Fluid Ounce(fl oz)</option>';
   ingredient += '<option>Pint</option>';
   ingredient += '</select></div>';
   $('#ingredients').append(ingredient);
   $('#counter').val(counter);
}

function remove(){

    var counter = $('#counter').val();
    if (counter > 1) {
        var ingredient = '#ingredient_'+ counter;
        $(ingredient).remove();
        counter--;
        $('#counter').val(counter);
    }
}

function sendRating(recipeID,userID,rating){

    $.ajax({
        type:'POST',
        url:"includes/Actions.php?ops=RATE",
        data: {RID: recipeID, UID: userID, rating: rating},
        success: function(data){
            $('#rating').val = data;
            alert(data);
        }
    });

}

function rate(recipeID,userID){
    var rating = $('#rating').val();
    sendRating(recipeID,userID,rating);

}

function addFavorite(){

     var recipeID = $('#RIDfav').val();
     var userID = $('#UIDfav').val();

     $.ajax({
        type:'POST',
        url:"includes/Actions.php?ops=ADDFAV",
        data: {RID: recipeID, UID: userID},
        success: function(data){
            alert(data);
        }
    });

}

function deleteFavorite(){

     var recipeID = $('#deleteID').val();
     var userID = $('#UID').val();

     $.ajax({
        type:'POST',
        url:"includes/Actions.php?ops=DELETEFAV",
        data: {RID: recipeID, UID: userID},
        success: function(data){
            alert(data);
        }
    });

}
