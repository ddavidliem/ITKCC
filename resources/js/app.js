import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
document.addEventListener('DOMContentLoaded', function () {
    flatpickr('#datepicker', {
        dateFormat: 'Y-m-d',
    });
});

import jQuery from 'jquery';

window.$ = jQuery;

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import 'bootstrap-icons/font/bootstrap-icons.css';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, bootstrap5Plugin],
        initialView: 'dayGridMonth',
        height: 600,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        themeSystem: 'bootstrap5',
        businessHours: {
            startTime: '08:00',
            endTime: '16:00',
        },
        weekends: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '16:00:00',
        eventSources: [
            '/events'
        ],
    });
    calendar.render();
});


import './bootstrap';






