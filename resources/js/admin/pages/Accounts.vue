<template>
  <div class="customer-dashboard">
    <Header @toggle-sidebar="toggleMobileSidebar" />
    
    <!-- Mobile Sidebar Overlay -->
    <div v-if="showMobileSidebar" class="sidebar-overlay" @click="closeMobileSidebar"></div>
    
    <!-- Edit Account Modal -->
    <EditAccountModal 
      :isOpen="showEditModal" 
      :account="selectedAccount"
      @close="closeEditModal"
      @updated="handleAccountUpdated"
    />
    
    <div class="dashboard-wrapper">
      <Sidebar :class="{ 'mobile-open': showMobileSidebar }" @sidebar-toggle="handleSidebarToggle" @close-mobile="closeMobileSidebar" />
      
      <div class="dashboard-content" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <div class="container-fluid">
          <!-- Page Header -->
          <div class="page-header">
            <h4>User Accounts</h4>
          </div>

          <!-- Accounts Table -->
          <div class="accounts-section">
            <div class="section-header-row">
              <h4>All Accounts</h4>
              <div class="search-box">
                <i class="fa-solid fa-search"></i>
                <input type="text" v-model="searchQuery" placeholder="Search by name, email, or UID..." />
              </div>
            </div>
            
            <!-- Desktop Table View -->
            <div class="holdings-table-wrapper">
              <table class="holdings-table">
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Account Type</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="loading" class="holdings-row">
                    <td colspan="7" style="text-align: center; padding: 40px;">
                      <div class="loading-spinner"></div>
                      <p>Loading accounts...</p>
                    </td>
                  </tr>
                  <tr v-else-if="filteredAccounts.length === 0" class="holdings-row">
                    <td colspan="7" style="text-align: center; padding: 40px; color: #6b7280;">
                      No accounts found
                    </td>
                  </tr>
                  <tr v-for="account in filteredAccounts" :key="account.id" class="holdings-row">
                    <td>
                      <span class="user-id">{{ account.uid }}</span>
                    </td>
                    <td>
                      <div class="asset-info">
                        <img :src="account.avatar || '/customer/images/user.png'" alt="User" class="asset-icon" />
                        <span class="asset-name">{{ account.fullName }}</span>
                      </div>
                    </td>
                    <td>
                      <span class="user-email">{{ account.email }}</span>
                    </td>
                    <td>
                      <span class="account-type-badge" :class="account.account_type">
                        {{ account.account_type === 'administrator' ? 'Admin' : 'User' }}
                      </span>
                    </td>
                    <td>
                      <span class="status-badge active">Active</span>
                    </td>
                    <td>
                      <span class="date-text">{{ formatDate(account.created_at) }}</span>
                    </td>
                    <td>
                      <button class="btn-edit" @click="editAccount(account)">
                        <i class="fa-solid fa-edit"></i>
                        Edit
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Mobile Card View -->
            <div class="holdings-cards-mobile">
              <div v-if="loading" class="account-card">
                <div class="account-card-body" style="text-align: center; padding: 40px;">
                  <div class="loading-spinner"></div>
                  <p>Loading accounts...</p>
                </div>
              </div>
              <div v-else-if="filteredAccounts.length === 0" class="account-card">
                <div class="account-card-body" style="text-align: center; padding: 40px; color: #6b7280;">
                  No accounts found
                </div>
              </div>
              <div v-for="account in filteredAccounts" :key="account.id" class="account-card">
                <div class="account-card-header">
                  <div class="asset-info">
                    <img :src="account.avatar || '/customer/images/user.png'" alt="User" class="asset-icon" />
                    <div>
                      <div class="asset-name">{{ account.fullName }}</div>
                      <div class="asset-symbol">{{ account.email }}</div>
                    </div>
                  </div>
                  <span class="account-type-badge" :class="account.account_type">
                    {{ account.account_type === 'administrator' ? 'Admin' : 'User' }}
                  </span>
                </div>
                <div class="account-card-body">
                  <div class="account-card-row">
                    <span class="holding-label">User ID</span>
                    <span class="user-id">{{ account.uid }}</span>
                  </div>
                  <div class="account-card-row">
                    <span class="holding-label">Status</span>
                    <span class="status-badge active">Active</span>
                  </div>
                  <div class="account-card-row">
                    <span class="holding-label">Registered</span>
                    <span class="date-text">{{ formatDate(account.created_at) }}</span>
                  </div>
                  <button class="btn-edit-mobile" @click="editAccount(account)">
                    <i class="fa-solid fa-edit"></i>
                    Edit Account
                  </button>
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
import EditAccountModal from '../components/EditAccountModal.vue'

export default {
  name: 'AdminAccounts',
  components: {
    Header,
    Sidebar,
    EditAccountModal
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      showEditModal: false,
      selectedAccount: null,
      accounts: [],
      loading: true,
      searchQuery: ''
    }
  },
  computed: {
    filteredAccounts() {
      if (!this.searchQuery) {
        return this.accounts;
      }
      const query = this.searchQuery.toLowerCase();
      return this.accounts.filter(account => 
        account.fullName.toLowerCase().includes(query) ||
        account.email.toLowerCase().includes(query) ||
        account.uid.toLowerCase().includes(query)
      );
    }
  },
  mounted() {
    this.loadAccounts();
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
    async loadAccounts() {
      this.loading = true;
      try {
        const response = await axios.get('/api/v1/admin/accounts');
        if (response.data.success && response.data.data) {
          this.accounts = response.data.data.accounts.map(account => ({
            ...account,
            fullName: `${account.first_name || ''} ${account.last_name || ''}`.trim() || account.username
          }));
        }
      } catch (error) {
        console.error('Error loading accounts:', error);
        this.accounts = [];
      } finally {
        this.loading = false;
      }
    },
    editAccount(account) {
      this.selectedAccount = account;
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
      this.selectedAccount = null;
    },
    async handleAccountUpdated() {
      // Reload accounts after update
      await this.loadAccounts();
    },
    formatDate(date) {
      if (!date) return 'N/A';
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
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

.accounts-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .accounts-section {
  background: #1f2937;
}

.section-header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}

.search-box {
  position: relative;
  display: flex;
  align-items: center;
  min-width: 300px;
}

.search-box i {
  position: absolute;
  left: 16px;
  color: #6b7280;
  font-size: 14px;
}

.search-box input {
  width: 100%;
  padding: 10px 16px 10px 40px;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  background: #ffffff;
  color: #181818;
}

[data-mode="dark"] .search-box input {
  background: #374151;
  border-color: #4b5563;
  color: #f9fafb;
}

.search-box input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.user-id {
  font-family: monospace;
  font-size: 13px;
  color: #2563eb;
  font-weight: 600;
}

[data-mode="dark"] .user-id {
  color: #60a5fa;
}

.user-email {
  font-size: 14px;
  color: #181818;
}

[data-mode="dark"] .user-email {
  color: #f9fafb;
}

.account-type-badge {
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  text-transform: capitalize;
}

.account-type-badge.user {
  background: #dbeafe;
  color: #2563eb;
}

.account-type-badge.administrator {
  background: #fef3c7;
  color: #d97706;
}

[data-mode="dark"] .account-type-badge.user {
  background: rgba(37, 99, 235, 0.2);
  color: #60a5fa;
}

[data-mode="dark"] .account-type-badge.administrator {
  background: rgba(217, 119, 6, 0.2);
  color: #fbbf24;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
}

.status-badge.active {
  background: #d1fae5;
  color: #059669;
}

[data-mode="dark"] .status-badge.active {
  background: rgba(16, 185, 129, 0.2);
  color: #34d399;
}

.date-text {
  font-size: 13px;
  color: #6b7280;
}

[data-mode="dark"] .date-text {
  color: #9ca3af;
}

.btn-edit {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-edit:hover {
  background: #1e40af;
}

.btn-edit i {
  font-size: 12px;
}

.account-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 12px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .account-card {
  background: #374151;
  border-color: #4b5563;
}

.account-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .account-card-header {
  border-bottom-color: #4b5563;
}

.account-card-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
  font-size: 13px;
}

.btn-edit-mobile {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: 12px;
}

.btn-edit-mobile:hover {
  background: #1e40af;
}

.loading-spinner {
  width: 32px;
  height: 32px;
  border: 3px solid #e5e7eb;
  border-top-color: #2563eb;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 12px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* Table Styles */
.holdings-table-wrapper {
  overflow-x: auto;
}

.holdings-table {
  width: 100%;
  border-collapse: collapse;
}

.holdings-table thead {
  background: #f9fafb;
}

[data-mode="dark"] .holdings-table thead {
  background: #374151;
}

.holdings-table th {
  padding: 16px;
  text-align: left;
  font-size: 14px;
  font-weight: 600;
  color: #6b7280;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .holdings-table th {
  color: #9ca3af;
  border-bottom-color: #4b5563;
}

.holdings-table td {
  padding: 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .holdings-table td {
  border-bottom-color: #4b5563;
}

.holdings-row:hover {
  background: #f9fafb;
}

[data-mode="dark"] .holdings-row:hover {
  background: #374151;
}

.asset-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.asset-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  object-fit: cover;
}

.asset-name {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
  margin-bottom: 2px;
}

[data-mode="dark"] .asset-name {
  color: #f9fafb;
}

.asset-symbol {
  font-size: 12px;
  color: #6b7280;
}

[data-mode="dark"] .asset-symbol {
  color: #9ca3af;
}

/* Mobile Card View */
.holdings-cards-mobile {
  display: none;
}

@media (min-width: 769px) {
  .holdings-table-wrapper {
    display: block;
  }

  .holdings-cards-mobile {
    display: none;
  }
}

@media (max-width: 1024px) {
  .holdings-table-wrapper {
    display: none;
  }

  .holdings-cards-mobile {
    display: block;
  }
}

@media (max-width: 768px) {
  .accounts-section {
    padding: 16px;
  }

  .section-header-row {
    flex-direction: column;
    align-items: stretch;
  }

  .search-box {
    min-width: 100%;
  }
}
</style>

