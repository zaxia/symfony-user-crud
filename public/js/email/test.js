$("#send_email").on("click", () => {
    axios.post("/email/send", $('#email_form').serialize()).then(function(result){
        console.log(result);
    }, function(error){
        console.log(error);
    });
});