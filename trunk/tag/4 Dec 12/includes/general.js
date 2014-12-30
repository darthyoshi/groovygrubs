

function mapSearchCheck(form){
        if(form.location.value == ""){
            alert("Please enter your location.");
            form.location.focus();
            return false;
        }
        return true;
}    



