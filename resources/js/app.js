import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import registerLandingHome from './landing-home';
import './cookie-banner';

Alpine.plugin(intersect);
registerLandingHome(Alpine);

window.Alpine = Alpine;

Alpine.start();
