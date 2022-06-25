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

e.private('user.' + window.User.id)
    .listen('NewFollowerEvent', function(e) {
        if (e.action == 'added') {
            Swal.fire({
                icon: 'success',
                title: "Nouvelle demande",
                text: e.followed.name + " vous a envoyez une demande",
                toast: true,
                showConfirmButton: false,
            });
        }
        console.log(e);
        Livewire.emit('notifyMeWhenNewFollower', e.follower);

    });