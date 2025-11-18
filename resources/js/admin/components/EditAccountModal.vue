<template>
  <div v-if="isOpen" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Edit Account</h4>
        <button class="modal-close" @click="closeModal">
          <i class="fa-solid fa-times"></i>
        </button>
      </div>
      
      <div class="modal-body">
        <div v-if="message" :class="['message', messageType]">
          {{ message }}
        </div>
        
        <form @submit.prevent="submitForm" class="edit-account-form">
          <!-- Basic Information -->
          <div class="form-section">
            <h5 class="section-title">Basic Information</h5>
            <div class="form-grid">
              <div class="form-group">
                <label for="username">Username</label>
                <input 
                  type="text" 
                  id="username" 
                  v-model="formData.username" 
                  placeholder="Enter username"
                />
              </div>
              
              <div class="form-group">
                <label for="email">Email</label>
                <input 
                  type="email" 
                  id="email" 
                  v-model="formData.email" 
                  placeholder="Enter email"
                />
              </div>
              
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input 
                  type="text" 
                  id="first_name" 
                  v-model="formData.first_name" 
                  placeholder="Enter first name"
                />
              </div>
              
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input 
                  type="text" 
                  id="last_name" 
                  v-model="formData.last_name" 
                  placeholder="Enter last name"
                />
              </div>
              
              <div class="form-group">
                <label for="account_type">Account Type</label>
                <select id="account_type" v-model="formData.account_type">
                  <option value="user">User</option>
                  <option value="administrator">Administrator</option>
                </select>
              </div>
              
              <div class="form-group">
                <label for="country">Country</label>
                <input 
                  type="text" 
                  id="country" 
                  v-model="formData.country" 
                  placeholder="Enter country"
                />
              </div>
            </div>
          </div>
          
          <!-- Password Section -->
          <div class="form-section">
            <h5 class="section-title">Change Password</h5>
            <div class="form-grid">
              <div class="form-group">
                <label for="password">New Password</label>
                <input 
                  type="password" 
                  id="password" 
                  v-model="formData.password" 
                  placeholder="Leave empty to keep current password"
                />
                <small class="form-hint">Leave empty to keep current password</small>
              </div>
              
              <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                  type="password" 
                  id="password_confirmation" 
                  v-model="formData.password_confirmation" 
                  placeholder="Confirm new password"
                />
              </div>
            </div>
          </div>
          
          <!-- Address Information -->
          <div class="form-section">
            <h5 class="section-title">Address Information</h5>
            <div class="form-grid">
              <div class="form-group full-width">
                <label for="address1">Address Line 1</label>
                <input 
                  type="text" 
                  id="address1" 
                  v-model="formData.address1" 
                  placeholder="Enter address line 1"
                />
              </div>
              
              <div class="form-group full-width">
                <label for="address2">Address Line 2</label>
                <input 
                  type="text" 
                  id="address2" 
                  v-model="formData.address2" 
                  placeholder="Enter address line 2"
                />
              </div>
              
              <div class="form-group">
                <label for="zip_code">Zip Code</label>
                <input 
                  type="text" 
                  id="zip_code" 
                  v-model="formData.zip_code" 
                  placeholder="Enter zip code"
                />
              </div>
            </div>
          </div>
          
          <!-- Wallet Addresses -->
          <div class="form-section">
            <h5 class="section-title">Wallet Addresses</h5>
            <div class="form-grid">
              <div class="form-group full-width">
                <label for="wallet_btc">
                  <i class="fa-brands fa-bitcoin"></i>
                  Bitcoin (BTC) Wallet Address
                </label>
                <input 
                  type="text" 
                  id="wallet_btc" 
                  v-model="formData.wallets.BTC" 
                  placeholder="Enter BTC wallet address"
                />
              </div>
              
              <div class="form-group full-width">
                <label for="wallet_eth">
                  <i class="fa-brands fa-ethereum"></i>
                  Ethereum (ETH) Wallet Address
                </label>
                <input 
                  type="text" 
                  id="wallet_eth" 
                  v-model="formData.wallets.ETH" 
                  placeholder="Enter ETH wallet address"
                />
              </div>
              
              <div class="form-group full-width">
                <label for="wallet_trx">Tron (TRX) Wallet Address</label>
                <input 
                  type="text" 
                  id="wallet_trx" 
                  v-model="formData.wallets.TRX" 
                  placeholder="Enter TRX wallet address"
                />
              </div>
              
              <div class="form-group full-width">
                <label for="wallet_usdt">Tether (USDT) Wallet Address</label>
                <input 
                  type="text" 
                  id="wallet_usdt" 
                  v-model="formData.wallets.USDT" 
                  placeholder="Enter USDT wallet address"
                />
              </div>
            </div>
          </div>
          
          <!-- Form Actions -->
          <div class="modal-actions">
            <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
            <button type="submit" class="btn-submit" :disabled="loading">
              <span v-if="loading">Saving...</span>
              <span v-else>Save Changes</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'EditAccountModal',
  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    account: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      loading: false,
      message: '',
      messageType: '',
      formData: {
        username: '',
        email: '',
        first_name: '',
        last_name: '',
        account_type: 'user',
        country: '',
        address1: '',
        address2: '',
        zip_code: '',
        password: '',
        password_confirmation: '',
        wallets: {
          BTC: '',
          ETH: '',
          TRX: '',
          USDT: ''
        }
      }
    }
  },
  watch: {
    isOpen(newVal) {
      if (newVal && this.account) {
        this.loadAccountData();
      } else {
        this.resetForm();
      }
    },
    account(newVal) {
      if (newVal && this.isOpen) {
        this.loadAccountData();
      }
    }
  },
  methods: {
    async loadAccountData() {
      if (!this.account) return;
      
      // Load basic account info
      this.formData.username = this.account.username || '';
      this.formData.email = this.account.email || '';
      this.formData.first_name = this.account.first_name || '';
      this.formData.last_name = this.account.last_name || '';
      this.formData.account_type = this.account.account_type || 'user';
      this.formData.country = this.account.country || '';
      this.formData.address1 = this.account.address1 || '';
      this.formData.address2 = this.account.address2 || '';
      this.formData.zip_code = this.account.zip_code || '';
      
      // Load wallet addresses
      try {
        const walletResponse = await axios.get(`/api/v1/admin/accounts/${this.account.id}/wallets`);
        if (walletResponse.data.success && walletResponse.data.data) {
          const wallets = walletResponse.data.data.wallets || {};
          this.formData.wallets = {
            BTC: wallets.BTC || '',
            ETH: wallets.ETH || '',
            TRX: wallets.TRX || '',
            USDT: wallets.USDT || ''
          };
        }
      } catch (error) {
        console.error('Error loading wallets:', error);
      }
    },
    resetForm() {
      this.formData = {
        username: '',
        email: '',
        first_name: '',
        last_name: '',
        account_type: 'user',
        country: '',
        address1: '',
        address2: '',
        zip_code: '',
        password: '',
        password_confirmation: '',
        wallets: {
          BTC: '',
          ETH: '',
          TRX: '',
          USDT: ''
        }
      };
      this.message = '';
      this.messageType = '';
    },
    closeModal() {
      this.$emit('close');
    },
    async submitForm() {
      // Validate password if provided
      if (this.formData.password && this.formData.password !== this.formData.password_confirmation) {
        this.message = 'Passwords do not match';
        this.messageType = 'error';
        return;
      }
      
      if (this.formData.password && this.formData.password.length < 6) {
        this.message = 'Password must be at least 6 characters';
        this.messageType = 'error';
        return;
      }
      
      this.loading = true;
      this.message = '';
      
      try {
        // Build account data object - only include fields that have values or are being changed
        const accountData = {};
        
        // Only include fields that are not empty (or account_type which should always be included)
        if (this.formData.username) accountData.username = this.formData.username;
        if (this.formData.email) accountData.email = this.formData.email;
        if (this.formData.first_name !== undefined) accountData.first_name = this.formData.first_name || null;
        if (this.formData.last_name !== undefined) accountData.last_name = this.formData.last_name || null;
        if (this.formData.account_type) accountData.account_type = this.formData.account_type;
        if (this.formData.country !== undefined) accountData.country = this.formData.country || null;
        if (this.formData.address1 !== undefined) accountData.address1 = this.formData.address1 || null;
        if (this.formData.address2 !== undefined) accountData.address2 = this.formData.address2 || null;
        if (this.formData.zip_code !== undefined) accountData.zip_code = this.formData.zip_code || null;
        
        // Add password only if provided
        if (this.formData.password) {
          accountData.password = this.formData.password;
          accountData.password_confirmation = this.formData.password_confirmation;
        }
        
        // Only send account update if there's data to update
        if (Object.keys(accountData).length > 0) {
          const accountResponse = await axios.put(`/api/v1/admin/accounts/${this.account.id}`, accountData);
          
          if (!accountResponse.data.success) {
            throw new Error(accountResponse.data.message || 'Failed to update account');
          }
        }
        
        // Update wallet addresses (always send wallets, even if empty)
        const walletResponse = await axios.put(`/api/v1/admin/accounts/${this.account.id}/wallets`, {
          wallets: this.formData.wallets
        });
        
        if (!walletResponse.data.success) {
          throw new Error(walletResponse.data.message || 'Failed to update wallets');
        }
        
        this.message = 'Account updated successfully!';
        this.messageType = 'success';
        
        // Emit success event
        this.$emit('updated');
        
        // Close modal after 1.5 seconds
        setTimeout(() => {
          this.closeModal();
        }, 1500);
      } catch (error) {
        if (error.response && error.response.data) {
          if (error.response.data.errors) {
            const errors = error.response.data.errors;
            this.message = Object.values(errors).flat().join(', ');
          } else {
            this.message = error.response.data.message || 'Failed to update account';
          }
        } else {
          this.message = 'Failed to update account. Please try again.';
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
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
}

.modal-content {
  background: #ffffff;
  border-radius: 16px;
  width: 100%;
  max-width: 900px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

[data-mode="dark"] .modal-content {
  background: #1f2937;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 24px;
  border-bottom: 1px solid #e5e7eb;
  position: sticky;
  top: 0;
  background: #ffffff;
  z-index: 10;
  border-radius: 16px 16px 0 0;
}

[data-mode="dark"] .modal-header {
  background: #1f2937;
  border-bottom-color: #374151;
}

.modal-header h4 {
  font-size: 24px;
  font-weight: 700;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .modal-header h4 {
  color: #f9fafb;
}

.modal-close {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border: none;
  border-radius: 8px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.2s ease;
}

[data-mode="dark"] .modal-close {
  background: #374151;
  color: #9ca3af;
}

.modal-close:hover {
  background: #e5e7eb;
  color: #181818;
}

.modal-body {
  padding: 24px;
}

.message {
  padding: 12px 16px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 20px;
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

.edit-account-form {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.form-section {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.section-title {
  font-size: 18px;
  font-weight: 700;
  color: #181818;
  margin: 0;
  padding-bottom: 12px;
  border-bottom: 2px solid #e5e7eb;
}

[data-mode="dark"] .section-title {
  color: #f9fafb;
  border-bottom-color: #374151;
}

.form-grid {
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
  display: flex;
  align-items: center;
  gap: 8px;
}

[data-mode="dark"] .form-group label {
  color: #f9fafb;
}

.form-group label i {
  color: #2563eb;
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

.form-hint {
  font-size: 12px;
  color: #6b7280;
  margin-top: -4px;
}

[data-mode="dark"] .form-hint {
  color: #9ca3af;
}

.modal-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 8px;
  border-top: 1px solid #e5e7eb;
  margin-top: 8px;
}

[data-mode="dark"] .modal-actions {
  border-top-color: #374151;
}

.btn-cancel {
  padding: 12px 24px;
  background: #f3f4f6;
  color: #6b7280;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

[data-mode="dark"] .btn-cancel {
  background: #374151;
  color: #9ca3af;
  border-color: #4b5563;
}

.btn-cancel:hover {
  background: #e5e7eb;
  color: #181818;
}

.btn-submit {
  padding: 12px 24px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-submit:hover:not(:disabled) {
  background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

@media (max-width: 768px) {
  .modal-content {
    max-width: 100%;
    max-height: 95vh;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
  }
  
  .modal-actions {
    flex-direction: column;
  }
  
  .btn-cancel,
  .btn-submit {
    width: 100%;
  }
}
</style>

