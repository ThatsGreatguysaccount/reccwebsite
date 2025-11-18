<template>
  <aside class="customer-sidebar" :class="{ collapsed: isCollapsed }">
    <div class="sidebar-header">
      <router-link to="/customer/dashboard" class="sidebar-logo">
        <img src="/landing/img/logo/logo-white.svg" alt="Logo" class="logo-img" />
      </router-link>
      <button class="sidebar-toggle" @click="toggleSidebar" v-if="!isMobile">
        <i :class="isCollapsed ? 'fa-solid fa-chevron-right' : 'fa-solid fa-chevron-left'"></i>
      </button>
    </div>

    <nav class="sidebar-nav">
      <ul class="sidebar-menu">
        <li class="menu-item">
          <router-link to="/customer/dashboard" class="menu-link" :class="{ active: $route.path === '/customer/dashboard' }" @click="handleMenuClick">
            <i class="fa-solid fa-house"></i>
            <span class="menu-text">Dashboard</span>
          </router-link>
        </li>
        <li class="menu-item">
          <router-link to="/customer/wallet" class="menu-link" :class="{ active: $route.path === '/customer/wallet' }" @click="handleMenuClick">
            <i class="fa-solid fa-wallet"></i>
            <span class="menu-text">Wallet</span>
          </router-link>
        </li>
        <li class="menu-item">
          <router-link to="/customer/settings" class="menu-link" :class="{ active: $route.path === '/customer/settings' }" @click="handleMenuClick">
            <i class="fa-solid fa-user-gear"></i>
            <span class="menu-text">Settings</span>
          </router-link>
        </li>
        <li class="menu-item">
          <router-link to="/customer/password" class="menu-link" :class="{ active: $route.path === '/customer/password' }" @click="handleMenuClick">
            <i class="fa-solid fa-lock"></i>
            <span class="menu-text">Password</span>
          </router-link>
        </li>
        <li class="menu-item">
          <router-link to="/customer/contact" class="menu-link" :class="{ active: $route.path === '/customer/contact' }" @click="handleMenuClick">
            <i class="fa-solid fa-phone"></i>
            <span class="menu-text">Contact</span>
          </router-link>
        </li>
      </ul>
    </nav>

    <div class="sidebar-footer">
      <button class="logout-btn" @click="handleLogout">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span class="menu-text">Logout</span>
      </button>
    </div>
  </aside>
</template>

<script>
export default {
  name: 'CustomerSidebar',
  data() {
    return {
      isCollapsed: false,
      isMobile: false
    }
  },
  mounted() {
    this.checkMobile();
    window.addEventListener('resize', this.checkMobile);
    
    // Check for saved sidebar state
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true') {
      this.isCollapsed = true;
    }
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkMobile);
  },
  methods: {
    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
      localStorage.setItem('sidebarCollapsed', this.isCollapsed.toString());
      this.$emit('sidebar-toggle', this.isCollapsed);
    },
    checkMobile() {
      this.isMobile = window.innerWidth < 1024;
      if (this.isMobile) {
        this.isCollapsed = true;
      }
    },
    handleLogout() {
      // TODO: Implement logout logic
      this.$router.push('/sign-in');
    },
    handleMenuClick() {
      // Close sidebar on mobile when menu item is clicked
      if (this.isMobile) {
        this.$emit('close-mobile');
      }
    }
  }
}
</script>

<style scoped>
.customer-sidebar {
  width: 260px;
  height: 100vh;
  background: #ffffff;
  border-right: 1px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  position: fixed;
  left: 0;
  top: 0;
  transition: width 0.3s ease;
  z-index: 999;
}

[data-mode="dark"] .customer-sidebar {
  background: #1f2937;
  border-right-color: #374151;
}

.customer-sidebar.collapsed {
  width: 80px;
}

.sidebar-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .sidebar-header {
  border-bottom-color: #374151;
}

.sidebar-logo {
  display: flex;
  align-items: center;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.customer-sidebar.collapsed .sidebar-logo {
  opacity: 0;
  width: 0;
  overflow: hidden;
}

.logo-img {
  height: 36px;
  width: auto;
}

.sidebar-toggle {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 6px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s ease;
}

[data-mode="dark"] .sidebar-toggle {
  background: #374151;
  color: #9ca3af;
}

.sidebar-toggle:hover {
  background: #2563eb;
  color: #ffffff;
}

.sidebar-nav {
  flex: 1;
  overflow-y: auto;
  padding: 16px 0;
}

.sidebar-menu {
  list-style: none;
  margin: 0;
  padding: 0;
}

.menu-item {
  margin: 4px 0;
}

.menu-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  color: #6b7280;
  text-decoration: none;
  transition: all 0.2s ease;
  font-size: 14px;
  font-weight: 500;
  margin: 0 8px;
  border-radius: 8px;
}

[data-mode="dark"] .menu-link {
  color: #9ca3af;
}

.menu-link i {
  font-size: 18px;
  width: 20px;
  text-align: center;
  flex-shrink: 0;
}

.menu-text {
  transition: opacity 0.3s ease;
}

.customer-sidebar.collapsed .menu-text {
  opacity: 0;
  width: 0;
  overflow: hidden;
}

.menu-link:hover {
  background: #f3f4f6;
  color: #2563eb;
}

[data-mode="dark"] .menu-link:hover {
  background: #374151;
  color: #60a5fa;
}

.menu-link.active {
  background: #2563eb;
  color: #ffffff;
}

[data-mode="dark"] .menu-link.active {
  background: #2563eb;
  color: #ffffff;
}

.sidebar-footer {
  padding: 16px;
  border-top: 1px solid #e5e7eb;
}

[data-mode="dark"] .sidebar-footer {
  border-top-color: #374151;
}

.logout-btn {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  background: #fef2f2;
  border: none;
  border-radius: 8px;
  color: #dc2626;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 14px;
  font-weight: 500;
}

[data-mode="dark"] .logout-btn {
  background: #7f1d1d;
  color: #fca5a5;
}

.logout-btn:hover {
  background: #fee2e2;
  color: #b91c1c;
}

[data-mode="dark"] .logout-btn:hover {
  background: #991b1b;
  color: #fca5a5;
}

.logout-btn i {
  font-size: 18px;
  width: 20px;
  text-align: center;
  flex-shrink: 0;
}

@media (max-width: 1024px) {
  .customer-sidebar {
    transform: translateX(-100%);
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
  }

  .customer-sidebar.mobile-open {
    transform: translateX(0);
    width: 260px;
  }

  .customer-sidebar.collapsed {
    transform: translateX(-100%);
  }

  .customer-sidebar.collapsed.mobile-open {
    transform: translateX(0);
    width: 260px;
  }
}
</style>

