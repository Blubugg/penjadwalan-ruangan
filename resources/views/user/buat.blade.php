<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Styles / Scripts -->
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>Buat Jadwal</title>

  <style>
    .time-slot {
      cursor: pointer;
    }
    .time-slot.selected {
      background-color: #4caf50;
      color: white;
    }
  </style>
</head>
<body>
  <div id="page-content" class="flex">
    <!-- Add Event -->
    <div class="w-[380px] p-[10px] z-1 bg-white">
      <div class="w-full h-full p-[20px] bg-white rounded-[20px] shadow-side">
        <h2 class="text-xl font-bold mb-4">Buat Jadwal</h2>
        <form id="eventForm" method="POST" action="{{ route('user.jadwals.store') }}" enctype="multipart/form-data">
          @csrf 
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Nama Kegiatan</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" name="nama_kegiatan" type="text" placeholder="Nama Kegiatan" required>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-4">
            <!-- Tanggal Kegiatan -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal">Tanggal Kegiatan</label>
              <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-700 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                  </svg>
                </div>
                <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" name="tanggal" type="text" 
                       class="bg-white border border-gray-700 text-gray-700 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 py-2 px-3" 
                       placeholder="Pilih Tanggal" required>
              </div>
            </div>

            <!-- Durasi Kegiatan -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="duration">Durasi Kegiatan</label>
              <select id="duration" name="durasi"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                      required>
                <option value="1">1 jam</option>
                <option value="2">2 jam</option>
                <option value="3">3 jam</option>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="time">Waktu</label>
            <div id="timeSlots" class="grid grid-cols-2 gap-2"></div>
            <input type="hidden" name="waktu_kegiatan" value="00:00" id="timeValues">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="jumlah_peserta">Jumlah Peserta</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jumlah_peserta" name="jumlah_peserta" type="number" placeholder="Jumlah Peserta" min="1" required>
          </div>          
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="room">Ruangan</label>
            <div id="roomSlots" class="grid grid-cols-2 gap-2">
              @foreach ($ruangans as $ruangan )
                <button type="button" 
                        class=" text-white py-2 px-4 rounded" 
                        data-id="{{ $ruangan->id }}" 
                        data-color="{{ $ruangan->warna }}"
                        style="background-color: {{ $ruangan->warna }};">
                        {{ $ruangan->nama }} Lantai {{ $ruangan->lantai }}
                </button>
              @endforeach
              <input type="hidden" name="ruangan_id" id="roomValues" value="0">
            </div>
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">Surat Permohonan</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="file" name="surat_ijin" type="file" accept="application/pdf">
            <p class="text-gray-600 text-xs mt-1">Upload surat permohonan (.pdf)</p>
          </div>
          
          <div class="flex justify-end">
            <button class="bg-[#E81A1D] text-white py-2 px-4 mr-2 rounded" onclick="history.back()">Kembali</button>
            <button class="bg-black text-white py-2 px-4 rounded">Reservation</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <main id="calendar" class="m-0" data-initial-view="timeGridWeek"></main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const durationSelect = document.getElementById('duration');
      const timeSlotsContainer = document.getElementById('timeSlots');
      const timeValuesElement = document.getElementById('timeValues');
      const roomButtons = document.querySelectorAll('#roomSlots button');
      const roomValuesElement = document.getElementById('roomValues');

      roomButtons.forEach(button => {
        button.addEventListener('click', function () {
          // Clear selection styling from all buttons
          roomButtons.forEach(btn => {
            btn.classList.remove('selected');
            btn.style.backgroundColor = btn.getAttribute('data-color'); // Reset to original background color
            btn.style.color = 'white'; // Ensure text is visible on original background
            btn.style.border = 'none'; // Remove any applied borders
          });
        
          // Apply selected styling to the clicked button
          this.classList.add('selected');
          this.style.backgroundColor = 'white'; // Set background to white
          this.style.color = this.getAttribute('data-color'); // Text color matches the room's color
          this.style.border = `2px solid ${this.getAttribute('data-color')}`; // Add border to emphasize selection
        
          // Update the hidden input with the selected room ID
          if (roomValuesElement) {
            roomValuesElement.value = this.getAttribute('data-id');
            console.log(`Selected Room ID: ${roomValuesElement.value}`); // Debugging log
          }
        });
      });

      function generateTimeSlots(duration) {
        const startHour = 8;
        const endHour = 18; // Example working hours: 8 AM to 6 PM
        const slots = [];

        for (let hour = startHour; hour + duration <= endHour; hour++) {
          const start = `${hour}:00`;
          const end = `${hour + duration}:00`;
          slots.push(`${start} - ${end}`);
        }

        return slots;
      }

      function updateTimeSlots() {
        const duration = parseInt(durationSelect.value, 10);
        const slots = generateTimeSlots(duration);

        timeSlotsContainer.innerHTML = '';
        slots.forEach(slot => {
          const button = document.createElement('button');
          button.type = 'button';
          button.textContent = slot;
          button.className = 'bg-gray-200 py-2 px-4 rounded time-slot';
          button.addEventListener('click', () => {
            document.querySelectorAll('.time-slot').forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            timeValuesElement.value = button.textContent;
          });
          timeSlotsContainer.appendChild(button);
        });
      }
      
      durationSelect.addEventListener('change', updateTimeSlots);
      
      // Initialize with default duration
      updateTimeSlots();
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

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
