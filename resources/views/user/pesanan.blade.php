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
  
  <title>Pesanan</title>

</head>
<body class="relative min-h-screen w-full overflow-hidden">
  <x-sidebar.user.sidebar-pesanan/>
  
  <!-- Main Content -->
  <main class="home_content overflow-y-auto">
    <!-- Header -->
    <header class="bg-[#003f7d] border-b border-white fixed top-0 h-[71px] w-full z-10">
      <div class="flex items-center justify-between py-[14px] px-[12px]">
        <div class="flex items-center">
          <button id="menuButton" class="bg-[#002b5c] py-[6.4px] px-[10.4px] rounded" onclick="toggleSidebar()">
            <img src="{{ asset('icon/menu.svg') }}" alt="Menu" class="navIcon">
          </button>
          <h1 class="ml-4 text-[1.75rem] font-bold text-white">Pesanan</h1>
        </div>
      </div>
    </header>
    
    <div id="pesananContainer" class="px-8 pt-[91px] pb-8">
      <!-- Scrollable Table Wrapper -->
      <div class="overflow-x-auto">
        <div class="max-h-[700px] overflow-y-auto">
          <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-gray-700 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 sticky top-0 z-10">
              <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="col" class="px-4 py-2">No</th>
                <th scope="col" class="px-4 py-2">Tanggal Pemesanan</th>
                <th scope="col" class="px-4 py-2">Kegiatan</th>
                <th scope="col" class="px-4 py-2">Ruangan</th>
                <th scope="col" class="px-4 py-2">Jumlah Peserta</th>
                <th scope="col" class="px-4 py-2">Tanggal</th>
                <th scope="col" class="px-4 py-2">Waktu Kegiatan</th>
                <th scope="col" class="px-4 py-2">Surat Izin</th>
                <th scope="col" class="px-4 py-2">Alasan Penolakan</th>
                <th scope="col" class="px-4 py-2">Status</th>
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
                  @if ($jadwal->status === 'Ditolak')
                    {{ $jadwal->alasan_penolakan }}
                  @else
                    -
                  @endif
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
      </div>
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
