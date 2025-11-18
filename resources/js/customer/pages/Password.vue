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
            <h4>Change Password</h4>
          </div>

          <div class="password-content">
            <div class="password-box">
              <div class="password-box-header">
                <h4>Update Password</h4>
                <p>Enter your current password and choose a new one</p>
              </div>
              <div class="password-box-body">
                <form @submit.prevent="changePassword" class="password-form">
                  <div v-if="message" :class="['message', messageType]">
                    {{ message }}
                  </div>

                  <div class="form-group">
                    <label for="oldPassword">Current Password</label>
                    <input 
                      type="password" 
                      id="oldPassword" 
                      v-model="passwordData.oldPassword" 
                      required 
                      placeholder="Enter your current password"
                    />
                  </div>

                  <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input 
                      type="password" 
                      id="newPassword" 
                      v-model="passwordData.newPassword" 
                      required 
                      placeholder="Enter your new password"
                      :class="{ 'error': errors.newPassword }"
                    />
                    <span v-if="errors.newPassword" class="error-text">{{ errors.newPassword }}</span>
                  </div>

                  <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input 
                      type="password" 
                      id="confirmPassword" 
                      v-model="passwordData.confirmPassword" 
                      required 
                      placeholder="Confirm your new password"
                      :class="{ 'error': errors.confirmPassword }"
                    />
                    <span v-if="errors.confirmPassword" class="error-text">{{ errors.confirmPassword }}</span>
                  </div>

                  <div class="password-requirements">
                    <p class="requirements-title">Password Requirements:</p>
                    <ul>
                      <li :class="{ 'valid': passwordData.newPassword.length >= 8 }">
                        At least 8 characters
                      </li>
                      <li :class="{ 'valid': /[A-Z]/.test(passwordData.newPassword) }">
                        One uppercase letter
                      </li>
                      <li :class="{ 'valid': /[a-z]/.test(passwordData.newPassword) }">
                        One lowercase letter
                      </li>
                      <li :class="{ 'valid': /[0-9]/.test(passwordData.newPassword) }">
                        One number
                      </li>
                    </ul>
                  </div>

                  <button type="submit" class="btn-change-password" :disabled="loading">
                    <span v-if="loading">Updating...</span>
                    <span v-else>Change Password</span>
                  </button>
                </form>
              </div>
            </div>
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
  name: 'CustomerPassword',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      passwordData: {
        oldPassword: '',
        newPassword: '',
        confirmPassword: ''
      },
      errors: {},
      message: '',
      messageType: '',
      loading: false
    }
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
    validatePassword() {
      this.errors = {};
      
      if (this.passwordData.newPassword.length < 8) {
        this.errors.newPassword = 'Password must be at least 8 characters';
        return false;
      }

      if (!/[A-Z]/.test(this.passwordData.newPassword)) {
        this.errors.newPassword = 'Password must contain at least one uppercase letter';
        return false;
      }

      if (!/[a-z]/.test(this.passwordData.newPassword)) {
        this.errors.newPassword = 'Password must contain at least one lowercase letter';
        return false;
      }

      if (!/[0-9]/.test(this.passwordData.newPassword)) {
        this.errors.newPassword = 'Password must contain at least one number';
        return false;
      }

      if (this.passwordData.newPassword !== this.passwordData.confirmPassword) {
        this.errors.confirmPassword = 'Passwords do not match';
        return false;
      }

      return true;
    },
    async changePassword() {
      this.message = '';
      this.errors = {};

      if (!this.validatePassword()) {
        return;
      }

      this.loading = true;

      try {
        const response = await axios.post('/api/v1/customer/password/change', {
          old_password: this.passwordData.oldPassword,
          new_password: this.passwordData.newPassword,
          new_password_confirmation: this.passwordData.confirmPassword
        });

        if (response.data.success) {
          this.message = 'Password updated successfully!';
          this.messageType = 'success';
        } else {
          throw new Error(response.data.message || 'Failed to change password');
        }
        
        // Reset form
        this.passwordData = {
          oldPassword: '',
          newPassword: '',
          confirmPassword: ''
        };

        // Clear message after 5 seconds
        setTimeout(() => {
          this.message = '';
        }, 5000);
      } catch (error) {
        if (error.response && error.response.data) {
          if (error.response.data.errors) {
            const errors = error.response.data.errors;
            this.message = Object.values(errors).flat().join(', ') || error.response.data.message || 'Failed to change password';
          } else {
            this.message = error.response.data.message || 'Failed to change password';
          }
        } else {
          this.message = 'Failed to change password. Please try again.';
        }
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>
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
}

.dashboard-content.sidebar-collapsed {
  margin-left: 80px;
}

.container-fluid {
  max-width: 800px;
  margin: 0 auto;
}

/* Page Header */
.page-header {
  margin-bottom: 32px;
}

.page-header h4 {
  font-size: 24px;
  font-weight: 700;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .page-header h4 {
  color: #f9fafb;
}

/* Password Content */
.password-content {
  display: flex;
  justify-content: center;
}

.password-box {
  width: 100%;
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .password-box {
  background: #1f2937;
}

.password-box-header {
  margin-bottom: 32px;
  text-align: center;
}

.password-box-header h4 {
  font-size: 24px;
  font-weight: 700;
  color: #181818;
  margin: 0 0 8px 0;
}

[data-mode="dark"] .password-box-header h4 {
  color: #f9fafb;
}

.password-box-header p {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
}

[data-mode="dark"] .password-box-header p {
  color: #9ca3af;
}

.password-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
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

.message.error {
  background: #fee2e2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .form-group label {
  color: #f9fafb;
}

.form-group input {
  padding: 12px 16px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  background: #ffffff;
  color: #181818;
  transition: all 0.2s ease;
}

[data-mode="dark"] .form-group input {
  background: #374151;
  border-color: #4b5563;
  color: #f9fafb;
}

.form-group input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-group input.error {
  border-color: #dc2626;
}

.error-text {
  font-size: 12px;
  color: #dc2626;
  margin-top: 4px;
}

.password-requirements {
  margin-top: 8px;
  padding: 16px;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .password-requirements {
  background: #374151;
  border-color: #4b5563;
}

.requirements-title {
  font-size: 13px;
  font-weight: 600;
  color: #181818;
  margin: 0 0 8px 0;
}

[data-mode="dark"] .requirements-title {
  color: #f9fafb;
}

.password-requirements ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.password-requirements li {
  font-size: 12px;
  color: #6b7280;
  display: flex;
  align-items: center;
  gap: 8px;
}

[data-mode="dark"] .password-requirements li {
  color: #9ca3af;
}

.password-requirements li::before {
  content: '○';
  font-size: 16px;
  color: #d1d5db;
}

.password-requirements li.valid {
  color: #059669;
}

.password-requirements li.valid::before {
  content: '✓';
  color: #059669;
}

.btn-change-password {
  padding: 14px 24px;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: 8px;
}

.btn-change-password:hover:not(:disabled) {
  background: #1e40af;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-change-password:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Sidebar Overlay */
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
    margin-left: 0;
    padding: 16px;
  }

  .dashboard-content.sidebar-collapsed {
    margin-left: 0;
  }
}

@media (max-width: 768px) {
  .dashboard-wrapper {
    margin-top: 60px;
  }

  .dashboard-content {
    padding: 12px;
  }

  .password-box {
    padding: 24px;
  }
}

@media (max-width: 480px) {
  .dashboard-content {
    padding: 8px;
  }

  .password-box {
    padding: 20px;
  }
}
</style>

