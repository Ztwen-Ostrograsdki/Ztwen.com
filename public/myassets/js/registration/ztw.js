var closeIt = $('#registerModal form');


window.addEventListener('hide-form', event => {
    $('.modal').modal('hide');
});


window.addEventListener('reloadPage', event => {
    location.reload(true);
});
window.addEventListener('modal-updateProductGalery', event => {
    $('#updateProductModal').modal();
});


$(function() {
    $("#focus_photo_prf").click(function() {
        $("#photo_prf").focus();
    });
});


window.addEventListener('FireAlert', event => {
    if (event.detail.title) {
        Swal.fire({
            title: 'Operation ' + event.detail.title,
            icon: event.detail.type,
            text: event.detail.message,
            timer: 3000,
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
        });
    } else {
        Swal.fire({
            icon: event.detail.type,
            text: event.detail.message,
            timer: 2000,
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
        });
    }
});


window.addEventListener('Logout', event => {
    Swal.fire({
        title: "Déconnexion réussie",
        icon: 'success',
        text: "Vous serez redirigé vers la page d'acceuil dans quelques secondes!",
        timer: 3000,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
    });
});

window.addEventListener('Login', event => {
    Swal.fire({
        title: "Connexion réussie",
        icon: 'success',
        text: "Vous êtes connecté",
        timer: 3000,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
    });
});
window.addEventListener('RegistredSelf', event => {
    Swal.fire({
        title: "Inscription réussie",
        icon: 'success',
        text: "Nous allons vous connecter automatiquement dans quelques secondes!",
        timer: 3000,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
    });
});

window.addEventListener('RegistredNewUser', event => {
    Swal.fire({
        title: "Inscription réussie",
        icon: 'success',
        text: event.detail.username + " a été inscrit avec succès",
        timer: 3000,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,

    });
});

window.addEventListener('MessageDeleted', event => {
    Swal.fire({
        icon: 'success',
        text: "Le message a été supprimé avec succès",
        timer: 1000,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,

    });
});


$(function() {
    $('#OpenEditPhotoProfilModal').dblclick(function() {
        $('#editPhotoProfilModal').modal();
    });
});



$(function() {
    $('#chat-form textarea').on('input', function() {
        $("#errorBagTexto").addClass('d-none');
        $("#messages-container").addClass('border-warning');
        $("#messages-container").removeClass('border-danger');
        $('#sendBtnForChat').removeClass('text-danger');
        $('#sendBtnForChat').removeClass('btn-info');
        $('#sendBtnForChat').addClass('text-white');
        $('#sendBtnForChat').addClass('btn-primary');
        $('#chat-form textarea').addClass('text-dark');

    });
});


// $(function() {
//     $('#tooltip-2').mouseenter(function() {
//         $("#tooltip-3").tooltip();
//     });

// });


window.addEventListener('clear-textarea', event => {
    $('#chat-form textarea').val('');
});