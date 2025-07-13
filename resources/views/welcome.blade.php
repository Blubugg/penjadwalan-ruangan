<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistem Penjadwalan Ruangan – Inspektorat DIY</title>
  @vite('resources/css/app.css') <!-- Tailwind CSS -->
  <style>
    :root {
      --primary-color: #003f7d;
    }
  </style>
</head>
<body class="bg-white text-gray-800 font-sans min-h-screen">

  <!-- Header -->
  <header class="bg-gradient-to-r from-blue-900 to-blue-600 text-white">
    <div class="container mx-auto px-6 py-6 flex justify-between items-center">
      <div class="flex items-end space-x-4">
        <img src="{{ asset('icon/Icon-LokaSana.svg') }}" alt="LokaSana Logo" class="h-9">
        <div>
            <h1 class="text-[36px] font-bold leading-none">LokaSana</h1>
        </div>
      </div>
      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-4 items-center">
        <a href="#fitur" class="hover:underline">Fitur</a>
        <a href="#tentang" class="hover:underline">Tentang</a>
        <a href="{{ route('login') }}" class="bg-blue-900 text-white font-semibold px-4 py-2 rounded hover:bg-blue-800 text-sm">
          Masuk
        </a>
      </nav>

      <!-- Mobile Navigation -->
      <div class="md:hidden relative">
        <button id="menuToggle" class="focus:outline-none text-white">
          <!-- Hamburger Icon -->
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div id="mobileMenu" class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded shadow-lg hidden z-50">
          <a href="#fitur" class="block px-4 py-2 hover:bg-gray-100 mobile-link">Fitur</a>
          <a href="#tentang" class="block px-4 py-2 hover:bg-gray-100 mobile-link">Tentang</a>
          <a href="{{ route('login') }}" class="block px-4 py-2 bg-blue-900 text-white hover:bg-blue-800 rounded-b mobile-link">Masuk</a>
        </div>
      </div>
    </div>

    <div class="container mx-auto px-6 text-left py-12">
      <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Kelola Jadwal<br>Ruang Rapat</h2>
      <p class="text-lg text-yellow-200 mb-6">Efisien, Terstruktur, dan Transparan</p>
      <a href="{{ route('login') }}" class="bg-yellow-400 text-blue-900 font-semibold px-6 py-3 rounded hover:bg-yellow-300 text-sm">
        Ajukan Pemesanan Sekarang
      </a>
    </div>
  </header>

  <!-- Fitur Utama -->
  <section id="fitur" class="py-12 bg-white">
    <div class="container mx-auto px-6">
      <h3 class="text-2xl font-bold mb-6">Fitur Utama</h3>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      
        <!-- Lihat Jadwal -->
        <div class="bg-gray-50 rounded-lg p-4 shadow hover:shadow-md text-left">
          <div class="flex items-center mb-2">
            <!-- Calendar Icon -->
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <h4 class="font-semibold text-lg">Lihat Jadwal</h4>
          <p class="text-sm text-gray-600">Tampilkan seluruh jadwal ruangan dalam tampilan kalender</p>
        </div>
      
        <!-- Buat Pemesanan -->
        <div class="bg-gray-50 rounded-lg p-4 shadow hover:shadow-md text-left">
          <div class="flex items-center mb-2">
            <!-- Pencil on Document -->
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.121 2.121 0 113 3L11 15.35 7 16l.65-4 9.212-8.513zM19 13v6a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6"/>
            </svg>
          </div>
          <h4 class="font-semibold text-lg">Buat Pemesanan</h4>
          <p class="text-sm text-gray-600">Ajukan pemesanan ruang rapat langsung dari sistem</p>
        </div>
      
        <!-- Lihat Ruangan -->
        <div class="bg-gray-50 rounded-lg p-4 shadow hover:shadow-md text-left">
          <div class="flex items-center mb-2">
            <!-- Meeting Room Icon -->
            <svg class="w-10 h-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V4.5a.5.5 0 01.5-.5l11.25-1.5a.5.5 0 01.5.5V21M14 10h.01" />
            </svg>
          </div>
          <h4 class="font-semibold text-lg">Lihat Ruangan</h4>
          <p class="text-sm text-gray-600">Informasi detail mengenai ruangan, kapasitas, dan fasilitas</p>
        </div>
      
        <!-- Histori Pesanan -->
        <div class="bg-gray-50 rounded-lg p-4 shadow hover:shadow-md text-left">
          <div class="flex items-center mb-2">
            <!-- History / Order Icon -->
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h4 class="font-semibold text-lg">Histori Pesanan</h4>
          <p class="text-sm text-gray-600">Riwayat pemesanan yang pernah dilakukan, lengkap dengan statusnya</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Tentang Section -->
  <section id="tentang" class="py-16 bg-gray-100">
      <div class="container mx-auto px-6 text-center">
          <h3 class="text-3xl font-bold mb-4 text-gray-800">Tentang Sistem</h3>
          <p class="text-gray-700 max-w-3xl mx-auto leading-relaxed">
              Sistem ini dikembangkan untuk meningkatkan efisiensi dan transparansi dalam pengelolaan ruang rapat di lingkungan kerja Inspektorat Daerah Istimewa Yogyakarta. Dengan antarmuka yang ramah pengguna dan fitur lengkap, proses pemesanan ruangan kini dapat dilakukan secara digital, cepat, dan terdokumentasi dengan baik.
          </p>
      </div>
  </section>

  <!-- Bantuan -->
  <section class="bg-yellow-400 text-blue-900 py-6 text-center font-semibold text-sm">
    Butuh Bantuan? Hubungi Tim Support di 
    <a 
      href="https://mail.google.com/mail/?view=cm&fs=1&to=lokasana.info@gmail.com" 
      target="_blank" 
      rel="noopener noreferrer" 
      class="underline"
    >
      lokasana.info@gmail.com
    </a>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 space-y-10">
    <div class="container mx-auto px-6 flex flex-wrap justify-between text-sm space-y-6 md:space-y-0">
    <!-- Kolom 1: Media Sosial -->
    <div class="w-full md:w-1/3">
      <h5 class="font-semibold mb-2">Media Sosial</h5>
      <a href="https://www.instagram.com/inspektoratdiy/" target="_blank" rel="noopener noreferrer" class="inline-block text-white hover:text-yellow-300">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7zm4.75-.75a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5z"/>
        </svg>
      </a>
    </div>
  
    <!-- Kolom 2: Kontak -->
    <div class="w-full md:w-1/3">
      <h5 class="font-semibold mb-2">Kontak</h5>
      <p>Email : inspektorat@jogjaprov.go.id</p>
      <p>Telepon : +62 274 562 009</p>
    </div>
  
    <!-- Kolom 3: Alamat + Logo sejajar dan logo di ujung -->
    <div class="w-full md:w-1/3 flex justify-between items-end gap-4">
      <div>
        <h5 class="font-semibold mb-2">Alamat</h5>
        <p>
          Jalan Cendana No. 40, Semaki, Kec. Umbulharjo,<br>
          Kota Yogyakarta, Daerah Istimewa Yogyakarta 55166
        </p>
      </div>
      <img src="{{ asset('images/logo-diy.png') }}" alt="Logo DIY" class="h-16">
    </div>
  </div>



    <div class="text-center mt-6 text-xs">
      &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
    </div>
  </footer>

  <script>
    const menuToggle = document.getElementById("menuToggle");
    const mobileMenu = document.getElementById("mobileMenu");
    const mobileLinks = document.querySelectorAll(".mobile-link");
    
    menuToggle.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  
    mobileLinks.forEach(link => {
      link.addEventListener("click", () => {
        mobileMenu.classList.add("hidden");
      });
    });
  </script>

</body>
</html>
