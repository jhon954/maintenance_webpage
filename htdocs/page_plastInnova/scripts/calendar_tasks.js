document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    editable: false,
    selectable: true,
    allDaySlot: false,
    events: '../php/show_data_calendar.php',
    
});
calendar.render();
});