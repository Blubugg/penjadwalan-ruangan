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
  <x-sidebar.user.sidebar-ruangan/>
  
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
              <div class="flex-grow">
                  <h2 class="text-lg font-bold">{{ $ruangan->nama }}</h2>
                  <p>Lantai {{ $ruangan->lantai }}</p>
                  <p>Kapasitas: {{ $ruangan->kapasitas }} orang</p>
                  <p>Fasilitas: {{ $ruangan->fasilitas }}</p>
              </div>
          </div>
      </div>
      @endforeach
    </div>
  </main>

  <script>
    window.menuIconPath = "{{ asset('icon/menu.svg') }}";

    let sidebar = document.querySelector(".sidebar");

    function toggleSidebar() {
      sidebar.classList.toggle("active");
    }
  </script>
</body>
</html>
