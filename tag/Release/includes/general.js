/**Task: checks the input of the map search form. If there is no input, a message
 *   that the form needs to be filled is displayed, and the function returns
 *   FALSE. Otherwise, the function returns TRUE.
 * @param form the map search form
 * @return TRUE if the input is not the empty string
 */
function mapSearchCheck(form) {
    if (form.location.value == "") {
        alert("Please enter your location.");
        form.location.focus();

        return false;
    }
    else
        return true;
}

/**Task: adds a new ingredient input row to the recipe upload form.
 */
function add() {

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

/**Task: removes the last ingredient input row from the recipe upload form. Any
 *   existing data in the removed row is discarded.
 */
function remove() {

    var counter = $('#counter').val();
    if (counter > 1) {
        var ingredient = '#ingredient_'+ counter;
        $(ingredient).remove();
        counter--;
        $('#counter').val(counter);
    }
}

/**Task: adds a new rating to the database, and updates the top ten rated recipes
 *   panel in the right sidebar.
 * @param rating the rating of the recipe
 * @param recipeID the ID number of the recipe being rated
 * @param userID the ID number of the user
 */
function rate(rating,recipeID,userID) {
    //todo: needs to update the average recipe rating in the main panel
    $.ajax({
        type:'POST',
        url:"includes/Actions.php?ops=RATE",
        data: {RID: recipeID, UID: userID, rating: rating},
        success: function(data){
            data = parseFloat(data);
            var output = "                    <fieldset id='avgRating' class='rating' style='float:left;'>";
            output += "                        <legend>Current rating</legend>\n<!--";

            var count = 1;

            for (; count <= Math.floor(data); count++)
                output += "                        --><img id='star' src='starbright.png' alt='" + count + " star' /><!--\n";

            var diff = count - data;
            if (diff >= 0.25 && diff < 0.75) {
                output += "                        --><img id='star' src='starbrightleft.png' style='width:10px;' alt='" + diff + " star' /><!--\n";
                output += "                        --><img id='star' src='stargrayright.png' style='width:10px;' alt='" + diff + " star' /><!--\n";
                count++;
            }

            for (; count <= 5 ; count++)
                output += "                        --><img id='star' src='stargray.png' alt='" + count + " star' /><!--\n";

            output += "                    --><br>" + data + " stars</fieldset>\n";
            $("#avgRating").replaceWith(output);
            
            $("#top10").load(location.href+" #top10>*",'');
            
            var output2 = "<br><span id='userRate' style='position: absolute;top: 43px;left: 0;text-align: center;width: 145px;'>" + rating + " stars</span>";
            $("#userRate").replaceWith(output2);
        }
    });

}

/**Task: adds a recipe to a user's favorite recipes, and updates the favorite
 *   recipe list in the left sidebar.
 */
function addFavorite() {

     var recipeID = $('#RIDfav').val();
     var userID = $('#UIDfav').val();

     $.ajax({
        type:'POST',
        url:"includes/Actions.php?ops=ADDFAV",
        data: {RID: recipeID, UID: userID},
        success: function(data){
            alert(data);
            $("#favorites").load(location.href+" #favorites>*",'');
        }
    });

}

/**Task: removes a recipe from a user's favorite recipes, and updates the favorite
 *   recipe lists in the left sidebar and main panel.
 */
function deleteFavorite() {

     var recipeID = $('#deleteID').val();
     var userID = $('#UID').val();

     $.ajax({
        type:'POST',
        url:"includes/Actions.php?ops=DELETEFAV",
        data: {RID: recipeID, UID: userID},
        success: function(data){
            if(data != '')
                alert(data);
            $("#favorites").load(location.href+" #favorites>*",'');
            $("#browseBody").load(location.href+" #browseBody>*",'');
        }
    });

}

/**Task: updates the ingredient list amounts based on the number of servings
 *   specified by the user.
 */
function updateServings() {
    var newServe = $('#newServe').val();
    var recipeID = $('#RID').val();
    var serves = $('#serves').val();

    if (isNaN(newServe) || newServe < 1) {
        alert("Please enter a valid number.");
        $("#newServe").focus();
        return false;
    }
    else {

        $.ajax({
            type:'POST',
            url:"includes/Actions.php?ops=setserving",
            data: {RID: recipeID, serves: serves, newServe: newServe},
            success: function(data){
                $("#ingList").replaceWith(data);
            }
        });
        return true;
    }
}