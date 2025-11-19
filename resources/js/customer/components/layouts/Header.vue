<template>
  <header class="customer-header">
    <nav class="header-nav">
      <div class="header-left">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" @click="$emit('toggle-sidebar')" v-if="isMobile">
          <i class="fa-solid fa-bars"></i>
        </button>
        
        <!-- Logo -->
        <div class="logo-section">
          <router-link to="/customer/dashboard" class="logo-link">
            <img src="/landing/img/logo/logo-white.svg" alt="Logo" class="logo-img" />
          </router-link>
        </div>
      </div>

      <div class="header-right">
        <!-- Dark Mode Toggle -->
        <div class="header-action">
          <button class="action-btn" @click="toggleDarkMode" :title="isDarkMode ? 'Light Mode' : 'Dark Mode'">
            <i :class="isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon'"></i>
          </button>
        </div>

        <!-- Notifications -->
        <div class="header-action">
          <button class="action-btn" @click="toggleNotifications" title="Notifications">
            <i class="fa-solid fa-bell"></i>
            <span v-if="notificationCount > 0" class="notification-badge">{{ notificationCount }}</span>
          </button>
        </div>

        <!-- User Profile Dropdown -->
        <div class="user-profile-dropdown" :class="{ active: showUserMenu }">
          <button class="user-profile-btn" @click="toggleUserMenu">
            <img :src="userAvatar" alt="User" class="user-avatar" />
            <i class="fa-solid fa-chevron-down dropdown-icon"></i>
          </button>
          <div class="user-menu" v-if="showUserMenu">
            <router-link to="/customer/settings" class="user-menu-item" @click="showUserMenu = false">
              <i class="fa-solid fa-gear"></i>
              <span>Settings</span>
            </router-link>
            <a href="#" class="user-menu-item" @click.prevent="handleLogout">
              <i class="fa-solid fa-right-from-bracket"></i>
              <span>Logout</span>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'CustomerHeader',
  data() {
    return {
      isDarkMode: false,
      showUserMenu: false,
      notificationCount: 0,
      userAvatar: '/customer/images/user.png',
      isMobile: false
    }
  },
  mounted() {
    // Check for saved dark mode preference
    const savedMode = localStorage.getItem('darkMode');
    if (savedMode === 'true') {
      this.isDarkMode = true;
      document.documentElement.setAttribute('data-mode', 'dark');
    }

    // Check if mobile
    this.checkMobile();
    window.addEventListener('resize', this.checkMobile);

    // Close user menu when clicking outside
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkMobile);
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    toggleDarkMode() {
      this.isDarkMode = !this.isDarkMode;
      if (this.isDarkMode) {
        document.documentElement.setAttribute('data-mode', 'dark');
        localStorage.setItem('darkMode', 'true');
      } else {
        document.documentElement.removeAttribute('data-mode');
        localStorage.setItem('darkMode', 'false');
      }
    },
    toggleNotifications() {
      // TODO: Implement notifications dropdown
      console.log('Notifications clicked');
    },
    toggleUserMenu() {
      this.showUserMenu = !this.showUserMenu;
    },
    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.showUserMenu = false;
      }
    },
    async handleLogout() {
      try {
        // Call logout API to invalidate token on server
        await window.axios.post('/api/v1/auth/logout');
      } catch (error) {
        // Even if API call fails, continue with client-side logout
        console.error('Logout API call failed:', error);
      } finally {
        // Clear local storage
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
        // Redirect to sign-in
        this.$router.push('/sign-in');
      }
    },
    checkMobile() {
      this.isMobile = window.innerWidth < 1024;
    }
  }
}
</script>

<style scoped>
.customer-header {
  background: #ffffff;
  border-bottom: 1px solid #e5e7eb;
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .customer-header {
  background: #1f2937;
  border-bottom-color: #374151;
}

.header-nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 24px;
  gap: 24px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 32px;
}

.mobile-menu-toggle {
  display: none;
  width: 40px;
  height: 40px;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 8px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-right: 12px;
}

[data-mode="dark"] .mobile-menu-toggle {
  background: #374151;
  color: #9ca3af;
}

.mobile-menu-toggle:hover {
  background: #2563eb;
  color: #ffffff;
}

.mobile-menu-toggle i {
  font-size: 18px;
}

@media (max-width: 1024px) {
  .mobile-menu-toggle {
    display: flex;
  }
}

.logo-section {
  flex-shrink: 0;
}

.logo-link {
  display: flex;
  align-items: center;
}

.logo-img {
  height: 40px;
  width: auto;
}


.header-right {
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-action {
  position: relative;
}

.action-btn {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 8px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
}

[data-mode="dark"] .action-btn {
  background: #374151;
  color: #9ca3af;
}

.action-btn:hover {
  background: #2563eb;
  color: #ffffff;
}

.notification-badge {
  position: absolute;
  top: -4px;
  right: -4px;
  background: #ef4444;
  color: #ffffff;
  font-size: 10px;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 10px;
  min-width: 18px;
  text-align: center;
}

.user-profile-dropdown {
  position: relative;
}

.user-profile-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  border-radius: 8px;
  transition: background 0.2s ease;
}

.user-profile-btn:hover {
  background: #f3f4f6;
}

[data-mode="dark"] .user-profile-btn:hover {
  background: #374151;
}

.user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  object-fit: cover;
}

.dropdown-icon {
  font-size: 12px;
  color: #6b7280;
  transition: transform 0.2s ease;
}

.user-profile-dropdown.active .dropdown-icon {
  transform: rotate(180deg);
}

.user-menu {
  position: absolute;
  top: calc(100% + 8px);
  right: 0;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  min-width: 180px;
  padding: 8px;
  z-index: 1000;
}

[data-mode="dark"] .user-menu {
  background: #1f2937;
  border-color: #374151;
}

.user-menu-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  color: #374151;
  text-decoration: none;
  border-radius: 6px;
  transition: all 0.2s ease;
  font-size: 14px;
}

[data-mode="dark"] .user-menu-item {
  color: #e5e7eb;
}

.user-menu-item i {
  font-size: 16px;
  color: #6b7280;
  width: 20px;
}

[data-mode="dark"] .user-menu-item i {
  color: #9ca3af;
}

.user-menu-item:hover {
  background: #f3f4f6;
  color: #2563eb;
}

[data-mode="dark"] .user-menu-item:hover {
  background: #374151;
  color: #60a5fa;
}

.user-menu-item:hover i {
  color: #2563eb;
}

[data-mode="dark"] .user-menu-item:hover i {
  color: #60a5fa;
}

@media (max-width: 768px) {
  .customer-header {
    position: sticky;
    top: 0;
    z-index: 1000;
  }

  .header-nav {
    padding: 12px 16px;
    gap: 12px;
  }

  .header-left {
    gap: 12px;
  }

  .logo-img {
    height: 32px;
  }

  .action-btn {
    width: 36px;
    height: 36px;
  }

  .user-avatar {
    width: 32px;
    height: 32px;
  }

  .mobile-menu-toggle {
    width: 36px;
    height: 36px;
    margin-right: 8px;
  }
}
</style>

