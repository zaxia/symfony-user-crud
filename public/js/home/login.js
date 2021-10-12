$(function(){
    $("#connect").on("click", event => {
        $("#result-login").html("");
        $("#result-password").html("");
        axios.post("/connect",{login:$("#username").val(), password:$("#password").val()}).then(function(result){
            console.log(result);
            if(result.data.data=="user_not_found"){
                $("#result-login").html("Utilisateur introuvable");
            } else if(result.data.data=="wrong_password"){
                $("#result-password").html("Mot de passe incorrect");
            } else {
                window.location.href = "/";
            }
        });
    });
})