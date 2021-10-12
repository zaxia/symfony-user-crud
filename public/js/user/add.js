$(function(){
    let add_conditions = {login_ok: false, password_ok: false, confirm_ok: false};

    let checkUsername = function(element){
        axios.get("/user/checkUsername?login="+element.value).then(function(result){
            if(result.data == "unique"){
                $("#login-result").html('');
                $(element).css("background-color", "");
                $(element).css("opacity", "");
                add_conditions.login_ok=true;
            } else {
                $("#login-result").html('Cet identifiant n\'est pas disponible');
                $(element).css("background-color", "red");
                $(element).css("opacity", "0.5");
                add_conditions.login_ok=false;
            }
        }, function(error){
            console.log(error);
        });
    }

    let checkConfirm = function(element){
        if($(element).val()!=$("#password").val()){
            $(element).css("background-color", "red");
            $(element).css("opacity", "0.5");
            add_conditions.confirm_ok=false;
        } else {
            $(element).css("background-color", "");
            $(element).css("opacity", "");
            add_conditions.confirm_ok=true;
        }
    }

    let checkPassword = function(element){
        let value = element.value;
        if(value!="" && (value.match(/([a-zA-Z])/) && value.match(/([0-9])/) && value.match(/([!,%,&,@@,#,$,^,*,?,_,~])/))){
            $("#result-password").html('');
            $(element).css("background-color", "");
            $(element).css("opacity", "");
            add_conditions.password_ok=true;
        } else {
            $("#result-password").html('Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial');
            $(element).css("background-color", "red");
            $(element).css("opacity", "0.5");
            add_conditions.password_ok=false;
        }
        checkConfirm($("#confirm")[0]);
    }

    $('[name="username"]').on("change", event => {
        checkUsername(event.target);
    });

    $('[name="password"]').on("change", event => {
        checkPassword(event.target);
    });

    $('[name="confirm"]').on("change", event => {
        checkConfirm(event.target);
    });

    $("#user_form").on("submit", event => {
        if(!add_conditions.login_ok || !add_conditions.password_ok || !add_conditions.confirm_ok)
            event.preventDefault();
    });
})