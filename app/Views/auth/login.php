<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - SIAKAD PPI IZHHAARUL HAQ-ANCOL</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/png">

  <style>
    body {
      background: linear-gradient(135deg, #3730a3, #2563eb, #1e3a8a);
      background-size: 300% 300%;
      animation: gradientShift 10s ease infinite;
    }

    @keyframes gradientShift {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .glass {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    .animate-fadeIn {
      animation: fadeIn 0.8s ease-out forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

  <!-- Splash Screen -->
  <div id="splash" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-black/70 opacity-0 animate-fadeIn">
    <lottie-player 
      src="<?= base_url('assets/lottie/splash.json') ?>" 
      background="transparent" 
      speed="1" 
      style="width: 350px; height: 350px;" 
      autoplay>
    </lottie-player>

    <h1 class="mt-4 text-lg font-semibold text-white">Selamat datang di SIAKAD PPI IZHHAARUL HAQ</h1>

    <!-- Loading Bar -->
    <div class="w-48 h-2 mt-6 bg-white/30 rounded-full overflow-hidden shadow-inner">
      <div id="loadingBar" class="h-full bg-indigo-400 w-0 transition-all duration-[2000ms]"></div>
    </div>
  </div>

  <!-- Login Content -->
  <div id="loginContent" class="hidden w-full max-w-5xl glass p-6 md:p-10 flex flex-col md:flex-row items-center justify-between transition-opacity duration-1000 opacity-0">

    <!-- Form Login -->
    <div class="w-full md:w-1/2">
      <div class="text-center mb-6">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Sekolah" class="mx-auto h-20 drop-shadow-md mb-3">
        <h2 class="text-3xl font-bold text-white">Login Akun</h2>
        <p class="text-sm text-white/70">Silakan isi email dan password kamu</p>
      </div>

      <?php if(session()->getFlashdata('error')) : ?>
        <div class="bg-red-200 text-red-900 px-4 py-2 rounded mb-4 text-sm">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <form method="post" action="/login" class="space-y-4">
        <div>
          <label class="block text-sm text-white mb-1">Email</label>
          <input name="email" type="email" required placeholder="Email"
                 class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md">
        </div>

        <div>
          <label class="block text-sm text-white mb-1">Password</label>
          <div class="relative">
            <input id="password" name="password" type="password" required placeholder="Password"
                   class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md">
            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2">
              <svg id="eyeIcon" class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7
                      c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>

        <button type="submit"
                class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition duration-300">
          Login
        </button>
      </form>

      <p class="text-center text-sm text-white/60 mt-5 italic">Akun dibuat oleh admin sekolah.</p>
    </div>

    <!-- Animasi Login (hanya md ke atas) -->
    <div class="hidden md:flex md:w-1/2 justify-center">
      <lottie-player 
        src="<?= base_url('assets/lottie/login.json') ?>"
        background="transparent"
        speed="1" 
        style="width: 100%; max-width: 360px;" 
        loop autoplay>
      </lottie-player>
    </div>
  </div>

  <script>
    function togglePassword() {
      const pw = document.getElementById("password");
      pw.type = pw.type === "password" ? "text" : "password";
    }

    window.addEventListener('DOMContentLoaded', () => {
      const bar = document.getElementById('loadingBar');
      bar.style.width = '100%';

      setTimeout(() => {
        document.getElementById('splash').classList.add('opacity-0');
        document.getElementById('loginContent').classList.remove('hidden');
        document.getElementById('loginContent').classList.add('opacity-100');

        setTimeout(() => {
          document.getElementById('splash').style.display = 'none';
        }, 800);
      }, 2500);
    });
  </script>

</body>
</html>
