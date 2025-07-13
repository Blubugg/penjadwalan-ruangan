<aside class="sidebar sidebar-offcanvas">
  <div class="sidebar-header">
    <div class="logo text-white flex h-[70px] w-full py-0 px-[25px] items-center">
      <img src="{{ asset('icon/Icon-LokaSana.svg') }}" alt="LokaSana Logo" class="min-w-[50px] w-[30px] h-[30px] object-contain mr-2">
      <div class="logo_name text-[20px] font-normal" style="font-family: 'Product Sans', 'Poppins', 'Nunito Sans', sans-serif;">
        LokaSana
      </div>
    </div>
  </div>

  <hr class="border-0 h-[1px] w-[250px] bg-white">

  <ul class="font-medium">

    <li class="my-[5px] py-[10px] px-[25px] flex items-center">
      <i class='bx bx-user-circle flex justify-center items-center min-w-[50px] text-[50px] text-center text-white'></i>

      <!-- User Details -->
      <div class="flex flex-col ms-3" title="{{ Auth::user()->name }}">
        <span class="user font-bold text-[14px] text-white truncate whitespace-nowrap overflow-hidden max-w-[100px]">
          {{ collect(explode(' ', Auth::user()->name))->take(2)->implode(' ') }}
        </span>
      </div>

      <!-- Logout Button -->
      <form method="POST" action="{{ route('logout') }}" class="ml-auto" title="Keluar">
        @csrf
        <button type="submit" class="flex items-center text-white hover:text-yellow-400">
          <i class="fas fa-sign-out-alt text-sm"></i>
        </button>
      </form>
    </li>

    <li>
      <div class="text-white py-[10px] px-[10px]">
        <a href="/user/jadwal/buat"
           title="Tambah Jadwal Baru"
           class="border border-white rounded-lg text-center hover:bg-yellow-400 hover:text-blue-900 px-[15px] !h-[80px]">
          <i class='bx bxs-plus-square min-w-[50px] text-[40px] text-center'></i>
          <span class="links_name">Buat Jadwal</span>
        </a>
      </div>
    </li>

    <li>
      <a href="/user/jadwal"
         title="Lihat Jadwal Anda"
         class="text-white hover:bg-yellow-400 hover:text-blue-900 py-[10px] px-[25px]">
        <i class='bx bx-calendar-event min-w-[50px] text-[24px] text-center'></i>
        <span class="links_name">Jadwal</span>
      </a>
    </li>

    <li>
      <a href="/user/ruangan"
         title="Lihat Daftar Ruangan"
         class="text-white hover:bg-yellow-400 hover:text-blue-900 py-[10px] px-[25px]">
        <i class='bx bxs-door-open min-w-[50px] text-[24px] text-center'></i>
        <span class="links_name">Ruangan</span>
      </a>
    </li>

    <li>
      <a href="/user/pesanan"
         title="Lihat Daftar Pesanan"
         class="bg-yellow-400 text-blue-900 py-[10px] px-[25px]">
        <i class='bx bx-clipboard min-w-[50px] text-[24px] text-center'></i>
        <span class="links_name">Pesanan</span>
      </a>
    </li>

  </ul>
</aside>