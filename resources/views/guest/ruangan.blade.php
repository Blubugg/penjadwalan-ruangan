<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />

  <!-- Styles / Scripts -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root {
      --primary-color: #003f7d;
    }
  </style>

  <title>Ruangan</title>
</head>
<body class="bg-white text-gray-800 font-sans relative min-h-screen w-full overflow-hidden">
  <x-sidebar.guest.sidebar-ruangan />

  <!-- Main Content -->
  <main class="home_content">
    <!-- Header -->
    <header class="bg-[#003f7d] text-white fixed top-0 h-[71px] w-full z-10 border-b border-white">
      <div class="flex items-center justify-between py-[14px] px-[12px]">
        <div class="flex items-center">
          <button id="menuButton" class="text-white text-3xl px-[13px]" onclick="toggleSidebar()">
            <img src="{{ asset('icon/menu.svg') }}" alt="Menu" class="navIcon w-[26px] h-[26px]">
          </button>
          <h1 class="ml-3 text-[1.75rem] font-bold text-white">Ruangan</h1>
        </div>
      </div>
    </header>

    <!-- Room Cards -->
    <div id="ruanganContainer" class="grid grid-cols-1 px-8 pt-[91px] pb-8 md:grid-cols-2 gap-8">
      @foreach ($ruangans as $ruangan)
      <div class="bg-white rounded-lg shadow-lg overflow-hidden relative" data-ruangan-id="{{ $ruangan->id }}">
        <div class="h-24" style="background-color: {{ $ruangan->warna ?? '#003f7d' }};"></div>
        <div class="p-4 flex flex-col h-full">
          <div class="flex-grow">
            <h2 class="text-lg font-bold text-black">{{ $ruangan->nama }}</h2>
            <p class="text-gray-700">Lantai {{ $ruangan->lantai }}</p>
            <p class="text-gray-700">Kapasitas {{ $ruangan->kapasitas }} orang</p>
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
