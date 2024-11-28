
 <!-- 
  
 ♥
 created by @atsorgu
 ♥

 -->
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta name="description" content="Domain ve birçok sorgu yapabileceğiniz ücretsiz hizmet!"> 
    <meta name="keywords" content="sorgu, sorgu at, sorgulat, sorguat, at sorgu, sorgu whois, alan adı sorgula, ip sorgula, proxy sorgula, whois check, proxy bypasss"> 
    <meta name="author" content="@atsorgu"> 
    <meta name="robots" content="index, follow"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorgu.at - Domain & IP Sorgulama Aracı</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="icon" href="query.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen text-white" x-data="{ activeTab: 'domain' }">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center mb-2">Sorgu.at</h1>
 <!-- Google Fonts  -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

<!-- Beta Yüklenme Çubuğu -->
<div class="fixed top-0 left-0 w-full bg-red-800 text-white font-bold text-center py-1 z-50" style="font-family: 'Poppins', sans-serif;">
    <div class="flex justify-center items-center space-x-2">
        <span class="text-lg">BETA 🛠️️</span>
        <div class="progress w-1/4 bg-gray-700 rounded-full overflow-hidden" style="height: 6px;">
            <div class="progress-bar bg-white h-full rounded-full" style="width: 35%; animation: loadingBar 3s infinite;"></div>
        </div>
    </div>
</div>
<!-- Beta Yüklenme Çubuğu -->



        
        <p class="text-center text-gray-400 mb-8">Domain, IP ve Port Sorgulama Aracı</p>

        <!-- Üst Butonlar -->
        <div class="flex justify-center space-x-4 mb-8">
            <button @click="activeTab = 'domain'" 
                    :class="{'bg-blue-600': activeTab === 'domain', 'bg-gray-700': activeTab !== 'domain'}"
                    class="px-6 py-2 rounded-full transition duration-300">
                <i class="fas fa-globe mr-2"></i>Domain Sorgula
            </button>
            <button @click="activeTab = 'ip'" 
                    :class="{'bg-blue-600': activeTab === 'ip', 'bg-gray-700': activeTab !== 'ip'}"
                    class="px-6 py-2 rounded-full transition duration-300">
                <i class="fas fa-network-wired mr-2"></i>IP Sorgula
            </button>
            <button @click="activeTab = 'port'" 
                    :class="{'bg-blue-600': activeTab === 'port', 'bg-gray-700': activeTab !== 'port'}"
                    class="px-6 py-2 rounded-full transition duration-300">
                <i class="fas fa-plug mr-2"></i>Port Tara
            </button>
        </div>

        
        <!-- Form -->
        <div class="max-w-2xl mx-auto">
            <!-- Domain Form -->
            <form x-show="activeTab === 'domain'" action="process.php" method="POST" class="space-y-4">
                <input type="hidden" name="type" value="domain">
                <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="domain" placeholder="google.com" 
                               class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-magnifying-glass mr-2"></i>Sorgula
                    </button>
                </div>
            </form>

            <!-- IP Form -->
            <form x-show="activeTab === 'ip'" action="process.php" method="POST" class="space-y-4">
                <input type="hidden" name="type" value="ip">
                <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
                    <div class="relative">
                        <i class="fas fa-network-wired absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="ip" placeholder="127.0.0.1" 
                               class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-magnifying-glass mr-2"></i>Sorgula
                    </button>
                </div>
            </form>

            <!-- Port Form -->
            <form x-show="activeTab === 'port'" action="process.php" method="POST" class="space-y-4">
                <input type="hidden" name="type" value="port">
                <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
                    <div class="relative mb-4">
                        <i class="fas fa-network-wired absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="ip" placeholder="IP Adresi" 
                               class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex space-x-4">
                        <div class="relative w-1/2">
                            <i class="fas fa-play absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="start_port" placeholder="Başlangıç Portu" 
                                   class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="relative w-1/2">
                            <i class="fas fa-stop absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="end_port" placeholder="Bitiş Portu" 
                                   class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-radar mr-2"></i>Portları Tara
                    </button>
                </div>
            </form>
        </div>
        

        <!-- Sonuçlar -->
        <div id="results" class="max-w-4xl mx-auto mt-8">
        </div>
    </div>
  <!-- Sayfanın Sol Ortasında Sabit İletişim Kutusu     
  <div class="fixed left-0 top-1/2 transform -translate-y-1/2 flex flex-col space-y-6 ml-4">
        Telegram 
        <a href="https://t.me/atsorgu" target="_blank" class="bg-transparent hover:bg-blue-600 text-white p-3 rounded-full border border-blue-600 shadow-md hover:shadow-lg transition duration-300">
            <i class="fab fa-telegram-plane text-2xl"></i>
        </a>
        s WhatsApp 
        <a href="https://wa.me/yourwhatsappnumber" target="_blank" class="bg-transparent hover:bg-green-600 text-white p-3 rounded-full border border-green-600 shadow-md hover:shadow-lg transition duration-300">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div> -->

     <!-- Telegram İkonu Sol Alt Köşede Sabit -->
     <div class="fixed left-4 bottom-4 flex flex-col space-y-4">
        <a href="https://t.me/atsorgu" target="_blank" class="bg-transparent hover:bg-blue-600 text-white p-3 rounded-full border border-blue-600 shadow-md hover:shadow-lg transition duration-300">
            <i class="fab fa-telegram-plane text-2xl"></i>
        </a>
    </div>
    <script src="results.js"></script>
        <!-- Alt Çizgi ve Telif Hakkı -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; 2024 Sorgu.at - Tüm hakları saklıdır.
                    <span class="block md:inline mt-2 md:mt-0 md:ml-4">
                        <i class="fas fa-code text-blue-500"></i> ile <i class="fas fa-heart text-red-500"></i> tarafından yapıldı
                    </span>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>


 <!-- 
  
 ♥
 created by @atsorgu
 ♥

 -->