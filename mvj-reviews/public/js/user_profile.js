var window = window || {},
  document = document || {},
  console = console || {},
  User = User || {},
  Fields = Fields || {};

User.startProfile= function(){
     window.addEventListener("DOMContentLoaded", function(){
       console.log('User profile iniciado');
       User.startButtons();
     });
}


//Carga el funcionamiento de cada boton de la pagina.
User.startButtons = function(){
  //funcionalidad boton EDITAR PERFIL
  let btnEditProfile = document.querySelector('.EditProfile');
  btnEditProfile.addEventListener("click",function(){
      User.saveOldData();
      User.convertProfileDataToEditable();
      this.disabled = true;
  })

  //funcionalidad boton CANCELAR
  let btnCancelChanges = document.querySelector('.option.btnCancelChanges');
  btnCancelChanges.addEventListener('click',function(){
    User.convertEditableToProfileData();
    User.restoreOldData();
    btnEditProfile.disabled = false;
  });

  //funcionalidad vista-previa para el input avatar
  let inputAvatar = document.querySelector('input.avatar');
  inputAvatar.addEventListener('change',function(){
     let avatarImg = inputAvatar.files[0];
     let reader  = new FileReader();
     reader.readAsDataURL(avatarImg);
     reader.onloadend = function () {
       console.log(reader.result);
       let divImg = document.querySelector('.field.avatar');
       divImg.src =reader.result;
    }
  });
}

//GUARDA temporalmente los datos que tenian los campos antes de ser modificados
//por si presiona CANCELAR.
User.saveOldData = function(){
  let queryBefore = 'input[name="';
  let queryAfter = '"]';
  Fields.name = document.querySelector(queryBefore+'name'+queryAfter).value;
  Fields.email =document.querySelector(queryBefore+'email'+queryAfter).value;
  Fields.birth_date =document.querySelector(queryBefore+'birth_date'+queryAfter).value;
  Fields.tvseries_fav =document.querySelector(queryBefore+'tvseries_fav'+queryAfter).value;
  Fields.movie_fav =document.querySelector(queryBefore+'movie_fav'+queryAfter).value;
  Fields.genre_fav =document.querySelector(queryBefore+'genre_fav'+queryAfter).value;
  Fields.biography =document.querySelector(queryBefore+'biography'+queryAfter).value;
  Fields.avatar = document.querySelector('.field.avatar').src;
  console.log(Fields.biography);
}

User.restoreOldData = function(){
  let queryBefore = '.field input[name="';
  let queryAfter = '"]';
  document.querySelector(queryBefore+'name'+queryAfter).value = Fields.name;
  document.querySelector(queryBefore+'email'+queryAfter).value = Fields.email;
  document.querySelector(queryBefore+'birth_date'+queryAfter).value =Fields.birth_date;
  document.querySelector(queryBefore+'tvseries_fav'+queryAfter).value = Fields.tvseries_fav;
  document.querySelector(queryBefore+'movie_fav'+queryAfter).value = Fields.movie_fav;
  document.querySelector(queryBefore+'genre_fav'+queryAfter).value = Fields.genre_fav;
  document.querySelector(queryBefore+'biography'+queryAfter).value = Fields.biography;
  document.querySelector('.field.avatar').src = Fields.avatar;
}


User.convertProfileDataToEditable = function(){
    // convierte en editables los campos (labels)
    let editables = document.querySelectorAll('.field input');
    editables.forEach(function(e){
      e.removeAttribute('readonly');
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


User.convertEditableToProfileData = function(){
  // convierte en divs normales los campos editables
  let editables = document.querySelectorAll('.field input');
  editables.forEach(function(e){
    e.setAttribute('readonly',true);
  });

  //hace no-visible editable del avatar
  let avatar = document.querySelector('.editable.avatar');
  if (!avatar.classList.contains('no-visible')){
    avatar.classList.add('no-visible');
  };

  //hace no-visibles los botones de GUARDAR y CANCELAR
  let btnOptions = document.querySelectorAll('.edit-options .option');
  btnOptions.forEach(function(btn){
    if (!btn.classList.contains('no-visible')){
      btn.classList.add('no-visible');
    }
  });
}
