
import { Chart } from 'chart.js/auto';
window.Chart = Chart;
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
document.addEventListener('DOMContentLoaded', function () {
    flatpickr('#datepicker', {
        dateFormat: 'Y-m-d',
    });
});

import jQuery, { data } from 'jquery';
window.$ = jQuery;

import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import Bootstrap5Plugin from '@fullcalendar/bootstrap5';

window.bootstrap = Bootstrap5Plugin;
window.list = listPlugin;
window.timegrid = timeGridPlugin;
window.Calendar = Calendar;


import './bootstrap';






