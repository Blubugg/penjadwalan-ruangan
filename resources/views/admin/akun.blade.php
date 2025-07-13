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
  
  <title>Akun</title>

</head>
<body class="relative min-h-screen w-full overflow-hidden">
  <x-sidebar.admin.sidebar-akun/>
  
  <!-- Main Content -->
  <main class="home_content">
    <!-- Header -->
    <header class="bg-[#003f7d] border-b border-white fixed top-0 h-[71px] w-full z-10">
      <div class="flex items-center justify-between py-[14px] px-[12px]">
        <div class="flex items-center">
          <button id="menuButton" class="bg-[#002b5c] py-[6.4px] px-[10.4px] rounded" onclick="toggleSidebar()">
            <img src="{{ asset('icon/menu.svg') }}" alt="Menu" class="navIcon">
          </button>
          <h1 class="ml-4 text-[1.75rem] font-bold text-white">Akun</h1>
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
                <th scope="col" class="px-4 py-2">Tanggal Pembuatan</th>
                <th scope="col" class="px-4 py-2">Nama</th>
                <th scope="col" class="px-4 py-2">Email</th>
                <th scope="col" class="px-4 py-2">Status</th>
                <th scope="col" class="px-4 py-2">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="px-4 py-2 break-words whitespace-normal">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 break-words whitespace-normal">{{ $user->created_at->format('d M Y, H:i') }}</td>
                <td class="px-4 py-2 break-words whitespace-normal">{{ $user->name }}</td>
                <td class="px-4 py-2 break-words whitespace-normal">{{ $user->email }}</td>
                <td class="px-4 py-2 break-words whitespace-normal">
                  <div class="
                    {{ $user->status === 'Menunggu' ? 'bg-gray-300 text-black' : '' }}
                    {{ $user->status === 'Disetujui' ? 'bg-[#00CE1F] text-white' : '' }}
                    {{ $user->status === 'Ditolak' ? 'bg-[#E81A1D] text-white' : '' }}
                    px-4 py-2 rounded text-center inline-block">
                    {{ $user->status }}
                  </div>
                </td>
                <td class="px-4 py-2 break-words whitespace-normal">
                  <div class="flex space-x-2">
                    <!-- Approve button is hidden if status is 'Disetujui' -->
                    @if ($user->status !== 'Disetujui')
                      <form action="{{ route('admin.users.approve', $user) }}" method="POST"> 
                        @csrf
                        <button>
                          <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="30" height="30" rx="5" fill="#00CE1F"/>
                            <path d="M20.6656 8L13.3344 17.6656L9 13.3344L7 15.3344L13.6656 22L23 10L20.6656 8Z" fill="#FFFAFB"/>
                          </svg>                      
                        </button>
                      </form>
                    @endif
                
                    <!-- Reject button is hidden if status is 'Ditolak' -->
                    @if ($user->status !== 'Ditolak')
                      <form action="{{ route('admin.users.reject', $user) }}" method="POST"> 
                        @csrf
                        <button>
                          <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="30" height="30" rx="5" fill="#E81A1D"/>
                            <path d="M10.7892 9.29452L15 13.5051L19.189 9.31634C19.2815 9.21786 19.393 9.13908 19.5167 9.08472C19.6404 9.03036 19.7738 9.00154 19.9089 9C20.1983 9 20.4757 9.11493 20.6803 9.3195C20.8849 9.52407 20.9998 9.80152 20.9998 10.0908C21.0024 10.2246 20.9776 10.3574 20.9269 10.4812C20.8763 10.605 20.8008 10.7172 20.7053 10.8108L16.4618 14.9996L20.7053 19.2429C20.8851 19.4188 20.9905 19.657 20.9998 19.9083C20.9998 20.1976 20.8849 20.4751 20.6803 20.6796C20.4757 20.8842 20.1983 20.9991 19.9089 20.9991C19.7699 21.0049 19.6312 20.9817 19.5016 20.931C19.3721 20.8803 19.2544 20.8032 19.1562 20.7046L15 16.494L10.8001 20.6937C10.708 20.7889 10.5978 20.8649 10.4761 20.9173C10.3544 20.9698 10.2236 20.9976 10.0911 20.9991C9.80174 20.9991 9.52427 20.8842 9.31969 20.6796C9.11511 20.4751 9.00018 20.1976 9.00018 19.9083C8.99763 19.7746 9.02245 19.6417 9.0731 19.5179C9.12375 19.3941 9.19916 19.282 9.29471 19.1884L13.5382 14.9996L9.29471 10.7562C9.11492 10.5804 9.00949 10.3422 9.00018 10.0908C9.00018 9.80152 9.11511 9.52407 9.31969 9.3195C9.52427 9.11493 9.80174 9 10.0911 9C10.3529 9.00327 10.6038 9.10908 10.7892 9.29452Z" fill="#FFFAFB"/>
                          </svg>                      
                        </button>
                      </form>
                    @endif
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
