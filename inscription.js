  function mail() {

    if (/^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/.test(document.getElementById('email').value))   {  

      check_mail.innerHTML = "Valide";
      return (true)  
    }else{   
      check_mail.innerHTML = "pas Valide";
      return (false)  ;
      }
  }

  function nom_verif() {
    if (nom.value.length < 3){
       check_nom.innerHTML= "Incomplet";
       return false;
    }
    else{ 
        check_nom.innerHTML ="Bon !";
        return true;
        }
  }

    function prenom_verif() {

    if (prenom.value.length < 3){
       check_prenom.innerHTML= "Incomplet";
       return false;
    }
    else{
        check_prenom.innerHTML ="Bon !";
        return true;
        }
  }


  function mdp() {
    if (password.value.length < 5){
         check_mdp.innerHTML= "Veuillez saisir un mot de passe plus long";
         return false;
    }
    else{
        check_mdp.innerHTML="Bien";
        return true;
        }
    }


    function verif_mdp() {
      if (password1.value != password.value ){
        check_mdp1.innerHTML = "Les mots de passe ne sont pas identiques ";
        return false;
       }
       else{
          check_mdp1.innerHTML="Identiques";
          return true;
       }
   }

   function check_all(){
    return (verif_mdp() && mdp() && prenom_verif() && nom_verif() && mail());
   }