<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- Styles / Scripts -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <title>Jadwal</title>
  
</head>
<body>
  <div id="page-content" class="flex">
    <!-- Sidebar Opened -->
    <x-sidebar.guest.sidebar-jadwal/>
    
    <!-- Sidebar Closed -->
    <aside id="sidebar">
      <div id="menu" class="flex py-[13px] items-center justify-center">
        <button id="menuButton" onclick="toggleSidebar()">
          <img src="{{ asset('icon/menu.svg') }}" alt="navIcon" class="w-[32px] h-[32px]">         
        </button>
      </div>
      <hr class="border-0 h-[1px] w-[100px] bg-white">
    </aside>
    
    <!-- Main Content -->
    <main id="calendar"></main>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');
      
      // Get the initial view from the data attribute
      const initialView = calendarEl.getAttribute('data-initial-view') || 'dayGridMonth';
      
      const jadwalSlot = @json($jadwals).map(jadwal => {
              const waktuMulai = jadwal.waktu_kegiatan.split(' - ')[0]; // Extract the start time
              const waktuSelesai = jadwal.waktu_kegiatan.split(' - ')[1]; // Extract the start time
              return {
                title: jadwal.nama_kegiatan,
                start: `${jadwal.tanggal}T${waktuMulai}`, // Combine date and time
                end: `${jadwal.tanggal}T${waktuSelesai}`, // Combine date and time
                color: jadwal.ruangan ? jadwal.ruangan.warna : 'grey'
              };
            });
      console.log(jadwalSlot);
          
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
  </script>
</body>
</html>
