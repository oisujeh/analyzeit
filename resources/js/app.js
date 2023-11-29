import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import 'tw-elements';
import axios, {isCancel, AxiosError} from 'axios';

import {Tab, initTE} from "tw-elements";

initTE({ Tab });

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();

//console.log(axios.get('/progress/data'));
