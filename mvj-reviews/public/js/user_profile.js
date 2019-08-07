var window = window || {},
  document = document || {},
  console = console || {},
  User = User || {};

User.startProfile= function(){
     window.addEventListener("DOMContentLoaded", function(){
       console.log('User profile iniciado');
       User.updateInputs();
       User.startButtons();
     });
}

//actualiza cada input que se enviara en el form cada vez que se edita su div .editable
User.updateInputs = function(){
  let editables = document.querySelectorAll('.field .editable');
  editables.forEach(function(e){
      //para cada DIV editable
      e.addEventListener("keyup",function(){
          let input = document.querySelector('input[name="'+e.dataset.input+'"]'); //obtengo su input
          input.value = e.textContent; //actualizo valor.
          console.log('ahora el input '+e.dataset.input+' vale: '+ e.textContent);
      });
  });
}


//Carga el funcionamiento de cada boton de la pagina.
User.startButtons = function(){
  //funcionalidad boton EDITAR PERFIL
  let btnEditProfile = document.querySelector('.EditProfile');
  btnEditProfile.addEventListener("click",function(){
      User.saveOldData();
      User.convertProfileDataToEditable();
  })

  //funcionalidad boton CANCELAR

}

//GUARDA temporalmente los datos que tenian los campos antes de ser modificados
//por si presiona CANCELAR.
User.saveOldData = function(){

}

User.convertProfileDataToEditable = function(){
    // convierte en editables los campos (labels)
    let editables = document.querySelectorAll('.field .editable');
    editables.forEach(function(e){
      e.setAttribute('contentEditable',true);
    });

    //hace visible editable del avatar
    let avatar = document.querySelector('.editable.avatar');
    if (avatar.classList.contains('no-visible')){
      avatar.classList.remove('no-visible');
    };

    //hace visibles los botones de GUARDAR y CANCELAR
    let btnOptions = document.querySelectorAll('.edit-options .option');
    btnOptions.forEach(function(btn){
      if (btn.classList.contains('no-visible')){
        btn.classList.remove('no-visible');
      }
    });
}// fin convertProfileDataToEditable
