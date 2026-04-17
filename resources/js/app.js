import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';
import registerLandingHome from './landing-home';
import './cookie-banner';

Alpine.plugin(intersect);
Alpine.plugin(collapse);
registerLandingHome(Alpine);

window.Alpine = Alpine;

Alpine.start();
