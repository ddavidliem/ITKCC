import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;
import './bootstrap';
import modal from 'bootstrap/js/dist/modal';
import { Chart } from 'chart.js/auto';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
document.addEventListener('DOMContentLoaded', function () {
    flatpickr('#datepicker', {
        dateFormat: 'Y-m-d',
    });
});
import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import fullCalendarStyle from '@fullcalendar/bootstrap5';


window.Chart = Chart;
window.fullCalendarStyle = fullCalendarStyle;
window.list = listPlugin;
window.timegrid = timeGridPlugin;
window.Calendar = Calendar;
window.modal = modal;