import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import './cookie-banner';

Alpine.plugin(intersect);

window.Alpine = Alpine;

Alpine.start();
