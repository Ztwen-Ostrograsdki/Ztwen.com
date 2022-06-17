require('intersection-observer');
IntersectionObserver.prototype.POLL_INTERVAL = 100;
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();