document.addEventListener("DOMContentLoaded", function (){
       document.querySelectorAll('.worktime-div').forEach(worktimeDiv => {
           flatpickr("#start_time", {
               enableTime: true,
               noCalendar: true,
               dateFormat: "H:i",
               time_24hr: true,
           });

           flatpickr("#end_time", {
               enableTime: true,
               noCalendar: true,
               dateFormat: "H:i",
               time_24hr: true,
           });
           let id = worktimeDiv.dataset.worktimeDay;
          let worktimeformFromDiv = document.querySelector(`#worktime-form-${id}`);
          let hoursAmountDiv = document.querySelector(`#hoursAmountDiv-${id}`);
          let value = hoursAmountDiv.innerHTML.trim();
          if(value){
             worktimeformFromDiv.classList.add("d-none");
          }

       });




});

/*document.addEventListener("DOMContentLoaded", function (){
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
});*/
