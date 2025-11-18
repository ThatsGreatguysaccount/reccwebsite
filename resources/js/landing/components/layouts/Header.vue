<template>
  <div>
    <!-- header-area-4 start -->
    <header class="header-area-4">
      <div class="header-top">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-between">
            <div class="col-xl-2 col-lg-4 col-md-6 col-7">
              <div class="logo-wrap-4">
                <router-link to="/">
                  <img :src="settings.company_logo_white || '/landing/img/logo/logo-white.svg'" alt="logo">
                </router-link>
              </div>
            </div>
            <div class="col-xl-10 col-lg-2 col-md-6 col-5 d-flex align-items-center justify-content-end">
              <div class="header-contact-layout style-2 d-none d-xl-flex">
                <div class="header-contact-info">
                  <div class="icon">
                    <img src="/landing/img/icon/call.svg" alt="icon">
                  </div>
                  <div class="content">
                    <p>Call Now</p>
                    <h4>
                      <a :href="`tel:${settings.company_number || settings.company_phone}`">{{ settings.company_number || settings.company_phone || 'N/A' }}</a>
                    </h4>
                  </div>
                </div>
                <div class="header-contact-info">
                  <div class="icon">
                    <img src="/landing/img/icon/map-marker.svg" alt="icon">
                  </div>
                  <div class="content">
                    <p>Location</p>
                    <h4>
                      <a :href="settings.company_address_map_url || '#'" target="_blank">{{ settings.company_address || 'N/A' }}</a>
                    </h4>
                  </div>
                </div>
                <div class="header-contact-info">
                  <div class="icon">
                    <img src="/landing/img/icon/time.svg" alt="icon">
                  </div>
                  <div class="content">
                    <p>Time</p>
                    <h4>{{ settings.company_working_hours }}</h4>
                  </div>
                </div>
              </div>
              
              <div class="open-sidebar" @click="openSidebar" data-open-sidebar>
                <div class="bar-wrap">
                  <div class="bar-1"></div>
                  <div class="bar-2"></div>
                  <div class="bar-3"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="header-bottom d-none d-xl-block">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-12">
              <div class="header-bottom-wrapper">
                <div class="row align-items-center">
                  <div class="col-xl-9 d-none d-xl-block">
                    <div class="main-menu-3">
                      <ul>
                        <li>
                          <router-link to="/">Home</router-link>
                        </li>
                        <li>
                          <router-link to="/practice-areas/divorce">Practice Areas</router-link>
                        </li>
                        <li>
                          <router-link to="/services/discovery-support">Services</router-link>
                        </li>
                        <li>
                          <router-link to="/crime-investigation/corporate-hacks-defi-exploits">Crime investigation</router-link>
                        </li>
                        <li>
                          <router-link to="/about">About Us</router-link>
                        </li>
                        <li>
                          <router-link to="/team">Team</router-link>
                        </li>
                        <li>
                          <router-link to="/contact">Contact</router-link>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-xl-3 d-none d-xl-flex justify-content-end align-items-center">
                    <div class="header-auth-buttons">
                      <router-link to="/sign-in" class="auth-btn auth-btn-login">Log in</router-link>
                      <router-link to="/sign-up" class="auth-btn auth-btn-signup">Sign up</router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- header-area-4 end -->

    <!-- sticky-header-section start -->
    <div class="header-area-6 sticky-header-section" data-header-sticky>
      <div class="header-top d-block d-xl-none">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-between">
            <div class="col-xl-2 col-lg-4 col-md-6 col-7 d-block d-xl-none">
              <div class="logo-wrap">
                <router-link to="/">
                  <img :src="settings.company_logo_white || '/landing/img/logo/logo-white.svg'" alt="logo">
                </router-link>
              </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-5 d-flex align-items-center justify-content-end">
              <div class="open-sidebar" @click="openSidebar" data-open-sidebar>
                <div class="bar-wrap">
                  <div class="bar-1"></div>
                  <div class="bar-2"></div>
                  <div class="bar-3"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="header-bottom d-none d-xl-block">
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-xl-2 col-lg-4">
              <div class="logo-wrap-3">
                <router-link to="/">
                  <img :src="settings.company_logo_white || '/landing/img/logo/logo-white.svg'" alt="logo">
                </router-link>
              </div>
            </div>
            <div class="col-xl-10 d-none d-xl-flex justify-content-end align-items-center">
              <div class="main-menu-2">
                <ul>
                  <li><router-link to="/">Home</router-link></li>
                  <li><router-link to="/practice-areas/divorce">Practice Areas</router-link></li>
                  <li><router-link to="/services/discovery-support">Services</router-link></li>
                  <li><router-link to="/crime-investigation/corporate-hacks-defi-exploits">Crime investigation</router-link></li>
                  <li><router-link to="/about">About Us</router-link></li>
                  <li><router-link to="/team">Team</router-link></li>
                  <li><router-link to="/contact">Contact</router-link></li>
                </ul>
              </div>
              <div class="header-auth-buttons ml-20">
                <router-link to="/sign-in" class="auth-btn auth-btn-login">Log in</router-link>
                <router-link to="/sign-up" class="auth-btn auth-btn-signup">Sign up</router-link>
              </div>
              <div class="d-flex align-items-center ml-20">
                <div class="open-sidebar" @click="openSidebar" data-open-sidebar>
                  <div class="bar-wrap">
                    <div class="bar-1"></div>
                    <div class="bar-2"></div>
                    <div class="bar-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- sticky-header-section end -->
  </div>
</template>

<script>
import { onMounted } from 'vue'
import { useSettings } from '../../composables/useSettings'

export default {
  name: 'Header',
  setup() {
    const { settings, fetchSettings } = useSettings()
    
    onMounted(() => {
      fetchSettings()
    })
    
    return {
      settings
    }
  },
  methods: {
    openSidebar() {
      // Emit event to open sidebar
      this.$emit('open-sidebar');
      // Also trigger the original script behavior if needed
      if (window.dispatchEvent) {
        window.dispatchEvent(new CustomEvent('open-sidebar'));
      }
    }
  }
}
</script>

<style scoped>
.header-auth-buttons {
  display: flex;
  align-items: center;
  gap: 15px;
}

.auth-btn {
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.auth-btn-login {
  color: #fff;
  background: transparent;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.auth-btn-login:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.5);
  color: #fff;
}

.auth-btn-signup {
  color: #fff;
  background: #2563eb;
  border: 1px solid #2563eb;
}

.auth-btn-signup:hover {
  background: #1e40af;
  border-color: #1e40af;
  color: #fff;
}

@media (max-width: 1199px) {
  .header-auth-buttons {
    gap: 10px;
  }
  
  .auth-btn {
    padding: 8px 16px;
    font-size: 13px;
  }
}
</style>

