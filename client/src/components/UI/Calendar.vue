<script setup>
import FullCalendar from '@fullcalendar/vue3'
import timeGridPlugin from '@fullcalendar/timegrid'
import allLocales from '@fullcalendar/core/locales-all';

const calendarOptions = {
    plugins: [timeGridPlugin],
    initialView: 'timeGridWeek',
    events: [
        { title: 'Meeting', start: new Date() }
    ],
    headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'timeGridWeek,timeGridDay' // user can switch between the two
    },
    locales: allLocales,
    locale: 'fr',
    // events: [
    //     {
    //         start: '2023-08-17T10:00:00',
    //         end: '2023-08-22T16:00:00',
    //         display: 'background'
    //     }
    // ]
}

</script>

<template>
    <FullCalendar :options='calendarOptions' />
</template>