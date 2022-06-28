require('intersection-observer');
IntersectionObserver.prototype.POLL_INTERVAL = 100;
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import Echo from 'laravel-echo';
var e = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
window.ClientUser = {
    id: 0,
};
if (window.User) {
    window.ClientUser = window.User;
}


e.private('user.' + window.ClientUser.id)
    .listen('NewFollowerEvent', function(e) {
        if (e.action == 'added') {
            Swal.fire({
                icon: 'success',
                title: "Nouvelle demande",
                text: e.follower.name + " vous a envoyez une demande",
                toast: true,
                showConfirmButton: false,
            });
        }
        Livewire.emit('notifyMeWhenNewFollower', e.follower);
    })
    .listen('NewMessageEvent', function(e) {
        Swal.fire({
            icon: 'success',
            title: "Nouveau message",
            text: e.user.name + " vous a envoyez un message",
            toast: true,
            showConfirmButton: false,
        });
        Livewire.emit('IHaveNewMessageEvent', e.user.id);
    })
    .listen('IsTypingMessageEvent', function(e) {
        $('#isTyping_' + e.user.id).show('fade', function(i) {
            setTimeout(function() {
                $('#isTyping_' + e.user.id).hide('slide', function(s) {

                }, 'slow');
            }, 10000);
        }, 600);
        $('#preview_' + e.user.id).hide('slide', function(i) {
            $('#UserTyping_' + e.user.id).show('slide', function(k) {
                setTimeout(function() {
                    $('#UserTyping_' + e.user.id).hide('slide', function(s) {
                        $('#preview_' + e.user.id).show('slide', function() {

                        }, 6000);
                    }, 'slow');
                }, 10000);
            }, 'slow');
        }, 'slow');
    });

e.private('master')
    .listen('NewUserRegistredEvent', function(e) {
        Swal.fire({
            icon: 'success',
            title: "Nouvelle inscription",
            text: e.user.name + " vient de lancer son insciption sur le site avec l'adresse " + e.user.email + " ! ",
            toast: true,
            showConfirmButton: false,
        });
        Livewire.emit('notifyMeWhenNewUserRegistred', e.user);
    })
    .listen('NewCommentPostedEvent', function(e) {
        Swal.fire({
            icon: 'success',
            title: "Un nouveau commentaire",
            text: e.user.name + " vient de poster un commentaire ...",
            toast: true,
            showConfirmButton: false,
        });
        Livewire.emit('notifyMeWhenNewCommentHasBeenPosted', e.user);
    });

e.join('online')
    .here(function(users) {
        // console.log('users on line', users);
    })
    .joining(function(user) {
        Swal.fire({
            text: user.name + " est en ligne ",
            toast: true,
            showConfirmButton: false,
        });
    })
    .leaving(function(user) {
        Swal.fire({
            text: user.name + " est s'est déconnecté ",
            toast: true,
            showConfirmButton: false,
        });
    });