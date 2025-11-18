<template>
  <div class="customer-dashboard">
    <Header @toggle-sidebar="toggleMobileSidebar" />
    
    <!-- Mobile Sidebar Overlay -->
    <div v-if="showMobileSidebar" class="sidebar-overlay" @click="closeMobileSidebar"></div>
    
    <div class="dashboard-wrapper">
      <Sidebar :class="{ 'mobile-open': showMobileSidebar }" @sidebar-toggle="handleSidebarToggle" @close-mobile="closeMobileSidebar" />
      
      <div class="dashboard-content" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <div class="container-fluid">
          <!-- Page Header -->
          <div class="page-header">
            <h4>Website Settings</h4>
          </div>

          <!-- Settings Sections -->
          <div class="settings-section">
            <div class="section-header-row">
              <h4>Company Information</h4>
            </div>
            
            <form @submit.prevent="saveSettings" class="settings-form">
              <div class="settings-grid">
                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input 
                    type="text" 
                    id="company_name" 
                    v-model="settings.company_name" 
                    placeholder="Enter company name"
                  />
                </div>
                
                <div class="form-group">
                  <label for="company_email">Company Email</label>
                  <input 
                    type="email" 
                    id="company_email" 
                    v-model="settings.company_email" 
                    placeholder="support@example.com"
                  />
                </div>
                
                <div class="form-group">
                  <label for="company_phone">Company Phone</label>
                  <input 
                    type="text" 
                    id="company_phone" 
                    v-model="settings.company_phone" 
                    placeholder="+1 (555) 123-4567"
                  />
                </div>
                
                <div class="form-group">
                  <label for="company_number">Alternative Phone</label>
                  <input 
                    type="text" 
                    id="company_number" 
                    v-model="settings.company_number" 
                    placeholder="Alternative phone number"
                  />
                </div>
                
                <div class="form-group full-width">
                  <label for="company_address">Company Address</label>
                  <input 
                    type="text" 
                    id="company_address" 
                    v-model="settings.company_address" 
                    placeholder="123 Main Street, City, State 12345"
                  />
                </div>
                
                <div class="form-group full-width">
                  <label for="company_address_map_url">Map URL</label>
                  <input 
                    type="url" 
                    id="company_address_map_url" 
                    v-model="settings.company_address_map_url" 
                    placeholder="https://maps.google.com/..."
                  />
                </div>
                
                <div class="form-group">
                  <label for="company_website">Website URL</label>
                  <input 
                    type="url" 
                    id="company_website" 
                    v-model="settings.company_website" 
                    placeholder="https://example.com"
                  />
                </div>
                
                <div class="form-group">
                  <label for="company_working_hours">Working Hours</label>
                  <input 
                    type="text" 
                    id="company_working_hours" 
                    v-model="settings.company_working_hours" 
                    placeholder="10:00AM - 10:00PM"
                  />
                </div>
                
                <div class="form-group full-width">
                  <label for="tidio_link">Tidio Link</label>
                  <input 
                    type="text" 
                    id="tidio_link" 
                    v-model="settings.tidio_link" 
                    placeholder="Tidio chat widget link/ID"
                  />
                </div>
              </div>
              
              <div class="form-actions">
                <button type="submit" class="btn-save" :disabled="loading">
                  <span v-if="loading">Saving...</span>
                  <span v-else>Save Settings</span>
                </button>
              </div>
            </form>
          </div>

          <!-- SMTP Settings Section -->
          <div class="settings-section">
            <div class="section-header-row">
              <h4>SMTP Settings (Zoho - Password Recovery)</h4>
            </div>
            
            <form @submit.prevent="saveSMTPSettings" class="settings-form">
              <div class="settings-grid">
                <div class="form-group">
                  <label for="smtp_enabled">Enable SMTP</label>
                  <select id="smtp_enabled" v-model="settings.smtp_enabled">
                    <option :value="true">Enabled</option>
                    <option :value="false">Disabled</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="smtp_host">SMTP Host</label>
                  <input 
                    type="text" 
                    id="smtp_host" 
                    v-model="settings.smtp_host" 
                    placeholder="smtp.zoho.com"
                  />
                </div>
                
                <div class="form-group">
                  <label for="smtp_port">SMTP Port</label>
                  <input 
                    type="number" 
                    id="smtp_port" 
                    v-model="settings.smtp_port" 
                    placeholder="587"
                  />
                </div>
                
                <div class="form-group">
                  <label for="smtp_encryption">Encryption</label>
                  <select id="smtp_encryption" v-model="settings.smtp_encryption">
                    <option value="">None</option>
                    <option value="tls">TLS</option>
                    <option value="ssl">SSL</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="smtp_username">SMTP Username</label>
                  <input 
                    type="text" 
                    id="smtp_username" 
                    v-model="settings.smtp_username" 
                    placeholder="your-email@zoho.com"
                  />
                </div>
                
                <div class="form-group">
                  <label for="smtp_password">SMTP Password</label>
                  <input 
                    type="password" 
                    id="smtp_password" 
                    v-model="settings.smtp_password" 
                    placeholder="Enter SMTP password"
                  />
                </div>
                
                <div class="form-group">
                  <label for="smtp_from_email">From Email</label>
                  <input 
                    type="email" 
                    id="smtp_from_email" 
                    v-model="settings.smtp_from_email" 
                    placeholder="noreply@example.com"
                  />
                </div>
                
                <div class="form-group">
                  <label for="smtp_from_name">From Name</label>
                  <input 
                    type="text" 
                    id="smtp_from_name" 
                    v-model="settings.smtp_from_name" 
                    placeholder="Platform Support"
                  />
                </div>
              </div>
              
              <div class="form-actions">
                <button type="submit" class="btn-save" :disabled="loading">
                  <span v-if="loading">Saving...</span>
                  <span v-else>Save SMTP Settings</span>
                </button>
              </div>
            </form>
          </div>

          <!-- Logo Settings Section -->
          <div class="settings-section">
            <div class="section-header-row">
              <h4>Company Logos</h4>
            </div>
            
            <div class="settings-grid">
              <!-- Main Logo -->
              <div class="form-group full-width">
                <label>Main Logo (for Footer & OffCanvas)</label>
                <div class="logo-upload-wrapper">
                  <div v-if="settings.company_logo" class="logo-preview">
                    <img :src="settings.company_logo" alt="Current logo" />
                    <button type="button" class="btn-remove-logo" @click="removeLogo('logo')">Remove</button>
                  </div>
                  <div v-else class="logo-placeholder">
                    <p>No logo uploaded</p>
                    <p class="logo-default">Default: /landing/img/logo/logo.svg</p>
                  </div>
                  <input 
                    type="file" 
                    ref="logoInput"
                    @change="handleLogoUpload('logo', $event)"
                    accept="image/*"
                    style="display: none"
                  />
                  <button type="button" class="btn-upload" @click="$refs.logoInput.click()">
                    Upload Main Logo
                  </button>
                </div>
              </div>

              <!-- White Logo -->
              <div class="form-group full-width">
                <label>White Logo (for Header & Admin Panel)</label>
                <div class="logo-upload-wrapper">
                  <div v-if="settings.company_logo_white" class="logo-preview">
                    <img :src="settings.company_logo_white" alt="Current white logo" />
                    <button type="button" class="btn-remove-logo" @click="removeLogo('logo_white')">Remove</button>
                  </div>
                  <div v-else class="logo-placeholder">
                    <p>No logo uploaded</p>
                    <p class="logo-default">Default: /landing/img/logo/logo-white.svg</p>
                  </div>
                  <input 
                    type="file" 
                    ref="logoWhiteInput"
                    @change="handleLogoUpload('logo_white', $event)"
                    accept="image/*"
                    style="display: none"
                  />
                  <button type="button" class="btn-upload" @click="$refs.logoWhiteInput.click()">
                    Upload White Logo
                  </button>
                </div>
              </div>

              <!-- Favicon -->
              <div class="form-group full-width">
                <label>Favicon</label>
                <div class="logo-upload-wrapper">
                  <div v-if="settings.company_favicon" class="logo-preview">
                    <img :src="settings.company_favicon" alt="Current favicon" style="max-width: 32px; max-height: 32px;" />
                    <button type="button" class="btn-remove-logo" @click="removeLogo('favicon')">Remove</button>
                  </div>
                  <div v-else class="logo-placeholder">
                    <p>No favicon uploaded</p>
                    <p class="logo-default">Default: /landing/img/logo/favicon.svg</p>
                  </div>
                  <input 
                    type="file" 
                    ref="faviconInput"
                    @change="handleLogoUpload('favicon', $event)"
                    accept="image/*"
                    style="display: none"
                  />
                  <button type="button" class="btn-upload" @click="$refs.faviconInput.click()">
                    Upload Favicon
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Success/Error Message -->
          <div v-if="message" :class="['message', messageType]" style="margin-top: 24px;">
            {{ message }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Header from '../components/layouts/Header.vue'
import Sidebar from '../components/layouts/Sidebar.vue'

export default {
  name: 'AdminSettings',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      loading: false,
      message: '',
      messageType: '',
      settings: {
        company_name: '',
        company_email: '',
        company_phone: '',
        company_number: '',
        company_address: '',
        company_address_map_url: '',
        company_website: '',
        company_working_hours: '',
        tidio_link: '',
        company_logo: '',
        company_logo_white: '',
        company_favicon: '',
        smtp_enabled: false,
        smtp_host: '',
        smtp_port: '',
        smtp_encryption: '',
        smtp_username: '',
        smtp_password: '',
        smtp_from_email: '',
        smtp_from_name: ''
      }
    }
  },
  mounted() {
    this.loadSettings();
  },
  methods: {
    handleSidebarToggle(collapsed) {
      this.sidebarCollapsed = collapsed;
    },
    toggleMobileSidebar() {
      this.showMobileSidebar = !this.showMobileSidebar;
    },
    closeMobileSidebar() {
      this.showMobileSidebar = false;
    },
    async loadSettings() {
      try {
        const response = await axios.get('/api/v1/admin/settings');
        if (response.data.success && response.data.data) {
          const data = response.data.data;
          // Map settings to form data
          Object.keys(this.settings).forEach(key => {
            if (data[key] !== undefined) {
              this.settings[key] = data[key];
            }
          });
        }
      } catch (error) {
        console.error('Error loading settings:', error);
      }
    },
    async saveSettings() {
      this.loading = true;
      this.message = '';
      try {
        const companySettings = {
          company_name: this.settings.company_name,
          company_email: this.settings.company_email,
          company_phone: this.settings.company_phone,
          company_number: this.settings.company_number,
          company_address: this.settings.company_address,
          company_address_map_url: this.settings.company_address_map_url,
          company_website: this.settings.company_website,
          company_working_hours: this.settings.company_working_hours,
          tidio_link: this.settings.tidio_link
        };
        
        const response = await axios.post('/api/v1/admin/settings', companySettings);
        if (response.data.success) {
          this.message = 'Company settings saved successfully!';
          this.messageType = 'success';
          setTimeout(() => {
            this.message = '';
          }, 3000);
        }
      } catch (error) {
        this.message = error.response?.data?.message || 'Failed to save settings';
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },
    async saveSMTPSettings() {
      this.loading = true;
      this.message = '';
      try {
        const smtpSettings = {
          smtp_enabled: this.settings.smtp_enabled,
          smtp_host: this.settings.smtp_host,
          smtp_port: this.settings.smtp_port,
          smtp_encryption: this.settings.smtp_encryption,
          smtp_username: this.settings.smtp_username,
          smtp_password: this.settings.smtp_password,
          smtp_from_email: this.settings.smtp_from_email,
          smtp_from_name: this.settings.smtp_from_name
        };
        
        const response = await axios.post('/api/v1/admin/settings/smtp', smtpSettings);
        if (response.data.success) {
          this.message = 'SMTP settings saved successfully!';
          this.messageType = 'success';
          setTimeout(() => {
            this.message = '';
          }, 3000);
        }
      } catch (error) {
        this.message = error.response?.data?.message || 'Failed to save SMTP settings';
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },
    async handleLogoUpload(logoType, event) {
      const file = event.target.files[0];
      if (!file) return;

      this.loading = true;
      this.message = '';
      
      try {
        const formData = new FormData();
        formData.append('logo', file);
        formData.append('logo_type', logoType);

        const response = await axios.post('/api/v1/admin/settings/upload-logo', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        if (response.data.success) {
          // Update the setting in local state
          const settingKey = 'company_' + logoType;
          this.settings[settingKey] = response.data.data.logo_url;
          
          this.message = 'Logo uploaded successfully!';
          this.messageType = 'success';
          setTimeout(() => {
            this.message = '';
          }, 3000);
        }
      } catch (error) {
        this.message = error.response?.data?.message || 'Failed to upload logo';
        this.messageType = 'error';
      } finally {
        this.loading = false;
        // Reset input
        event.target.value = '';
      }
    },
    async removeLogo(logoType) {
      if (!confirm('Are you sure you want to remove this logo? It will revert to the default.')) {
        return;
      }

      try {
        const settingKey = 'company_' + logoType;
        this.settings[settingKey] = '';
        
        // Optionally, you could also delete from database here
        // For now, just clearing the local state will make it use defaults
        
        this.message = 'Logo removed. Default logo will be used.';
        this.messageType = 'success';
        setTimeout(() => {
          this.message = '';
        }, 3000);
      } catch (error) {
        this.message = 'Failed to remove logo';
        this.messageType = 'error';
      }
    }
  }
}
</script>

<style scoped>
/* Inherit customer dashboard styles */
.customer-dashboard {
  min-height: 100vh;
  background: #f9fafb;
  display: flex;
  flex-direction: column;
}

[data-mode="dark"] .customer-dashboard {
  background: #111827;
}

.dashboard-wrapper {
  display: flex;
  margin-top: 73px;
  min-height: calc(100vh - 73px);
}

.dashboard-content {
  flex: 1;
  margin-left: 260px;
  padding: 24px;
  transition: margin-left 0.3s ease;
  width: calc(100% - 260px);
  overflow-x: hidden;
}

.dashboard-content.sidebar-collapsed {
  margin-left: 80px;
  width: calc(100% - 80px);
}

.container-fluid {
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
  padding: 0;
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 998;
  display: none;
}

@media (max-width: 1024px) {
  .sidebar-overlay {
    display: block;
  }
  
  .dashboard-content {
    margin-left: 0 !important;
    width: 100% !important;
    padding: 16px;
  }
  
  .dashboard-content.sidebar-collapsed {
    margin-left: 0 !important;
    width: 100% !important;
  }
  
  .dashboard-wrapper {
    margin-top: 60px;
  }
  
  .customer-dashboard {
    overflow-x: hidden;
  }
  
  .container-fluid {
    padding: 0;
  }
}

@media (max-width: 768px) {
  .dashboard-content {
    padding: 12px;
  }
}

.page-header {
  margin-bottom: 32px;
}

.page-header h4 {
  font-size: 28px;
  font-weight: 700;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .page-header h4 {
  color: #f9fafb;
}

.settings-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  margin-bottom: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .settings-section {
  background: #1f2937;
}

.section-header-row {
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .section-header-row {
  border-bottom-color: #374151;
}

.section-header-row h4 {
  font-size: 20px;
  font-weight: 700;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .section-header-row h4 {
  color: #f9fafb;
}

.settings-form {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.settings-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .form-group label {
  color: #f9fafb;
}

.form-group input,
.form-group select {
  padding: 12px 16px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  background: #ffffff;
  color: #181818;
  transition: all 0.2s ease;
  font-family: inherit;
  width: 100%;
}

[data-mode="dark"] .form-group input,
[data-mode="dark"] .form-group select {
  background: #374151;
  border-color: #4b5563;
  color: #f9fafb;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  padding-top: 8px;
}

.btn-save {
  padding: 12px 24px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

.btn-save:hover:not(:disabled) {
  background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}

.btn-save:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.message {
  padding: 12px 16px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
}

.message.success {
  background: #d1fae5;
  color: #059669;
  border: 1px solid #a7f3d0;
}

[data-mode="dark"] .message.success {
  background: rgba(16, 185, 129, 0.2);
  color: #34d399;
  border: 1px solid rgba(16, 185, 129, 0.3);
}

.message.error {
  background: #fee2e2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

[data-mode="dark"] .message.error {
  background: rgba(220, 38, 38, 0.2);
  color: #f87171;
  border: 1px solid rgba(220, 38, 38, 0.3);
}

@media (max-width: 768px) {
  .settings-section {
    padding: 16px;
  }

  .settings-grid {
    grid-template-columns: 1fr;
  }
}

.logo-upload-wrapper {
  display: flex;
  flex-direction: column;
  gap: 16px;
  padding: 20px;
  border: 2px dashed #e5e7eb;
  border-radius: 8px;
  background: #f9fafb;
}

[data-mode="dark"] .logo-upload-wrapper {
  background: #1f2937;
  border-color: #374151;
}

.logo-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.logo-preview img {
  max-width: 200px;
  max-height: 100px;
  object-fit: contain;
  border-radius: 4px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.logo-placeholder {
  text-align: center;
  padding: 20px;
  color: #6b7280;
}

[data-mode="dark"] .logo-placeholder {
  color: #9ca3af;
}

.logo-default {
  font-size: 12px;
  color: #9ca3af;
  margin-top: 8px;
}

[data-mode="dark"] .logo-default {
  color: #6b7280;
}

.btn-upload {
  padding: 10px 20px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: #ffffff;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-upload:hover {
  background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
  transform: translateY(-1px);
}

.btn-remove-logo {
  padding: 6px 12px;
  background: #ef4444;
  color: #ffffff;
  border: none;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-remove-logo:hover {
  background: #dc2626;
}
</style>

