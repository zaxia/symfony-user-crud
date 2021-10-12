$(function(){
    let edit_conditions = {login_ok: false};

    let checkUsername = function(element){
        axios.get("/user/checkUsername?login="+element.value).then(function(result){
            if(result.data == "unique"){
                $("#login-result").html('');
                $(element).css("background-color", "");
                $(element).css("opacity", "");
                edit_conditions.login_ok=true;
            } else {
                $("#login-result").html('Cet identifiant n\'est pas disponible');
                $(element).css("background-color", "red");
                $(element).css("opacity", "0.5");
                edit_conditions.login_ok=false;
            }
        }, function(error){
            console.log(error);
        });
    }

    $('[name="username"]').on("change", event => {
        checkUsername(event.target);
    });

    $("#user_form").on("submit", event => {
        if(!edit_conditions.login_ok)
            event.preventDefault();
    });
})