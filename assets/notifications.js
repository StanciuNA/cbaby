function envoyerInvitationEquipe(){
    var select = document.getElementById("joueur_invite_select");
    var button_inviter = document.getElementById("inviter");
    button_inviter.addEventListener("click",function(){
        id_joueur = select.value;
        fetch("/inviter", {
            method: "POST",
            body: JSON.stringify({
                utilisateur_id: id_joueur,
                type: "invit_match",
            }),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Assuming response is JSON
            })
            .then(responseData => {
                // Handle the response from the Symfony controller
                alert(responseData.data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
}

envoyerInvitationEquipe();