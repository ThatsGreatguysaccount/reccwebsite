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
            <h4>Contact Us</h4>
            <p>Get in touch with our support team</p>
          </div>

          <div class="contact-content">
            <div class="contact-box">
              <div class="contact-info">
                <h4>Contact Information</h4>
                <div class="contact-details">
                  <div class="contact-item">
                    <div class="contact-icon">
                      <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                      <h5>Email</h5>
                      <p>{{ contactInfo.email }}</p>
                    </div>
                  </div>
                  <div class="contact-item">
                    <div class="contact-icon">
                      <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="contact-text">
                      <h5>Phone</h5>
                      <p>{{ contactInfo.phone }}</p>
                    </div>
                  </div>
                  <div class="contact-item">
                    <div class="contact-icon">
                      <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="contact-text">
                      <h5>Address</h5>
                      <p>{{ contactInfo.address }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="contact-form-section">
                <h4>Send us a Message</h4>
                <form @submit.prevent="submitContactForm" class="contact-form">
                  <div v-if="message" :class="['message', messageType]">
                    {{ message }}
                  </div>

                  <div class="form-group">
                    <label for="subject">Subject</label>
                    <input 
                      type="text" 
                      id="subject" 
                      v-model="formData.subject" 
                      required 
                      placeholder="Enter message subject"
                    />
                  </div>

                  <div class="form-group">
                    <label for="message">Message</label>
                    <textarea 
                      id="message" 
                      v-model="formData.message" 
                      required 
                      rows="6"
                      placeholder="Enter your message here..."
                    ></textarea>
                  </div>

                  <button type="submit" class="btn-submit" :disabled="loading">
                    <span v-if="loading">Sending...</span>
                    <span v-else>Send Message</span>
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
  name: 'CustomerContact',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      contactInfo: {
        email: 'support@example.com',
        phone: '+1 (555) 123-4567',
        address: '123 Main Street, City, State 12345'
      },
      formData: {
        subject: '',
        message: ''
      },
      message: '',
      messageType: '',
      loading: false
    }
  },
  mounted() {
    this.loadContactInfo();
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
    async loadContactInfo() {
      try {
        const response = await axios.get('/api/v1/customer/contact/info');
        if (response.data.success && response.data.data) {
          this.contactInfo = {
            email: response.data.data.email,
            phone: response.data.data.phone,
            address: response.data.data.address
          };
        }
      } catch (error) {
        console.error('Error loading contact info:', error);
      }
    },
    async submitContactForm() {
      this.message = '';
      this.loading = true;

      try {
        const response = await axios.post('/api/v1/customer/contact', this.formData);
        
        if (response.data.success) {
          this.message = 'Message sent successfully! We will get back to you soon.';
          this.messageType = 'success';
        } else {
          throw new Error(response.data.message || 'Failed to send message');
        }
        
        // Reset form
        this.formData = {
          subject: '',
          message: ''
        };

        // Clear message after 5 seconds
        setTimeout(() => {
          this.message = '';
        }, 5000);
      } catch (error) {
        if (error.response && error.response.data) {
          this.message = error.response.data.message || 'Failed to send message';
        } else {
          this.message = 'Failed to send message. Please try again.';
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
  width: calc(100% - 260px);
  overflow-x: hidden;
}

.dashboard-content.sidebar-collapsed {
  margin-left: 80px;
  width: calc(100% - 80px);
}

.container-fluid {
  max-width: 1200px;
  margin: 0 auto;
  width: 100%;
  padding: 0;
}

/* Page Header */
.page-header {
  margin-bottom: 32px;
  text-align: center;
}

.page-header h4 {
  font-size: 24px;
  font-weight: 700;
  color: #181818;
  margin: 0 0 8px 0;
}

[data-mode="dark"] .page-header h4 {
  color: #f9fafb;
}

.page-header p {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
}

[data-mode="dark"] .page-header p {
  color: #9ca3af;
}

/* Contact Content */
.contact-content {
  width: 100%;
}

.contact-box {
  width: 100%;
  background: transparent;
  border-radius: 12px;
  padding: 0;
  box-shadow: none;
  display: grid;
  grid-template-columns: 1fr 1.5fr;
  gap: 24px;
  border: none;
  transition: all 0.2s ease;
}

[data-mode="dark"] .contact-box {
  background: transparent;
  border: none;
  box-shadow: none;
}

.contact-info {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #ffffff;
  padding: 32px;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .contact-info {
  background: #1f2937;
  border-color: #374151;
}

.contact-form-section {
  width: 100%;
  background: #f9fafb;
  padding: 32px;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .contact-form-section {
  background: #111827;
  border-color: #374151;
}

.contact-info h4,
.contact-form-section h4 {
  font-size: 20px;
  font-weight: 700;
  color: #181818;
  margin: 0 0 24px 0;
  text-align: center;
}

[data-mode="dark"] .contact-info h4,
[data-mode="dark"] .contact-form-section h4 {
  color: #f9fafb;
}

.contact-details {
  display: flex;
  flex-direction: column;
  gap: 32px;
  align-items: center;
  justify-content: center;
}

.contact-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 12px;
  width: 100%;
}

.contact-icon {
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #dbeafe;
  color: #2563eb;
  border-radius: 12px;
  flex-shrink: 0;
  transition: all 0.2s ease;
}

[data-mode="dark"] .contact-icon {
  background: rgba(37, 99, 235, 0.2);
  color: #60a5fa;
}

.contact-icon i {
  font-size: 24px;
}

.contact-text {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}

.contact-text h5 {
  font-size: 14px;
  font-weight: 600;
  color: #6b7280;
  margin: 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

[data-mode="dark"] .contact-text h5 {
  color: #9ca3af;
}

.contact-text p {
  font-size: 15px;
  color: #181818;
  margin: 0;
  font-weight: 500;
}

[data-mode="dark"] .contact-text p {
  color: #f9fafb;
}

.contact-form {
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

.form-group input,
.form-group textarea {
  padding: 12px 16px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  background: #ffffff;
  color: #181818;
  transition: all 0.2s ease;
  font-family: inherit;
}

[data-mode="dark"] .form-group input,
[data-mode="dark"] .form-group textarea {
  background: #374151;
  border-color: #4b5563;
  color: #f9fafb;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

[data-mode="dark"] .form-group input:focus,
[data-mode="dark"] .form-group textarea:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.form-group textarea {
  resize: vertical;
  min-height: 120px;
}

.btn-submit {
  padding: 14px 24px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  align-self: flex-start;
  box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

[data-mode="dark"] .btn-submit {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.btn-submit:hover:not(:disabled) {
  background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}

[data-mode="dark"] .btn-submit:hover:not(:disabled) {
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-submit:disabled {
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
    margin-left: 0 !important;
    width: 100% !important;
    padding: 16px;
  }

  .dashboard-content.sidebar-collapsed {
    margin-left: 0 !important;
    width: 100% !important;
  }

  .container-fluid {
    padding: 0;
  }

  .contact-box {
    grid-template-columns: 1fr;
    gap: 24px;
  }

  .contact-info,
  .contact-form-section {
    padding: 24px;
  }
}

@media (max-width: 768px) {
  .dashboard-wrapper {
    margin-top: 60px;
  }

  .dashboard-content {
    padding: 12px;
  }

  .contact-info,
  .contact-form-section {
    padding: 20px;
  }
}

@media (max-width: 480px) {
  .dashboard-content {
    padding: 8px;
  }

  .contact-box {
    gap: 16px;
  }

  .contact-info,
  .contact-form-section {
    padding: 16px;
  }

  .contact-details {
    gap: 24px;
  }

  .contact-item {
    gap: 10px;
  }

  .contact-icon {
    width: 48px;
    height: 48px;
  }

  .contact-icon i {
    font-size: 20px;
  }
}
</style>

