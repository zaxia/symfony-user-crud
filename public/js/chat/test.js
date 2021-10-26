$(function(){
    const socket = new WebSocket("ws://localhost:3210");
    const chat = $("#messages");

    socket.onopen = (e) => {
        chat.append(`<p>Vous vous êtes connecté à la messagerie</p>`);
    };

    socket.onclose = (e) => {
        chat.append(`<p>Vous vous êtes déconnecté de la messagerie</p>`);
    };

    socket.onmessage = (e) => {
        try {
            const message = JSON.parse(e.data);
            chat.append(`<p>${message.username}: ${message.message}</p>`);
            chat[0].scrollTop = chat[0].scrollHeight;
        } catch (e) {
            console.log("Unexpected error! https://xkcd.com/2110/")
        }
    };

    $("#chat-message").on("keyup", event => {
        if(event.keyCode==13){
            if (socket.readyState === socket.OPEN) {
                socket.send(JSON.stringify({username:$("#chat-pseudo").val(), message:event.target.value}));
                event.target.value="";
                // chat.append(`<p>${message.username}: ${message.message}</p>`);
                // chat[0].scrollTo(0, chat[0].scrollHeight);
            }
        }
    });
})