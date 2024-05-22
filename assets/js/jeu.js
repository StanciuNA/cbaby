document.addEventListener('DOMContentLoaded', function() {
  function popup() {
      var modal = document.getElementById("popup");
      
      // Get the buttons that open the modal
      var btns = document.getElementsByClassName("joueur");
      
      // Get the <span> element that closes the modal
      var btnFermer = document.getElementById("fermer");

      for (var btn of btns) {
          var btnContent = btn.getElementsByClassName("container");
          for (var elem of btnContent) {
              elem.addEventListener("click", function(event) {
                  modal.style.display = "block";
                  let input = document.getElementsByClassName("inp_recherche_joueur")[0];
                  input.addEventListener("input", async function() {
                    let joueursEnLobby = document.getElementsByClassName("id_joueur");
                    let lstIdJoueurs = [];
                      for (var joueur of joueursEnLobby) {
                        lstIdJoueurs.push(joueur.getAttribute('data-value'));
                      }
                      try {
                        let input_value = input.value;
                        let joueurs = await chercheJoueur(lstIdJoueurs,input_value);
                        let lst_joueurs = document.getElementsByClassName("lst_joueurs")[0];
                        lst_joueurs.innerHTML = '';
                        if (input_value.length != 0 && joueurs.length != 0){
                            for (joueur of joueurs){
                                const div = document.createElement('div');
                                div.classList.add('inv_joureur');

                                const span = document.createElement('span');
                                span.classList.add('inv_nom');
                                span.textContent = joueur.pseudo;

                                const button = document.createElement('button');
                                button.type = 'button';
                                button.classList.add('btn', 'btn-outline-success');
                                button.textContent = 'Inviter';

                                div.appendChild(span);
                                div.appendChild(button);
                                lst_joueurs.appendChild(div);
                            }
                        }
                        else{
                            const div = document.createElement('div');
                            div.classList.add('inv_joureur');
                            const span = document.createElement('span');
                            span.classList.add('inv_nom');
                            span.textContent = "Aucun joueur trouvée";
                            div.appendChild(span);
                            lst_joueurs.appendChild(div);
                        }
                      } catch (error) {
                          console.error('Error fetching players:', error);
                      }
                  });
              });
          }
      }

      // When the user clicks on <span> (x), close the modal
      btnFermer.onclick = function() {
          modal.style.display = "none";
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      };
  }

  popup();

  async function chercheJoueur(lst_joueurs,lib_joueur) {
      /**
       * @param {Array} lstJoueurs une liste de joueurs qui est déjà présentne dans le lobby.
       */
      const response = await fetch("/joueur/chercher", {
          method: "POST",
          body: JSON.stringify({
              lst_joueurs: lst_joueurs,
              lib_joueur: lib_joueur
          }),
          headers: {
              "Content-type": "application/json; charset=UTF-8"
          }
      });

      if (!response.ok) {
          throw new Error('Il y a une erreur sur le serveur');
      }

      const responseData = await response.json();
      return responseData.data;
  }
});
