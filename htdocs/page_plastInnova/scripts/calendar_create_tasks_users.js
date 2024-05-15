document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    editable: false,
    selectable: true,
    allDaySlot: false,
    dateClick: function(info) {
    var dateAsString = info.dateStr;
    var selectedDate = new Date(dateAsString);
    var currentDate = new Date();
    currentDate.setHours(0,0,0,0);
    selectedDate.setHours(25,0,0,0);
    if (selectedDate <= currentDate){
        alert("No se pueden crear tareas días anteriores al actual")
        return;
    }
    var dayNumber = new Date(dateAsString).getDay();
    if (dayNumber !==6) {
        $('#maintenance_form #maintenance_date').val(dateAsString);
        $('#modal_reservas').modal("show");
    } else {
        alert('No se pueden crear tareas en este día.');
    }
}
});
calendar.render();
});