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
  <x-sidebar.user.sidebar-jadwal/>

  <main class="home_content">
    <div id="calendar" class="flex-grow h-screen overflow-hidden overflow-y-auto"></div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script>
    window.menuIconPath = "{{ asset('icon/menu.svg') }}";
    let sidebar = document.querySelector(".sidebar");
    
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');
      const initialView = calendarEl.getAttribute('data-initial-view') || 'dayGridMonth';
    
      function formatJam(jamString) {
        const [jam, menit] = jamString.trim().split(':');
        return `${jam.padStart(2, '0')}:${(menit || '00').padStart(2, '0')}`;
      }

      const jadwalSlot = @json($jadwals).map(jadwal => {
        const waktuMulai = formatJam(jadwal.waktu_kegiatan.split(' - ')[0]);
        const waktuSelesai = formatJam(jadwal.waktu_kegiatan.split(' - ')[1]);

        return {
          title: jadwal.nama_kegiatan,
          start: `${jadwal.tanggal}T${waktuMulai}`,
          end: `${jadwal.tanggal}T${waktuSelesai}`,
          color: jadwal.ruangan ? jadwal.ruangan.warna : 'gray',
          extendedProps: {
            ruangan: jadwal.ruangan ? jadwal.ruangan.nama : 'Tanpa Ruangan',
            waktuMulai: waktuMulai,
            waktuSelesai: waktuSelesai,
            pemesan: jadwal.user ? jadwal.user.name : 'Tidak Diketahui',
            peserta: jadwal.jumlah_peserta
          }
        };
      });
    
      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: initialView,
        allDaySlot: false,
        nowIndicator: true,
        headerToolbar: {
          left: 'menuButton prev,next Today',
          center: 'title',
          right: 'Month,Week,Day'
        },
        customButtons: {
          menuButton: {
            text: '',
            click: function () {
              sidebar.classList.toggle("active");
              setTimeout(() => calendar.render(), 500);
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
        events: jadwalSlot,
        eventContent: function (arg) {
          const { event, view } = arg;
          const waktuMulai = event.extendedProps.waktuMulai;
          const waktuSelesai = event.extendedProps.waktuSelesai;
          const namaKegiatan = event.title;
          const namaRuangan = event.extendedProps.ruangan;
          const backgroundColor = event.backgroundColor || event.color || 'gray';
          
          const namaPemesan = event.extendedProps.pemesan;
          const jumlahPeserta = event.extendedProps.peserta;
          const tooltipText = `${namaKegiatan}
          ${waktuMulai} - ${waktuSelesai}
          ${namaRuangan}
          Oleh: ${namaPemesan}
          Peserta: ${jumlahPeserta}`;
        
          if (view.type === 'dayGridMonth') {
            const containerEl = document.createElement('div');
            containerEl.className = 'fc-event-custom';
            containerEl.style.backgroundColor = backgroundColor;
            containerEl.title = tooltipText;
            
            containerEl.innerHTML = `
              <div><strong>${waktuMulai} - ${waktuSelesai}</strong></div>
              <div>${namaKegiatan}</div>
              <div><em>${namaRuangan}</em></div>
              <div class="text-xs">Oleh: ${namaPemesan}</div>
              <div class="text-xs">Peserta: ${jumlahPeserta}</div>
            `;
            
            return { domNodes: [containerEl] };
          } else {
            const innerHTML = `
              <div title="${tooltipText.replace(/\n/g, '&#10;')}">
                <strong>${waktuMulai} - ${waktuSelesai}</strong><br>
                ${namaKegiatan}<br>
                <em>${namaRuangan}</em><br>
                <small>Oleh: ${namaPemesan}</small><br>
                <small>Peserta: ${jumlahPeserta}</small>
              </div>
            `;
            return { html: innerHTML };
          }
        }
      });
    
      calendar.render();
    
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
