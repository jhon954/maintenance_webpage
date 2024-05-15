document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    editable: false,
    selectable: true,
    allDaySlot: false,
    events: '../php/show_data_calendar.php',
    dateClick: function(info) {
    var a = info.dateStr;
    const fechaComoCadena = a ;
    var numeroDia = new Date(fechaComoCadena).getDay();
    $('#maintenance_form #maintenance_date').val(fechaComoCadena);
    $('#modal_reservas').modal("show");
    }
});
calendar.render();
});