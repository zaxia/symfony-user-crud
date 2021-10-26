$(function(){ 
    $("#calcul_test").on("click", () => {
        axios.get("/test_calcul").then(function(result){
            console.log(result);
            alert("Le test est terminé.");
        });
    });
});