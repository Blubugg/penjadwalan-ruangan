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
  
  <title>Ruangan</title>

</head>
<body class="relative min-h-screen w-full overflow-hidden">
  <x-sidebar.admin.sidebar-ruangan/>
  
  <!-- Main Content -->
  <main class="home_content overflow-y-auto">
    <!-- Header -->
    <header class="bg-[#003f7d] border-b border-white fixed top-0 h-[71px] w-full z-10">
      <div class="flex items-center justify-between py-[14px] px-[12px]">
          <div class="flex items-center">
            <button id="menuButton" class="bg-[#002b5c] py-[6.4px] px-[10.4px] rounded" onclick="toggleSidebar()">
              <img src="{{ asset('icon/menu.svg') }}" alt="Menu" class="navIcon">
            </button>
            <h1 class="ml-3 text-[1.75rem] font-bold text-white">Ruangan</h1>
          </div>
      </div>
    </header>
    
    <!-- Room Cards -->
    <div id="ruanganContainer" class="grid grid-cols-1 px-8 pt-[91px] pb-8 md:grid-cols-2 gap-8">
      <!-- Existing Cards -->
      @foreach ($ruangans as $ruangan)
      <div class="room-card bg-white rounded-lg shadow-lg overflow-hidden relative" data-ruangan-id="{{ $ruangan->id }}">
          <div class="h-24" style="background-color: {{ $ruangan->warna }};"></div>
          <div class="p-4 flex flex-col h-full">
              <div class="flex-grow pb-12">
                  <h2 class="text-lg font-bold">{{ $ruangan->nama }}</h2>
                  <p>Lantai {{ $ruangan->lantai }}</p>
                  <p>Kapasitas: {{ $ruangan->kapasitas }} orang</p>
                  <p>Fasilitas: {{ $ruangan->fasilitas }}</p>
              </div>
              <!-- Buttons -->
              <div class="absolute bottom-4 right-4 flex gap-2">
                <!-- Edit Button -->
                <button class="edit-btn bg-[#1A35E8] text-white px-3 py-1 rounded hover:bg-blue-700" 
                        data-ruangan-id="{{ $ruangan->id }}"
                        data-ruangan-nama="{{ $ruangan->nama }}"
                        data-ruangan-lantai="{{ $ruangan->lantai }}"
                        data-ruangan-kapasitas="{{ $ruangan->kapasitas }}"
                        data-ruangan-fasilitas="{{ $ruangan->fasilitas }}"
                        data-ruangan-warna="{{ $ruangan->warna }}">
                  Edit
                </button>
        
                <!-- Delete Button -->
                <button class="delete-btn bg-[#E81A1D] text-white px-3 py-1 rounded hover:bg-red-700" 
                  data-ruangan-id="{{ $ruangan->id }}">
                  Delete
                </button>
              </div>
          </div>
      </div>
      @endforeach
    </div>
    
    <!-- Floating Button -->
    <button id="buatRuanganBtn" class="fixed bottom-4 right-4 bg-[#003f7d] text-white p-4 rounded-full shadow-md hover:bg-blue-800">
      <i class="fas fa-plus"></i>
    </button>
    
    <!-- Modal for Create/Edit -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-10">
      <div class="bg-white p-6 rounded-md w-[400px]">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Ruangan Baru</h2>
        <form id="ruanganForm" method="POST">
          @csrf
          <input type="hidden" id="ruanganId" name="_method" value="POST">
        
          <div class="mb-4">
            <label class="block mb-1">Nama Ruangan</label>
            <input id="ruanganNama" name="nama" type="text" class="w-full p-2 border rounded-md" required>
          </div>
        
          <div class="mb-4">
            <label class="block mb-1">Lantai</label>
            <input id="ruanganLantai" name="lantai" type="number" class="w-full p-2 border rounded-md" required>
          </div>
        
          <div class="mb-4">
            <label class="block mb-1">Kapasitas</label>
            <input id="ruanganKapasitas" name="kapasitas" type="number" class="w-full p-2 border rounded-md" required>
          </div>

          <div class="mb-4">
            <label class="block mb-1">Fasilitas</label>
            <input id="ruanganFasilitas" name="fasilitas" type="text" class="w-full p-2 border rounded-md" required>
          </div>
        
          <div class="mb-4">
            <label class="block mb-1">Warna</label>
            <input id="ruanganWarna" name="warna" type="color" class="w-full p-2 border rounded-md" required>
          </div>
        
          <div class="flex justify-end gap-2">
            <button type="button" id="cancelModalBtn" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">Batal</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-800">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-10">
      <div class="bg-white p-6 rounded-md w-[400px]">
        <h2 class="text-xl font-bold mb-4">Apakah kamu yakin?</h2>
        <p class="mb-6">Apakah Anda benar-benar ingin menghapus ruangan ini? Proses ini tidak dapat dibatalkan.</p>
        <form id="deleteForm" method="POST">
          @csrf
          @method('DELETE')
          <div class="flex justify-end gap-2">
            <button type="button" id="cancelDeleteBtn" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">Batal</button>
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => { 
      const createRoomBtn = document.getElementById('buatRuanganBtn');
      const modal = document.getElementById('modal');
      const modalTitle = document.getElementById('modalTitle');
      const ruanganForm = document.getElementById('ruanganForm');
      const cancelModalBtn = document.getElementById('cancelModalBtn');
      const ruanganContainer = document.getElementById('ruanganContainer');

      // Open Modal for Create
      createRoomBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Tambah Ruangan Baru';
        ruanganForm.action = "{{ route('admin.ruangans.store') }}";
        document.getElementById('ruanganId').value = 'POST';
        ruanganForm.reset();
        modal.classList.remove('hidden');
      });
    
      // Open Modal for Edit
      document.querySelectorAll('.edit-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          const ruanganId = btn.dataset.ruanganId;
          const ruanganNama = btn.dataset.ruanganNama;
          const ruanganLantai = btn.dataset.ruanganLantai;
          const ruanganKapasitas = btn.dataset.ruanganKapasitas;
          const ruanganFasilitas = btn.dataset.ruanganFasilitas;
          const ruanganWarna = btn.dataset.ruanganWarna;
        
          modalTitle.textContent = 'Edit Ruangan';
          ruanganForm.action = "{{ route('admin.ruangans.update', ':ruanganId') }}".replace(':ruanganId', ruanganId);
          document.getElementById('ruanganId').value = 'PUT'; // Set method to PUT
          document.getElementById('ruanganNama').value = ruanganNama;
          document.getElementById('ruanganLantai').value = ruanganLantai;
          document.getElementById('ruanganKapasitas').value = ruanganKapasitas;
          document.getElementById('ruanganFasilitas').value = ruanganFasilitas;
          document.getElementById('ruanganWarna').value = ruanganWarna;
        
          modal.classList.remove('hidden');
        });
      });
      
        // Close Modal
        cancelModalBtn.addEventListener('click', () => {
          modal.classList.add('hidden');
        });

      // Open Modal for Delete Confirmation
      document.querySelectorAll('.delete-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          const ruanganId = btn.dataset.ruanganId;
          deleteForm.action = "{{ route('admin.ruangans.destroy', ':ruanganId') }}".replace(':ruanganId', ruanganId);
          
          deleteModal.classList.remove('hidden');
        });
      });
    
      // Close Delete Modal
      cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.classList.add('hidden');
      });
    });

    window.menuIconPath = "{{ asset('icon/menu.svg') }}";

    let sidebar = document.querySelector(".sidebar");

    function toggleSidebar() {
      sidebar.classList.toggle("active");
    }
  </script>
</body>
</html>
