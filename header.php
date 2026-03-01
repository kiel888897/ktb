 <!-- HEADER -->
 <header id="mainHeader"
     class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent">

     <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

         <!-- LOGO -->
         <div class="flex items-center gap-3">
             <img src="assets/img/logo.png" class="h-9">
             <span id="logoNav" class="font-bold text-lg text-white transition-colors">Kusuma Trisna Bali</span>
         </div>

         <!-- DESKTOP NAV -->
         <nav id="desktopNav"
             class="hidden lg:flex gap-10 font-medium text-white transition-colors duration-300">
             <a href="index.php" class="hover:text-primary">Home</a>
             <a href="about.php" class="hover:text-primary">About</a>
             <a href="products.php" class="hover:text-primary">Produk</a>
             <a href="services.php" class="hover:text-primary">Service</a>
             <a href="contact.php" class="hover:text-primary">Kontak</a>
         </nav>

         <!-- CTA -->
         <a id="desktopCTA"
             class="hidden lg:inline-block px-5 py-2 rounded-lg font-semibold transition
      border border-white text-white hover:bg-white hover:text-primary">
             <i class="fa-solid fa-phone-volume"></i>
             +62877-7992-8897
         </a>

         <!-- MOBILE BUTTON -->
         <button id="openMenu"
             class="lg:hidden text-2xl text-white transition">
             <i class="fa fa-bars"></i>
         </button>

     </div>
 </header>

 <!-- MOBILE MENU OVERLAY -->
 <div id="mobileMenu"
     class="fixed inset-0 bg-black/60 z-50 hidden">

     <!-- PANEL -->
     <div class="absolute right-0 top-0 w-4/5 max-w-sm h-full bg-white shadow-2xl
              translate-x-full transition-transform duration-300">

         <!-- HEADER MENU -->
         <div class="flex items-center justify-between p-6 border-b">
             <img src="assets/img/logo.png" class="h-9">
             <button id="closeMenu" class="text-2xl text-gray-700">
                 <i class="fa fa-xmark"></i>
             </button>
         </div>

         <!-- MENU ITEMS -->
         <nav class="p-6 flex flex-col gap-6 text-gray-900 font-semibold text-lg">

             <a href="index.php" class="flex items-center gap-4 hover:text-primary">
                 <i class="fa fa-house text-primary"></i> Home
             </a>

             <a href="about.php" class="flex items-center gap-4 hover:text-primary">
                 <i class="fa fa-building"></i> About
             </a>

             <a href="products.php" class="flex items-center gap-4 hover:text-primary">
                 <i class="fa fa-box"></i> Produk
             </a>

             <a href="services.php" class="flex items-center gap-4 hover:text-primary">
                 <i class="fa fa-screwdriver-wrench"></i> Service
             </a>

             <hr>

             <a href="contact.php" class="flex items-center gap-4 text-primary font-bold">
                 <i class="fa fa-phone"></i> Kontak
             </a>

         </nav>

     </div>
 </div>