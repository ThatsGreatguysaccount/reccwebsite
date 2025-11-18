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
            <h4>Settings</h4>
          </div>

          <div class="settings-content">
            <div class="row">
              <!-- Account Settings -->
              <div class="col-xxl-6">
                <div class="settings-box">
                  <div class="settings-box-header">
                    <h4>Account Settings</h4>
                  </div>
                  <div class="settings-box-body">
                    <form class="settings-form">
                      <div class="form-row">
                        <div class="form-group">
                          <label for="firstName">First Name</label>
                          <input type="text" id="firstName" v-model="userData.firstName" readonly />
                        </div>
                        <div class="form-group">
                          <label for="lastName">Last Name</label>
                          <input type="text" id="lastName" v-model="userData.lastName" readonly />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" v-model="userData.email" readonly />
                      </div>

                      <!-- Verification Status -->
                      <div class="verification-section">
                        <h5>Verification Status</h5>
                        
                        <div v-if="!userData.idVerified && !userData.bankVerified" class="verification-status error">
                          <strong>Your ID and Bank are not verified.</strong>
                        </div>
                        <div v-else-if="userData.idVerified && !userData.bankVerified" class="verification-status warning">
                          <strong>Your ID is verified, but your Bank is not verified.</strong>
                        </div>
                        <div v-else-if="!userData.idVerified && userData.bankVerified" class="verification-status warning">
                          <strong>Your Bank is verified, but your ID is not verified.</strong>
                        </div>
                        <div v-else class="verification-status success">
                          <strong>You are fully verified.</strong>
                        </div>

                        <!-- ID Verification -->
                        <div v-if="!userData.idVerified" class="verification-upload">
                          <div class="form-group">
                            <label>Front Side of ID</label>
                            <div class="upload-container">
                              <img :src="idFrontPreview || '/customer/images/placeholder.png'" alt="ID Front" class="upload-preview" />
                              <button type="button" class="upload-btn" @click="triggerFileInput('frontId')">
                                <i class="fa-solid fa-upload"></i>
                              </button>
                              <input type="file" ref="frontIdInput" @change="handleFileUpload($event, 'frontId')" accept="image/*" style="display: none;" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Back Side of ID</label>
                            <div class="upload-container">
                              <img :src="idBackPreview || '/customer/images/placeholder.png'" alt="ID Back" class="upload-preview" />
                              <button type="button" class="upload-btn" @click="triggerFileInput('backId')">
                                <i class="fa-solid fa-upload"></i>
                              </button>
                              <input type="file" ref="backIdInput" @change="handleFileUpload($event, 'backId')" accept="image/*" style="display: none;" />
                            </div>
                          </div>
                        </div>
                        <div v-else class="verification-status success">
                          <strong>Your ID is verified.</strong>
                        </div>

                        <!-- Bank Verification -->
                        <div v-if="!userData.bankVerified" class="verification-upload">
                          <div class="form-group">
                            <label>Bank Statement</label>
                            <div class="upload-container">
                              <img :src="bankStatementPreview || '/customer/images/placeholder.png'" alt="Bank Statement" class="upload-preview" />
                              <button type="button" class="upload-btn" @click="triggerFileInput('bankStatement')">
                                <i class="fa-solid fa-upload"></i>
                              </button>
                              <input type="file" ref="bankStatementInput" @change="handleFileUpload($event, 'bankStatement')" accept="image/*,.pdf" style="display: none;" />
                            </div>
                          </div>
                        </div>
                        <div v-else class="verification-status success">
                          <strong>Your bank is verified.</strong>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Address Settings -->
              <div class="col-xxl-6">
                <div class="settings-box">
                  <div class="settings-box-header">
                    <h4>Address</h4>
                  </div>
                  <div class="settings-box-body">
                    <form class="settings-form" @submit.prevent="saveAddress">
                      <div class="form-group">
                        <label for="country">Location</label>
                        <input type="text" id="country" v-model="addressData.country" required />
                      </div>
                      <div class="form-row">
                        <div class="form-group">
                          <label for="address1">Address Line 1</label>
                          <input type="text" id="address1" v-model="addressData.address1" required />
                        </div>
                        <div class="form-group">
                          <label for="address2">Address Line 2</label>
                          <input type="text" id="address2" v-model="addressData.address2" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="zipCode">Zip Code</label>
                        <input type="text" id="zipCode" v-model="addressData.zipCode" required />
                      </div>
                      <button type="submit" class="btn-save">Save Address</button>
                    </form>
                  </div>
                </div>
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
  name: 'CustomerSettings',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      userData: {
        firstName: 'John',
        lastName: 'Doe',
        email: 'john.doe@example.com',
        idVerified: false,
        bankVerified: false
      },
      addressData: {
        country: '',
        address1: '',
        address2: '',
        zipCode: ''
      },
      idFrontPreview: null,
      idBackPreview: null,
      bankStatementPreview: null
    }
  },
  mounted() {
    this.loadSettingsData();
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
    async loadSettingsData() {
      try {
        const response = await axios.get('/api/v1/customer/settings');
        if (response.data.success && response.data.data) {
          const data = response.data.data;
          this.userData = {
            username: data.user.username,
            email: data.user.email,
            firstName: data.user.first_name || '',
            lastName: data.user.last_name || '',
            uid: data.user.uid,
            idVerificationStatus: data.user.id_verification_status,
            bankVerificationStatus: data.user.bank_verification_status,
            frontId: data.user.front_id,
            backId: data.user.back_id,
            bankStatement: data.user.bank_statement
          };
          this.addressData = {
            country: data.address.country || '',
            address1: data.address.address1 || '',
            address2: data.address.address2 || '',
            zipCode: data.address.zip_code || ''
          };
          
          // Set preview images if they exist
          if (data.user.front_id) this.idFrontPreview = data.user.front_id;
          if (data.user.back_id) this.idBackPreview = data.user.back_id;
          if (data.user.bank_statement) this.bankStatementPreview = data.user.bank_statement;
        }
      } catch (error) {
        console.error('Error loading settings:', error);
      }
    },
    triggerFileInput(type) {
      if (type === 'frontId') {
        this.$refs.frontIdInput.click();
      } else if (type === 'backId') {
        this.$refs.backIdInput.click();
      } else if (type === 'bankStatement') {
        this.$refs.bankStatementInput.click();
      }
    },
    async handleFileUpload(event, type) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          if (type === 'frontId') {
            this.idFrontPreview = e.target.result;
          } else if (type === 'backId') {
            this.idBackPreview = e.target.result;
          } else if (type === 'bankStatement') {
            this.bankStatementPreview = e.target.result;
          }
        };
        reader.readAsDataURL(file);
        
        // Upload file to server
        await this.uploadFile(file, type);
      }
    },
    async uploadFile(file, type) {
      try {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);
        
        const response = await axios.post('/api/v1/customer/settings/upload-document', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        
        if (response.data.success) {
          // Update preview with server URL
          if (type === 'frontId') {
            this.idFrontPreview = response.data.data.url;
            this.userData.frontId = response.data.data.url;
          } else if (type === 'backId') {
            this.idBackPreview = response.data.data.url;
            this.userData.backId = response.data.data.url;
          } else if (type === 'bankStatement') {
            this.bankStatementPreview = response.data.data.url;
            this.userData.bankStatement = response.data.data.url;
          }
          alert('Document uploaded successfully!');
        }
      } catch (error) {
        console.error('Error uploading file:', error);
        alert('Failed to upload document. Please try again.');
      }
    },
    async saveAddress() {
      try {
        const response = await axios.post('/api/v1/customer/settings/address', this.addressData);
        if (response.data.success) {
          alert('Address saved successfully!');
        } else {
          throw new Error(response.data.message || 'Failed to save address');
        }
      } catch (error) {
        console.error('Error saving address:', error);
        const message = error.response?.data?.message || 'Failed to save address. Please try again.';
        alert(message);
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
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
  padding: 0;
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

/* Settings Content */
.settings-content {
  width: 100%;
}

.row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  width: 100%;
}

.col-xxl-6 {
  width: 100%;
}

.settings-box {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .settings-box {
  background: #1f2937;
}

.settings-box-header {
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .settings-box-header {
  border-bottom-color: #374151;
}

.settings-box-header h4 {
  font-size: 20px;
  font-weight: 700;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .settings-box-header h4 {
  color: #f9fafb;
}

.settings-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
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

.form-group input[readonly] {
  background: #f9fafb;
  cursor: not-allowed;
}

[data-mode="dark"] .form-group input[readonly] {
  background: #374151;
}

/* Verification Section */
.verification-section {
  margin-top: 24px;
  padding-top: 24px;
  border-top: 1px solid #e5e7eb;
}

[data-mode="dark"] .verification-section {
  border-top-color: #374151;
}

.verification-section h5 {
  font-size: 18px;
  font-weight: 600;
  color: #181818;
  margin: 0 0 16px 0;
}

[data-mode="dark"] .verification-section h5 {
  color: #f9fafb;
}

.verification-status {
  padding: 12px 16px;
  border-radius: 8px;
  margin-bottom: 16px;
  font-size: 14px;
}

.verification-status.error {
  background: #fee2e2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

.verification-status.warning {
  background: #fef3c7;
  color: #d97706;
  border: 1px solid #fde68a;
}

.verification-status.success {
  background: #d1fae5;
  color: #059669;
  border: 1px solid #a7f3d0;
}

.verification-upload {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.upload-container {
  position: relative;
  width: 100%;
  max-width: 300px;
  aspect-ratio: 16/9;
  border: 2px dashed #e5e7eb;
  border-radius: 8px;
  overflow: hidden;
  background: #f9fafb;
}

[data-mode="dark"] .upload-container {
  border-color: #4b5563;
  background: #374151;
}

.upload-preview {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.upload-btn {
  position: absolute;
  bottom: 12px;
  right: 12px;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.upload-btn:hover {
  background: #1e40af;
  transform: scale(1.1);
}

.btn-save {
  padding: 12px 24px;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  align-self: flex-start;
}

.btn-save:hover {
  background: #1e40af;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
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

  .row {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}

@media (max-width: 768px) {
  .dashboard-wrapper {
    margin-top: 60px;
  }

  .dashboard-content {
    padding: 12px;
  }

  .settings-box {
    padding: 20px;
  }

  .form-row {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .dashboard-content {
    padding: 8px;
  }

  .settings-box {
    padding: 16px;
  }
}
</style>

