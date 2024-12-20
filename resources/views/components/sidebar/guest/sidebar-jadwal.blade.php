<aside id="default-sidebar">
   <div id="menu-sidebar" class="flex py-[16px] mr-[16px] items-center justify-end">
     <button id="menuButton" class="text-black text-3xl" onclick="toggleSidebar()">
       <img src="{{ asset('icon/close-menu.svg') }}" alt="navIcon" class="w-[25px] h-[25px]">
     </button>
   </div>
   <hr class="border-0 h-[1px] w-[250px] bg-white">
   <ul id="sidebar-content" class="font-medium">
      <li>
         <div class="flex items-center py-[13px] px-[19px] h-[70px] text-white">
            <svg class="flex justify-center items-center w-[44px] h-[44px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
               <path stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>             
            <a href="/login" class="ms-3">Masuk</a>
         </div>
      </li>
      <li>
         <a href="/jadwal" class="flex items-center justify-center py-[10px] px-[18px] h-[60px] bg-white text-black">
            <svg class="flex justify-center items-center w-[24px] h-[24px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
            </svg> 
            <span class="flex justify-center items-center w-[166px] whitespace-nowrap">Jadwal</span>
         </a>
      </li>
      <li>
         <a href="/ruangan" class="flex items-center justify-center py-[10px] px-[18px] h-[60px] text-white hover:bg-gray-700 group">
            <svg class="flex justify-center items-center w-[24px] h-[24px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18V6h-5v12h5Zm0 0h2M4 18h2.5m3.5-5.5V12M6 6l7-2v16l-7-2V6Z"/>
            </svg>
            <span class="flex justify-center items-center w-[166px] whitespace-nowrap">Ruangan</span>
         </a>
      </li>
   </ul>
 </aside>