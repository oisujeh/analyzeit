import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import 'tw-elements';

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
