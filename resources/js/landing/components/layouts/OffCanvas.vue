<template>
  <div class="off-canvas-section" :class="{ 'active': isOpen }">
    <div class="off-canvas-wrap" :class="{ 'active': isOpen }">
      <div class="off-canvas-head mb-30">
        <div class="logo">
          <router-link to="/" @click="closeSidebar">
            <img :src="settings.company_logo || '/landing/img/logo/logo.svg'" alt="logo">
          </router-link>
        </div>
        <div class="off-canvas-close" @click="closeSidebar">
          <i class="fa-regular fa-xmark"></i>
        </div>
      </div>
      <div class="off-canvas-body">
        <div class="d-xl-none d-block mb-40">
          <div class="off-canvas-menu">
            <ul>
              <li><router-link to="/" @click="closeSidebar">Home</router-link></li>
              <li><router-link to="/practice-areas/divorce" @click="closeSidebar">Practice Areas</router-link></li>
              <li><router-link to="/services/discovery-support" @click="closeSidebar">Services</router-link></li>
              <li><router-link to="/crime-investigation/corporate-hacks-defi-exploits" @click="closeSidebar">Crime investigation</router-link></li>
              <li><router-link to="/about" @click="closeSidebar">About Us</router-link></li>
              <li><router-link to="/team" @click="closeSidebar">Team</router-link></li>
              <li><router-link to="/contact" @click="closeSidebar">Contact</router-link></li>
            </ul>
          </div>
        </div>
        
        <!-- Login/Sign Up buttons - visible on all screen sizes -->
        <div class="off-canvas-auth-buttons mb-40">
          <router-link to="/sign-in" class="off-canvas-auth-btn off-canvas-auth-btn-login" @click="closeSidebar">Log in</router-link>
          <router-link to="/sign-up" class="off-canvas-auth-btn off-canvas-auth-btn-signup" @click="closeSidebar">Sign up</router-link>
        </div>

        <div class="d-block mb-30">
          <div class="info-widget mb-20">
            <h4 class="offset-title mb-20">About Us</h4>
            <p class="mb-30">
              Since our inception, {{ settings.company_name || 'our company' }} has built a strong reputation for exceptional cryptocurrency-forensic expertise, catering to individuals, small businesses, enterprises, and law enforcement.
            </p>
            <p class="mb-30">
              With a proven history and dedication to excellence, we are your reliable partner in navigating the intricate world of cryptocurrency.
            </p>
          </div>
          <div class="sidebar-contact-layout mb-20">
            <div class="sidebar-contact-info">
              <div class="icon">
                <img src="/landing/img/icon/call-black.svg" alt="icon">
              </div>
              <div class="content">
                <p>Call Now</p>
                <h4>
                  <a :href="`tel:${settings.company_number || settings.company_phone}`">{{ settings.company_number || settings.company_phone || 'N/A' }}</a>
                </h4>
              </div>
            </div>
            <div class="sidebar-contact-info">
              <div class="icon">
                <img src="/landing/img/icon/map-marker-black.svg" alt="icon">
              </div>
              <div class="content">
                <p>Location</p>
                <h4>
                  <a :href="settings.company_address_map_url || '#'" target="_blank">{{ settings.company_address || 'N/A' }}</a>
                </h4>
              </div>
            </div>
            <div class="sidebar-contact-info">
              <div class="icon">
                <img src="/landing/img/icon/time-black.svg" alt="icon">
              </div>
              <div class="content">
                <p>Time</p>
                <h4>{{ settings.company_working_hours }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="off-canvas-overlay" @click="closeSidebar"></div>
  </div>
</template>

<script>
import { onMounted } from 'vue'
import { useSettings } from '../../composables/useSettings'

export default {
  name: 'OffCanvas',
  setup() {
    const { settings, fetchSettings } = useSettings()
    
    onMounted(() => {
      fetchSettings()
    })
    
    return {
      settings
    }
  },
  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    closeSidebar() {
      this.$emit('close-sidebar');
    }
  },
  watch: {
    isOpen(newVal) {
      if (newVal) {
        document.body.style.overflow = 'hidden';
        document.body.classList.add('stop-scroll');
      } else {
        document.body.style.overflow = '';
        document.body.classList.remove('stop-scroll');
      }
    }
  }
}
</script>

<style scoped>
.off-canvas-auth-buttons {
  display: flex;
  flex-direction: column;
  gap: 15px;
  padding: 0;
  width: 100%;
}

.off-canvas-auth-btn {
  padding: 12px 20px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  text-align: center;
  transition: all 0.3s ease;
  display: block;
}

.off-canvas-auth-btn-login {
  color: #181818;
  background: transparent;
  border: 1px solid #181818;
}

.off-canvas-auth-btn-login:hover {
  background: #f5f5f5;
  color: #181818;
}

.off-canvas-auth-btn-signup {
  color: #fff;
  background: #2563eb;
  border: 1px solid #2563eb;
}

.off-canvas-auth-btn-signup:hover {
  background: #1e40af;
  border-color: #1e40af;
  color: #fff;
}
</style>

