<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 fixed w-full z-30 top-0">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-start">
            <button
              @click="toggleSidebar"
              class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            >
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <a href="#" class="flex ml-2 md:mr-24">
              <div class="h-8 w-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                <span class="text-white font-bold text-sm">RC</span>
              </div>
              <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">RelawanCare</span>
            </a>
          </div>
          <div class="flex items-center">
            <div class="flex items-center ml-3 relative">
              <div>
                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" @click="toggleProfileMenu">
                  <span class="sr-only">Open user menu</span>
                  <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">A</span>
                  </div>
                </button>
                
                <!-- Profile Dropdown -->
                <div v-show="profileMenuOpen" class="absolute right-0 top-10 w-48 bg-white rounded-md shadow-lg py-1 z-50 dark:bg-gray-700">
                  <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">
                    <p class="text-sm text-gray-900 dark:text-white font-semibold">Administrator</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">admin@relawancare.com</p>
                  </div>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                    <i class="fas fa-user mr-2"></i>Profile Settings
                  </a>
                  <form method="POST" action="/logout">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-700 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-600">
                      <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Sidebar -->
    <aside 
      :class="[
        'fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'
      ]"
    >
      <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
          <li>
            <a href="#" class="sidebar-item active" @click="currentView = 'dashboard'">
              <svg class="w-5 h-5 transition duration-300 ease-in-out" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
              </svg>
              <span class="ml-3">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-item" @click="currentView = 'volunteers'">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
              </svg>
              <span class="ml-3">Relawan</span>
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-item" @click="currentView = 'beneficiaries'">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="ml-3">Penerima Manfaat</span>
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-item" @click="currentView = 'activities'">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
              </svg>
              <span class="ml-3">Aktivitas</span>
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-item" @click="currentView = 'reports'">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm3 2v8h2V8H7V6zm4 0v8h2V8h-2V6zm4 0v8h2V8h-2V6z"/>
              </svg>
              <span class="ml-3">Laporan</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
      <div class="p-4 mt-14">
        <!-- Dashboard Content -->
        <div v-if="currentView === 'dashboard'">
          <!-- Statistics Cards -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div 
              v-for="(stat, index) in stats" 
              :key="index"
              class="stats-card"
              :style="{ animationDelay: `${index * 0.1}s` }"
            >
              <div class="p-6">
                <div class="flex items-center">
                  <div :class="stat.iconBg" class="inline-flex items-center justify-center p-3 text-sm font-semibold text-white rounded-lg">
                    <i :class="stat.icon" class="text-lg"></i>
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ stat.label }}</dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ stat.value }}</div>
                        <div v-if="stat.change" :class="stat.change.color" class="ml-2 flex items-baseline text-sm font-semibold">
                          <i :class="stat.change.icon" class="mr-1 text-xs"></i>
                          {{ stat.change.value }}
                        </div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Charts and Tables Section -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
            <!-- Activity Chart -->
            <div class="chart-card">
              <div class="p-6">
                <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white mb-4">Aktivitas Relawan</h5>
                <div class="h-64 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg">
                  <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                      <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">Grafik Aktivitas</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Activities -->
            <div class="table-card">
              <div class="p-6">
                <h5 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Aktivitas Terbaru</h5>
                <div class="space-y-3">
                  <div v-for="(activity, index) in recentActivities" :key="index" class="activity-item">
                    <div class="flex items-center space-x-4">
                      <div :class="activity.iconBg" class="flex items-center justify-center w-10 h-10 rounded-full">
                        <i :class="activity.icon" class="text-white text-sm"></i>
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ activity.description }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ activity.time }}</p>
                      </div>
                      <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <span :class="activity.statusColor" class="px-2 py-1 text-xs font-medium rounded-full">{{ activity.status }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Map Section -->
          <div class="map-card">
            <div class="p-6">
              <h5 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Peta Sebaran Relawan</h5>
              <div class="h-96 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <div class="text-center">
                  <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                  </div>
                  <p class="text-gray-600 dark:text-gray-400 text-lg">Peta Interaktif</p>
                  <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">Menampilkan lokasi dan aktivitas relawan</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Other Views Placeholder -->
        <div v-else class="flex items-center justify-center h-96">
          <div class="text-center">
            <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
              <i class="fas fa-cog text-white text-3xl animate-spin"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ currentView.charAt(0).toUpperCase() + currentView.slice(1) }}</h3>
            <p class="text-gray-600 dark:text-gray-400">Halaman sedang dalam pengembangan</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      sidebarOpen: false,
      profileMenuOpen: false,
      currentView: 'dashboard',
      csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
      stats: [
        {
          label: 'Total Relawan',
          value: '1,247',
          icon: 'fas fa-users',
          iconBg: 'bg-gradient-to-br from-blue-500 to-blue-600',
          change: {
            value: '12.5%',
            color: 'text-green-600',
            icon: 'fas fa-arrow-up'
          }
        },
        {
          label: 'Penerima Manfaat',
          value: '8,352',
          icon: 'fas fa-heart',
          iconBg: 'bg-gradient-to-br from-green-500 to-green-600',
          change: {
            value: '8.2%',
            color: 'text-green-600',
            icon: 'fas fa-arrow-up'
          }
        },
        {
          label: 'Aktivitas Bulan Ini',
          value: '432',
          icon: 'fas fa-clipboard-list',
          iconBg: 'bg-gradient-to-br from-purple-500 to-purple-600',
          change: {
            value: '3.1%',
            color: 'text-red-600',
            icon: 'fas fa-arrow-down'
          }
        },
        {
          label: 'Bantuan Tersalurkan',
          value: 'Rp 2.4M',
          icon: 'fas fa-coins',
          iconBg: 'bg-gradient-to-br from-orange-500 to-orange-600',
          change: {
            value: '15.3%',
            color: 'text-green-600',
            icon: 'fas fa-arrow-up'
          }
        }
      ],
      recentActivities: [
        {
          description: 'Distribusi bantuan pangan di Kecamatan Cibodas',
          time: '2 jam yang lalu',
          status: 'Selesai',
          statusColor: 'bg-green-100 text-green-800',
          icon: 'fas fa-box',
          iconBg: 'bg-gradient-to-br from-green-500 to-green-600'
        },
        {
          description: 'Pendataan penerima manfaat di Desa Sukamaju',
          time: '4 jam yang lalu',
          status: 'Berlangsung',
          statusColor: 'bg-yellow-100 text-yellow-800',
          icon: 'fas fa-clipboard-check',
          iconBg: 'bg-gradient-to-br from-yellow-500 to-orange-500'
        },
        {
          description: 'Verifikasi data KK di Kecamatan Bojongsoang',
          time: '1 hari yang lalu',
          status: 'Selesai',
          statusColor: 'bg-green-100 text-green-800',
          icon: 'fas fa-check-circle',
          iconBg: 'bg-gradient-to-br from-blue-500 to-blue-600'
        }
      ]
    }
  },
  methods: {
    toggleSidebar() {
      this.sidebarOpen = !this.sidebarOpen;
    },
    toggleProfileMenu() {
      this.profileMenuOpen = !this.profileMenuOpen;
    }
  }
}
</script>

<style scoped>
.stats-card {
  @apply bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 transform transition-all duration-500 ease-out opacity-0 translate-y-8;
  animation: slideInUp 0.6s ease-out forwards;
}

.stats-card:hover {
  @apply shadow-xl;
  transform: scale(1.05) translateY(-0.5rem);
}

.chart-card, .table-card, .map-card {
  @apply bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 transform transition-all duration-500 ease-out;
  animation: fadeInScale 0.8s ease-out forwards;
}

.chart-card:hover, .table-card:hover, .map-card:hover {
  @apply shadow-lg;
}

.sidebar-item {
  @apply flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 ease-in-out transform;
}

.sidebar-item:hover {
  transform: scale(1.05) translateX(0.5rem);
}

.sidebar-item.active {
  @apply bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg;
}

.activity-item {
  @apply p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-300 ease-in-out transform hover:shadow-md;
}

.activity-item:hover {
  transform: scale(1.02);
}

@keyframes slideInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInScale {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Mobile responsiveness */
@media (max-width: 640px) {
  .stats-card {
    margin-bottom: 1rem;
  }
}

/* Dark mode transitions */
.dark .stats-card,
.dark .chart-card,
.dark .table-card,
.dark .map-card {
  @apply border-gray-700 bg-gray-800;
}

/* Smooth transitions for all elements */
* {
  transition: all 0.3s ease-in-out;
}
</style>