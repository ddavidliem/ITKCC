import loadash from 'lodash';
window._ = loadash;

import * as Popper from '@popperjs/core';
window.Popper = Popper;

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import bootstrap from 'bootstrap/dist/js/bootstrap';

window.bootstrap = bootstrap;



import '../sass/app.scss';

// ... Other configurations, if needed

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';