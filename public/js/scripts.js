document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  
  // Get the initial view from the data attribute
  const initialView = calendarEl.getAttribute('data-initial-view') || 'dayGridMonth';
  
  var jadwalSlot = [
      
    {
      title: 'Event 1',
      start: '2024-11-07T14:00:00',
      color: 'blue'
    },
    {
      title: 'Event 2',
      start: '2024-11-08T09:00:00',
      color: 'green'
    },
    {
      title: 'Event 3',
      start: '2024-11-14T10:00:00',
      color: 'green'
    },
    {
      title: 'Event 4',
      start: '2024-11-15T08:00:00',
      color: 'blue'
    }
  ];

  const calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'id',
    initialView: initialView,
    headerToolbar: {
      left: 'prev,next Today',
      center: 'title',
      right: 'Month,Week,Day'
    },
    customButtons: {
      Today: {
        text: 'Hari Ini', // Custom text for the Today button
        click: function () {
          calendar.today(); // Navigate to today's date
        }
      },
      Month : {
        text: 'Bulan',
        click: function () {
          calendar.changeView('dayGridMonth');
        }
      },
      Week : {
        text: 'Minggu',
        click: function () {
          calendar.changeView('timeGridWeek');
        }
      },
      Day : {
        text: 'Hari',
        click: function () {
          calendar.changeView('timeGridDay');
        }
      }
    },
    events: jadwalSlot
  });
  calendar.render();

  window.calendar = calendar;
  
});

let isSidebar1Active = true;

function toggleSidebar() {
  const sidebar1 = document.getElementById("sidebar");
  const sidebar2 = document.getElementById("default-sidebar")
  const main = document.querySelector("main");

  if (isSidebar1Active) {
    sidebar1.style.display = "none";
    sidebar2.style.display = "block";
    main.style.marginLeft = "250px";
  } else {
    sidebar1.style.display = "block";
    sidebar2.style.display = "none";
    main.style.marginLeft = "100px";
  }

  isSidebar1Active = !isSidebar1Active;

  // Re-render the calendar after animation
  setTimeout(() => {
    calendar.render();
  }, 300);
}
