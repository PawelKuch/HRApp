document.addEventListener("DOMContentLoaded", function (){
   flatpickr("#start_time", {
       enableTime: true,
       noCalendar: true,
       dateFormat: "H:i",
       time_24hr: true
   });

   flatpickr("#end_time", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true
   });

});
