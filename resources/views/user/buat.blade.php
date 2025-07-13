<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <!-- Styles / Scripts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>Buat Jadwal</title>

</head>
<body class="relative min-h-screen w-full overflow-hidden flex">

  <!-- Sidebar -->
  <div class="form-jadwal overflow-y-auto" id="form-jadwal">
    <div class="flex flex-col min-h-full p-[20px] bg-white rounded-[20px] shadow-side">
      <h2 class="text-xl font-bold mb-4">Buat Jadwal</h2>
      <form id="eventForm" method="POST" action="{{ route('user.jadwals.store') }}" enctype="multipart/form-data" class="flex flex-col flex-grow">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Nama Kegiatan</label>
          <input class="shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 text-gray-700 text-[16px] focus:outline-none focus:shadow-outline" id="title" name="nama_kegiatan" type="text" placeholder="Nama Kegiatan" title="Masukkan nama kegiatan yang akan dilaksanakan" required>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal">Tanggal Kegiatan</label>
          <div class="relative">
            <input
              type="text"
              name="tanggal"
              class="dateValues bg-white border border-gray-700 text-gray-700 text-[16px] rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-2 px-3"
              placeholder="Pilih Tanggal"
              data-datepicker
              title="Pilih tanggal pelaksanaan kegiatan"
              required
            />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
          <!-- Start Time -->
          <div>
            <label for="start-time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Mulai</label>
            <div class="relative">
              <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                </svg>
              </div>
              <input type="text" id="start-time" name="start_time" class="timepicker shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 text-gray-700 text-[16px] focus:outline-none focus:shadow-outline" placeholder="00:00" title="Masukkan waktu mulai kegiatan" required>
            </div>
          </div>


          <!-- End Time -->
          <div>
            <label for="end-time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Selesai</label>
            <div class="relative">
              <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                </svg>
              </div>
              <input type="text" id="end-time" name="end_time" class="timepicker shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 text-gray-700 text-[16px] focus:outline-none focus:shadow-outline" placeholder="00:00" title="Masukkan waktu selesai kegiatan" required>
            </div>
          </div>

        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="jumlah_peserta">Jumlah Peserta</label>
          <input class="shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 text-gray-700 text-[16px] focus:outline-none focus:shadow-outline" id="jumlah_peserta" name="jumlah_peserta" type="number" placeholder="Jumlah Peserta" title="Masukkan estimasi jumlah peserta kegiatan" min="1" required>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="room">Ruangan</label>
          <div class="roomSlots grid grid-cols-2 gap-2">
            @foreach ($ruangans as $ruangan )
              <button
                type="button"
                class="text-white py-2 px-2 rounded"
                data-id="{{ $ruangan->id }}"
                data-color="{{ $ruangan->warna }}"
                data-kapasitas="{{ $ruangan->kapasitas }}"
                style="background-color: {{ $ruangan->warna }};">
                {!! $ruangan->nama . '<br>Lantai ' . $ruangan->lantai . '<br>Kapasitas ' . $ruangan->kapasitas !!}
              </button>
            @endforeach
            <input type="hidden" name="ruangan_id" class="roomValues" value="0">
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="file">Surat Permohonan</label>
          <input class="shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="file" name="surat_ijin" type="file" accept="application/pdf" title="Unggah surat permohonan dalam format PDF">
          <p class="text-gray-600 text-xs mt-1">Upload surat permohonan (.pdf)</p>
        </div>

        <div class="mt-auto flex justify-end">
          <button class="bg-[#E81A1D] text-white py-2 px-4 mr-2 rounded" type="button" title="Kembali ke halaman sebelumnya" onclick="history.back()">Kembali</button>
          <button class="bg-black text-white py-2 px-4 rounded" type="submit" title="Mengajukan permohonan jadwal">>Reservasi</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Konten Kalender -->
  <main class="page_content">
    <div id="calendar" class="flex-grow h-screen overflow-hidden"></div>
  </main>

  <!-- Slide-up Form -->
  <div id="slideForm" class="absolute bottom-0 left-0 right-0 bg-white shadow-xl rounded-t-2xl transform translate-y-full transition-transform duration-500 z-20 md:hidden">
    <!-- Drag handle -->
    <div id="dragHandle" class="w-full flex justify-center py-3 bg-gray-100 rounded-t-2xl cursor-grab touch-none">
      <div class="w-12 h-1.5 bg-gray-400 rounded-full"></div>
    </div>

    <!-- Scroll only this container -->
    <div class="form-jadwal-container p-10 max-h-[90vh] overflow-y-auto"></div>
  </div>

  <!-- Floating Button Ajukan Jadwal -->
  <div id="showFormPrompt" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg z-30 text-sm font-medium cursor-pointer md:hidden">
    ▲ Ajukan Jadwal
  </div>

  <!-- Flatpickr JS (resmi) -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Flatpickr tanggal (jika tetap pakai Flowbite Datepicker)
      const today = new Date();
      document.querySelectorAll('[data-datepicker]').forEach(input => {
        new Datepicker(input, {
          autohide: true,
          format: 'dd/mm/yyyy',
          minDate: today
        });
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const roomButtons = document.querySelectorAll('.roomSlots button');
      const roomValuesElements = document.querySelectorAll('.roomValues');
      const dateInputElements = document.querySelectorAll('.dateValues');
      const formTemplate = document.querySelector('#form-jadwal form');

      // Clone form untuk versi mobile
      document.querySelectorAll('.form-jadwal-container').forEach(container => {
        const clonedForm = formTemplate.cloneNode(true);
        container.appendChild(clonedForm);
      
        // Re-inisialisasi plugin input waktu & tanggal
        flatpickr(clonedForm.querySelectorAll('.timepicker'), {
          enableTime: true,
          noCalendar: true,
          dateFormat: "H:i",
          time_24hr: true
        });
      
        clonedForm.querySelectorAll('[data-datepicker]').forEach(input => {
          new Datepicker(input, {
            autohide: true,
            format: 'dd/mm/yyyy',
            minDate: new Date()
          });
        });

        // Room selection logic for cloned form
        const clonedRoomButtons = clonedForm.querySelectorAll('.roomSlots button');
        const clonedRoomValue = clonedForm.querySelector('.roomValues');
              
        clonedRoomButtons.forEach(button => {
          button.addEventListener('click', function () {
            // Reset styling
            clonedRoomButtons.forEach(btn => {
              btn.classList.remove('selected');
              btn.style.backgroundColor = btn.getAttribute('data-color');
              btn.style.color = 'white';
              btn.style.border = 'none';
            });
          
            // Apply selected style
            this.classList.add('selected');
            this.style.backgroundColor = 'white';
            this.style.color = this.getAttribute('data-color');
            this.style.border = `2px solid ${this.getAttribute('data-color')}`;
          
            // Set hidden input value
            if (clonedRoomValue) {
              clonedRoomValue.value = this.getAttribute('data-id');
            }
          
            updatePreviewEvent(clonedForm);
          });
        });
      
        // Tambahkan validasi ketersediaan ruangan
        attachAvailabilityCheck(clonedForm);
      
        // Validasi submit untuk form clone
        clonedForm.addEventListener('submit', function (e) {
          const startTime = clonedForm.querySelector('#start-time')?.value;
          const endTime = clonedForm.querySelector('#end-time')?.value;
          const room = clonedForm.querySelector('.roomValues')?.value;
          const file = clonedForm.querySelector('input[type="file"]')?.files[0];
          const errors = [];
        
          if (!startTime || !endTime) errors.push("Waktu mulai dan selesai harus diisi.");
          if (room === "0" || !room) errors.push("Ruangan belum dipilih.");
          if (!file) errors.push("File surat permohonan belum diunggah.");
        
          if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join("\n"));
          }
        });
      
        // Preview event untuk cloned form
        const inputs = ['#title', '.dateValues', '#start-time', '#end-time', '#jumlah_peserta'];
        inputs.forEach(selector => {
          clonedForm.querySelector(selector)?.addEventListener('input', () => updatePreviewEvent(clonedForm));
          clonedForm.querySelector(selector)?.addEventListener('change', () => updatePreviewEvent(clonedForm));
        });
      
        // Listener tombol ruangan pada clonedForm
        clonedForm.querySelectorAll('.roomSlots button').forEach(button => {
          button.addEventListener('click', () => updatePreviewEvent(clonedForm));
        });
      });

      roomButtons.forEach(button => {
        button.addEventListener('click', function () {
          roomButtons.forEach(btn => {
            btn.classList.remove('selected');
            btn.style.backgroundColor = btn.getAttribute('data-color');
            btn.style.color = 'white';
            btn.style.border = 'none';
          });

          this.classList.add('selected');
          this.style.backgroundColor = 'white';
          this.style.color = this.getAttribute('data-color');
          this.style.border = `2px solid ${this.getAttribute('data-color')}`;

          roomValuesElements.forEach(roomValue => roomValue.value = this.getAttribute('data-id'));
        });
      });

      const jumlahPesertaInput = document.getElementById('jumlah_peserta');

      // Fungsi untuk validasi kapasitas ruangan
      function updateRoomCapacityValidation() {
        const jumlahPeserta = parseInt(jumlahPesertaInput.value) || 0;
      
        roomButtons.forEach(button => {
          const kapasitas = parseInt(button.getAttribute('data-kapasitas')) || 0;
        
          if (jumlahPeserta > kapasitas) {
            button.disabled = true;
            button.style.opacity = 0.5;
            button.title = `Kapasitas maksimal ${kapasitas} orang`;
          } else {
            button.disabled = false;
            button.style.opacity = 1;
            button.removeAttribute('title');
          }
        });
      }
      
      // Jalankan saat jumlah peserta berubah
      jumlahPesertaInput.addEventListener('input', updateRoomCapacityValidation);
      
      // Jalankan saat halaman dimuat pertama kali
      updateRoomCapacityValidation();

      function updateRoomAvailability(selectedDate, startTime, endTime, form = document) {
        console.log("Validasi ruangan:", selectedDate, startTime, endTime);

        if (selectedDate && startTime && endTime) {
          fetch(`/check-room-availability?tanggal=${selectedDate}&start=${startTime}&end=${endTime}`)
            .then(response => response.json())
            .then(data => {
              const roomButtons = form.querySelectorAll('.roomSlots button');
              const jumlahPesertaInput = form.querySelector('#jumlah_peserta');
              const jumlahPeserta = parseInt(jumlahPesertaInput?.value) || 0;
            
              roomButtons.forEach(button => {
                const roomId = parseInt(button.getAttribute('data-id'));
                const kapasitas = parseInt(button.getAttribute('data-kapasitas')) || 0;
                const roomStatus = data.find(r => r.id === roomId);
              
                let isDisabled = false;
                let alasan = '';
              
                if (roomStatus && !roomStatus.isAvailable) {
                  isDisabled = true;
                  alasan = 'Ruangan tidak tersedia pada waktu tersebut';
                } else if (jumlahPeserta > kapasitas) {
                  isDisabled = true;
                  alasan = `Kapasitas maksimal ${kapasitas} orang`;
                }
              
                button.disabled = isDisabled;
                button.style.opacity = isDisabled ? 0.5 : 1;
                if (isDisabled) {
                  button.title = alasan;
                  button.classList.remove('selected'); // Unselect jika disabled
                  if (form.querySelector('.roomValues')?.value == roomId) {
                    form.querySelector('.roomValues').value = "0";
                  }
                } else {
                  button.removeAttribute('title');
                }
              });
            });
        }
      }

      // Trigger pengecekan saat tanggal, start-time, atau end-time berubah
      function attachAvailabilityCheck(form) {
        const dateInput = form.querySelector('.dateValues');
        const startTimeInput = form.querySelector('#start-time');
        const endTimeInput = form.querySelector('#end-time');
        const jumlahPesertaInput = form.querySelector('#jumlah_peserta');

        const triggerCheck = () => {
          const tanggal = dateInput?.value;
          const start = startTimeInput?.value;
          const end = endTimeInput?.value;
          if (tanggal && start && end) {
            updateRoomAvailability(tanggal, start, end, form);
          }
        };

        dateInput?.addEventListener('change', triggerCheck);
        startTimeInput?.addEventListener('change', triggerCheck);
        endTimeInput?.addEventListener('change', triggerCheck);
        jumlahPesertaInput?.addEventListener('input', triggerCheck);
      }

      // Untuk form utama
      attachAvailabilityCheck(document);
      
      document.querySelectorAll('form').forEach(form => {
        const tanggal = form.querySelector('.dateValues')?.value;
        const start = form.querySelector('#start-time')?.value;
        const end = form.querySelector('#end-time')?.value;
        if (tanggal && start && end) {
          updateRoomAvailability(tanggal, start, end, form);
        }
      });

      document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
          const startTime = form.querySelector('#start-time')?.value;
          const endTime = form.querySelector('#end-time')?.value;
          const room = form.querySelector('.roomValues')?.value;
          const file = form.querySelector('input[type="file"]')?.files[0];
          const time = `${startTime} - ${endTime}`;
        
          const errors = [];
        
          if (!startTime || !endTime) {
            errors.push("Waktu mulai dan selesai harus diisi.");
          }
        
          if (room === "0" || !room) {
            errors.push("Ruangan belum dipilih.");
          }
        
          if (!file) {
            errors.push("File surat permohonan belum diunggah.");
          }
        
          if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join("\n"));
          }
        });
      });
    });

    let previewEvent = null;

    function getFormValues(form = document) {
      const tanggal = form.querySelector('.dateValues')?.value;
      const start = form.querySelector('#start-time')?.value;
      const end = form.querySelector('#end-time')?.value;
      const namaKegiatan = form.querySelector('#title')?.value;
      const jumlahPeserta = form.querySelector('#jumlah_peserta')?.value;
      const roomId = form.querySelector('.roomValues')?.value;
      const roomButton = form.querySelector(`.roomSlots button[data-id="${roomId}"]`);
      const warna = roomButton?.getAttribute('data-color') || '#888';
      const namaRuangan = roomButton?.innerText?.split('\n')[0] || 'Ruangan';
      const pemesan = "{{ Auth::user()->name ?? 'User' }}";

      return { tanggal, start, end, namaKegiatan, jumlahPeserta, warna, namaRuangan, pemesan };
    }

    function convertToISO(tanggal, waktu) {
      if (!tanggal || !waktu) return null;
      const [dd, mm, yyyy] = tanggal.split('/');
      const [hh, ii] = waktu.split(':');
      return `${yyyy}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}T${hh.padStart(2, '0')}:${ii.padStart(2, '0')}`;
    }

    function updatePreviewEvent(form = document) {
      const { tanggal, start, end, namaKegiatan, jumlahPeserta, warna, namaRuangan, pemesan } = getFormValues(form);
        
      if (!tanggal || !start || !end || !namaKegiatan || !jumlahPeserta || !namaRuangan) return;
        
      const startISO = convertToISO(tanggal, start);
      const endISO = convertToISO(tanggal, end);
      if (!startISO || !endISO) return;
        
      if (previewEvent) previewEvent.remove();
        
      previewEvent = window.calendar.addEvent({
        title: namaKegiatan,
        start: startISO,
        end: endISO,
        color: warna,
        display: 'block',
        extendedProps: {
          ruangan: namaRuangan,
          waktuMulai: start,
          waktuSelesai: end,
          pemesan: pemesan,
          peserta: jumlahPeserta
        }
      });
    }

    // Daftarkan event listener untuk semua input yang mempengaruhi preview
    ['#title', '.dateValues', '#start-time', '#end-time', '#jumlah_peserta'].forEach(selector => {
      document.querySelector(selector)?.addEventListener('input', updatePreviewEvent);
      document.querySelector(selector)?.addEventListener('change', updatePreviewEvent);
    });

    document.querySelectorAll('.roomSlots button').forEach(button => {
      button.addEventListener('click', updatePreviewEvent);
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

  <script>
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
          left: 'prev,next Today',
          center: 'title',
          right: 'Month,Week,Day'
        },
        customButtons: {
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
      window.calendar = calendar;
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const slideForm = document.getElementById('slideForm');
      const dragHandle = document.getElementById('dragHandle');
      const showFormPrompt = document.getElementById('showFormPrompt');

      let startY = 0;
      let isDragging = false;

      function showForm() {
        slideForm.style.transform = 'translateY(0%)';
        showFormPrompt.classList.add('hidden');
      }

      function hideForm() {
        slideForm.style.transform = 'translateY(100%)';
        showFormPrompt.classList.remove('hidden');
      }

      // Drag handle gesture
      dragHandle.addEventListener('touchstart', (e) => {
        startY = e.touches[0].clientY;
        isDragging = true;
      });

      dragHandle.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        const deltaY = e.touches[0].clientY - startY;
        if (deltaY > 50) {
          hideForm(); // Swipe down
          isDragging = false;
        } else if (deltaY < -50) {
          showForm(); // Swipe up
          isDragging = false;
        }
      });

      // Show form by tapping prompt button
      showFormPrompt.addEventListener('click', showForm);
    });
  </script>
</body>
</html>
