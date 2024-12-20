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
    <x-sidebar.user.sidebar-pesanan/>

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
            <h1 class="ml-4 text-[1.75rem] font-bold">Pesanan</h1>
          </div>
        </div>
      </header>
      
      <div id="pesananContainer" class="px-8 pt-[91px] pb-8 overflow-x-auto">
        <!-- Added overflow-x-auto for responsive scrolling -->
        <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-gray-700 dark:text-gray-400">
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">No</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Tanggal Pemesanan</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Kegiatan</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Ruangan</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Jumlah Peserta</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Tanggal</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Waktu Kegiatan</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Surat Izin</th>
              <th scope="col" class="px-4 py-2 bg-gray-50 dark:bg-gray-800">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jadwals as $jadwal)
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <td class="px-4 py-2 break-words whitespace-normal">{{ $loop->iteration }}</td>
              <td class="px-4 py-2 break-words whitespace-normal">{{ $jadwal->created_at->format('d M Y, H:i') }}</td>
              <td class="px-4 py-2 break-words whitespace-normal">{{ $jadwal->nama_kegiatan }}</td>
              <td class="px-4 py-2 break-words whitespace-normal">
                {{ $jadwal->ruangan ? $jadwal->ruangan->nama .' Lantai ' . $jadwal->ruangan->lantai : '-' }}
              </td>
              <td class="px-4 py-2 break-words whitespace-normal">{{ $jadwal->jumlah_peserta }} peserta</td>
              <td class="px-4 py-2 break-words whitespace-normal">{{ $jadwal->tanggal }}</td>
              <td class="px-4 py-2 break-words whitespace-normal">{{ $jadwal->waktu_kegiatan }}</td>
              <td class="px-4 py-2 break-words whitespace-normal">
                <a href="{{ asset('storage/' . $jadwal->surat_ijin) }}" target="_blank" 
                  class="text-blue-600 dark:text-blue-500 hover:underline">File</a>
              </td>
              <td class="px-4 py-2 break-words whitespace-normal">
                <div class="
                  {{ $jadwal->status === 'Menunggu' ? 'bg-gray-300 text-black' : '' }}
                  {{ $jadwal->status === 'Disetujui' ? 'bg-[#00CE1F] text-white' : '' }}
                  {{ $jadwal->status === 'Ditolak' ? 'bg-[#E81A1D] text-white' : '' }}
                  px-4 py-2 rounded text-center inline-block">
                  {{ $jadwal->status }}
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
  
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
