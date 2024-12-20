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
  
  <title>Ruangan</title>
  
</head>
<body>
  <div id="page-content" class="flex">
    <!-- Sidebar Opened -->
    <x-sidebar.guest.sidebar-ruangan/>

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
    <main class="flex-grow">
      <!-- Header -->
      <header class="bg-white border-b border-black fixed top-0 w-full z-10">
        <div class="flex items-center justify-between py-[8px] px-[12px]">
            <div class="flex items-center">
                <h1 class="ml-4 text-[1.75rem] font-bold">Ruangan</h1>
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
                    <p>Kapasitas {{ $ruangan->kapasitas }} orang</p>
                </div>
            </div>
        </div>
        @endforeach
      </div>
    </main>
  </div>
  
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>