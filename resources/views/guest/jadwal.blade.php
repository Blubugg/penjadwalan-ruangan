<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- Styles / Scripts -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <title>Jadwal</title>

</head>
<body class="relative min-h-screen w-full overflow-hidden">
  <x-sidebar.guest.sidebar-jadwal/>
  
  <main class="home_content">
    <div id="calendar" class="flex-grow h-screen overflow-hidden overflow-y-auto "></div>
  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script>
    window.menuIconPath = "{{ asset('icon/menu.svg') }}";

    let sidebar = document.querySelector(".sidebar");

    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');
      
      // Get the initial view from the data attribute
      const initialView = calendarEl.getAttribute('data-initial-view') || 'dayGridMonth';

      const jadwalSlot = @json($jadwals).map(jadwal => {
        const waktuMulai = jadwal.waktu_kegiatan.split(' - ')[0]; // Extract start time
        const waktuSelesai = jadwal.waktu_kegiatan.split(' - ')[1]; // Extract end time
        return {
          title: jadwal.nama_kegiatan,
          start: `${jadwal.tanggal}T${waktuMulai}`,
          end: `${jadwal.tanggal}T${waktuSelesai}`,
          color: jadwal.ruangan ? jadwal.ruangan.warna : 'grey'
        };
      });

      console.log(jadwalSlot);
          
      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: initialView,
        headerToolbar: {
          left: 'menuButton prev,next Today',
          center: 'title',
          right: 'Month,Week,Day'
        },
        customButtons: {
          menuButton: {
            text: '', // Empty text, will be replaced with an image
            click: function () {
              sidebar.classList.toggle("active");

              setTimeout(() => {
                calendar.render();
              }, 500);
            }
          },
          Today: {
            text: 'Hari Ini',
            click: function () {
              calendar.today();
            }
          },
          Month: {
            text: 'Bulan',
            click: function () {
              calendar.changeView('dayGridMonth');
            }
          },
          Week: {
            text: 'Minggu',
            click: function () {
              calendar.changeView('timeGridWeek');
            }
          },
          Day: {
            text: 'Hari',
            click: function () {
              calendar.changeView('timeGridDay');
            }
          }
        },
        events: jadwalSlot
      });

      calendar.render();

      // Update Menu Button After Calendar Renders
      setTimeout(() => {
        const menuButton = document.querySelector('.fc-menuButton-button');
        if (menuButton) {
          menuButton.innerHTML = `<img src="${window.menuIconPath}" alt="Menu" class="navIcon">`;
        }
      }, 100);

      window.calendar = calendar;
    });
  </script>
</body>
</html>
