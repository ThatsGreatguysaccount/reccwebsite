<template>
  <div class="customer-dashboard">
    <Header @toggle-sidebar="toggleMobileSidebar" />
    
    <!-- Mobile Sidebar Overlay -->
    <div v-if="showMobileSidebar" class="sidebar-overlay" @click="closeMobileSidebar"></div>
    
    <!-- Edit Transaction Modal -->
    <div v-if="showEditModal" class="modal-overlay" @click="closeEditModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h4>Edit Transaction #{{ selectedTransaction?.id }}</h4>
          <button class="modal-close" @click="closeEditModal">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div v-if="message" :class="['message', messageType]">
            {{ message }}
          </div>
          <form @submit.prevent="updateTransaction" class="transaction-form">
            <div class="form-group">
              <label>User</label>
              <input type="text" :value="selectedTransaction?.user_name || 'N/A'" disabled />
            </div>
            <div class="form-group">
              <label>Type</label>
              <input type="text" :value="selectedTransaction?.type === 'deposit' ? 'Deposit' : 'Withdrawal'" disabled />
            </div>
            <div class="form-group">
              <label>Asset</label>
              <input type="text" :value="selectedTransaction?.asset" disabled />
            </div>
            <div class="form-group">
              <label>Amount</label>
              <input type="text" :value="formatBalance(selectedTransaction?.amount) + ' ' + selectedTransaction?.asset" disabled />
            </div>
            <div class="form-group">
              <label for="edit_status">Status *</label>
              <select id="edit_status" v-model="editTransactionData.status" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
            <div v-if="editTransactionData.status === 'failed' || editTransactionData.status === 'cancelled'" class="form-group">
              <label for="rejection_reason">Rejection Reason *</label>
              <textarea 
                id="rejection_reason" 
                v-model="editTransactionData.rejection_reason" 
                rows="3"
                required
                placeholder="Enter reason for rejection"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="transaction_hash">Transaction Hash (Optional)</label>
              <input 
                type="text" 
                id="transaction_hash" 
                v-model="editTransactionData.transaction_hash" 
                placeholder="Enter transaction hash"
              />
            </div>
            <div class="modal-actions">
              <button type="button" class="btn-cancel" @click="closeEditModal">Cancel</button>
              <button type="submit" class="btn-submit" :disabled="loading">
                <span v-if="loading">Updating...</span>
                <span v-else>Update Transaction</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Add Transaction Modal -->
    <div v-if="showAddModal" class="modal-overlay" @click="closeAddModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h4>Add Transaction</h4>
          <button class="modal-close" @click="closeAddModal">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div v-if="message" :class="['message', messageType]">
            {{ message }}
          </div>
          <form @submit.prevent="submitTransaction" class="transaction-form">
            <div class="form-group">
              <label for="user_id">User</label>
              <select id="user_id" v-model="transactionData.user_id" required>
                <option value="">-- Select User --</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.fullName }} ({{ user.email }})
                </option>
              </select>
            </div>
            <div class="form-group">
              <label for="type">Transaction Type</label>
              <select id="type" v-model="transactionData.type" required>
                <option value="">-- Select Type --</option>
                <option value="deposit">Deposit</option>
                <option value="withdrawal">Withdrawal</option>
              </select>
            </div>
            <div class="form-group">
              <label for="asset">Asset</label>
              <select id="asset" v-model="transactionData.asset" required>
                <option value="">-- Select Asset --</option>
                <optgroup label="Cryptocurrency">
                  <option value="BTC">Bitcoin (BTC)</option>
                  <option value="ETH">Ethereum (ETH)</option>
                  <option value="TRX">Tron (TRX)</option>
                  <option value="USDT">Tether (USDT)</option>
                </optgroup>
                <optgroup label="Fiat Currency">
                  <option value="USD">US Dollar (USD)</option>
                  <option value="EUR">Euro (EUR)</option>
                  <option value="GBP">British Pound (GBP)</option>
                  <option value="CAD">Canadian Dollar (CAD)</option>
                </optgroup>
              </select>
            </div>
            <div class="form-group">
              <label for="amount">Amount</label>
              <input 
                type="number" 
                id="amount" 
                v-model.number="transactionData.amount" 
                step="0.00000001"
                min="0"
                required 
                placeholder="Enter amount"
              />
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select id="status" v-model="transactionData.status" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
            <div class="form-group">
              <label for="wallet_address">Wallet Address (Optional)</label>
              <input 
                type="text" 
                id="wallet_address" 
                v-model="transactionData.wallet_address" 
                placeholder="Enter wallet address"
              />
            </div>
            <div class="form-group">
              <label for="notes">Notes (Optional)</label>
              <textarea 
                id="notes" 
                v-model="transactionData.notes" 
                rows="3"
                placeholder="Additional notes"
              ></textarea>
            </div>
            <div class="modal-actions">
              <button type="button" class="btn-cancel" @click="closeAddModal">Cancel</button>
              <button type="submit" class="btn-submit" :disabled="loading">
                <span v-if="loading">Processing...</span>
                <span v-else>Add Transaction</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <div class="dashboard-wrapper">
      <Sidebar :class="{ 'mobile-open': showMobileSidebar }" @sidebar-toggle="handleSidebarToggle" @close-mobile="closeMobileSidebar" />
      
      <div class="dashboard-content" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <div class="container-fluid">
          <!-- Page Header -->
          <div class="page-header">
            <h4>Transactions</h4>
            <button type="button" class="btn-primary" @click="openAddModal">
              <i class="fa-solid fa-plus"></i>
              Add Transaction
            </button>
          </div>

          <!-- Transactions Table -->
          <div class="transactions-section">
            <div class="section-header-row">
              <h4>All Transactions</h4>
              <div class="search-box">
                <i class="fa-solid fa-search"></i>
                <input type="text" v-model="searchQuery" placeholder="Search transactions..." />
              </div>
            </div>
            
            <!-- Desktop Table View -->
            <div class="holdings-table-wrapper">
              <table class="holdings-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Asset</th>
                    <th>Amount</th>
                    <th>Amount (USD)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="loading" class="holdings-row">
                    <td colspan="9" style="text-align: center; padding: 40px;">
                      <div class="loading-spinner"></div>
                      <p>Loading transactions...</p>
                    </td>
                  </tr>
                  <tr v-else-if="filteredTransactions.length === 0" class="holdings-row">
                    <td colspan="9" style="text-align: center; padding: 40px; color: #6b7280;">
                      No transactions found
                    </td>
                  </tr>
                  <tr v-for="transaction in filteredTransactions" :key="transaction.id" class="holdings-row">
                    <td>#{{ transaction.id }}</td>
                    <td>
                      <div class="asset-info">
                        <span class="asset-name">{{ transaction.user_name || 'N/A' }}</span>
                      </div>
                    </td>
                    <td>
                      <span class="transaction-type-badge" :class="transaction.type">
                        {{ transaction.type === 'deposit' ? 'Deposit' : 'Withdrawal' }}
                      </span>
                    </td>
                    <td>
                      <span class="asset-symbol-text">{{ transaction.asset }}</span>
                    </td>
                    <td>
                      <span class="amount-value">{{ formatBalance(transaction.amount) }} {{ transaction.asset }}</span>
                    </td>
                    <td>
                      <span class="amount-usd">${{ formatUSD(transaction.amount_usd) }}</span>
                    </td>
                    <td>
                      <span class="status-badge" :class="transaction.status">
                        {{ transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1) }}
                      </span>
                    </td>
                    <td>
                      <span class="date-text">{{ formatDate(transaction.date_time) }}</span>
                    </td>
                    <td>
                      <button v-if="transaction.status === 'pending'" class="btn-edit" @click="editTransaction(transaction)">
                        <i class="fa-solid fa-edit"></i>
                        Edit
                      </button>
                      <button v-else class="btn-edit" @click="viewTransaction(transaction)">
                        <i class="fa-solid fa-eye"></i>
                        View
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Mobile Card View -->
            <div class="holdings-cards-mobile">
              <div v-if="loading" class="transaction-card">
                <div class="transaction-card-body" style="text-align: center; padding: 40px;">
                  <div class="loading-spinner"></div>
                  <p>Loading transactions...</p>
                </div>
              </div>
              <div v-else-if="filteredTransactions.length === 0" class="transaction-card">
                <div class="transaction-card-body" style="text-align: center; padding: 40px; color: #6b7280;">
                  No transactions found
                </div>
              </div>
              <div v-for="transaction in filteredTransactions" :key="transaction.id" class="transaction-card">
                <div class="transaction-card-header">
                  <div>
                    <div class="asset-name">{{ transaction.user_name || 'N/A' }}</div>
                    <div class="asset-symbol">#{{ transaction.id }}</div>
                  </div>
                  <span class="transaction-type-badge" :class="transaction.type">
                    {{ transaction.type === 'deposit' ? 'Deposit' : 'Withdrawal' }}
                  </span>
                </div>
                <div class="transaction-card-body">
                  <div class="transaction-card-row">
                    <span class="holding-label">Asset</span>
                    <span class="asset-symbol-text">{{ transaction.asset }}</span>
                  </div>
                  <div class="transaction-card-row">
                    <span class="holding-label">Amount</span>
                    <span class="amount-value">{{ formatBalance(transaction.amount) }} {{ transaction.asset }}</span>
                  </div>
                  <div class="transaction-card-row">
                    <span class="holding-label">Amount (USD)</span>
                    <span class="amount-usd">${{ formatUSD(transaction.amount_usd) }}</span>
                  </div>
                  <div class="transaction-card-row">
                    <span class="holding-label">Status</span>
                    <span class="status-badge" :class="transaction.status">
                      {{ transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1) }}
                    </span>
                  </div>
                  <div class="transaction-card-row">
                    <span class="holding-label">Date</span>
                    <span class="date-text">{{ formatDate(transaction.date_time) }}</span>
                  </div>
                  <button v-if="transaction.status === 'pending'" class="btn-edit-mobile" @click="editTransaction(transaction)">
                    <i class="fa-solid fa-edit"></i>
                    Edit
                  </button>
                  <button v-else class="btn-edit-mobile" @click="viewTransaction(transaction)">
                    <i class="fa-solid fa-eye"></i>
                    View Details
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

export default {
  name: 'AdminTransactions',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      showAddModal: false,
      showEditModal: false,
      selectedTransaction: null,
      transactions: [],
      users: [],
      loading: true,
      searchQuery: '',
      message: '',
      messageType: '',
      transactionData: {
        user_id: '',
        type: '',
        asset: '',
        amount: null,
        status: 'pending',
        wallet_address: '',
        notes: ''
      },
      editTransactionData: {
        status: 'pending',
        rejection_reason: '',
        transaction_hash: ''
      }
    }
  },
  computed: {
    filteredTransactions() {
      if (!this.searchQuery) {
        return this.transactions;
      }
      const query = this.searchQuery.toLowerCase();
      return this.transactions.filter(transaction => 
        transaction.user_name?.toLowerCase().includes(query) ||
        transaction.asset.toLowerCase().includes(query) ||
        transaction.id.toString().includes(query)
      );
    }
  },
  mounted() {
    this.loadTransactions();
    this.loadUsers();
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
    async loadTransactions() {
      this.loading = true;
      try {
        const response = await axios.get('/api/v1/admin/transactions');
        if (response.data.success && response.data.data) {
          this.transactions = response.data.data.transactions || [];
        }
      } catch (error) {
        console.error('Error loading transactions:', error);
        this.transactions = [];
      } finally {
        this.loading = false;
      }
    },
    async loadUsers() {
      try {
        const response = await axios.get('/api/v1/admin/accounts');
        if (response.data.success && response.data.data) {
          this.users = response.data.data.accounts.map(user => ({
            ...user,
            fullName: `${user.first_name || ''} ${user.last_name || ''}`.trim() || user.username
          }));
        }
      } catch (error) {
        console.error('Error loading users:', error);
      }
    },
    openAddModal() {
      this.showAddModal = true;
      this.resetForm();
    },
    closeAddModal() {
      this.showAddModal = false;
      this.resetForm();
    },
    resetForm() {
      this.transactionData = {
        user_id: '',
        type: '',
        asset: '',
        amount: null,
        status: 'pending',
        wallet_address: '',
        notes: ''
      };
      this.message = '';
      this.messageType = '';
    },
    async submitTransaction() {
      this.loading = true;
      this.message = '';
      try {
        const response = await axios.post('/api/v1/admin/transactions', this.transactionData);
        if (response.data.success) {
          this.message = 'Transaction added successfully!';
          this.messageType = 'success';
          await this.loadTransactions();
          setTimeout(() => {
            this.closeAddModal();
          }, 1500);
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.message = error.response.data.message || 'Failed to add transaction';
        } else {
          this.message = 'Failed to add transaction. Please try again.';
        }
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },
    editTransaction(transaction) {
      this.selectedTransaction = transaction;
      this.editTransactionData = {
        status: transaction.status,
        rejection_reason: transaction.rejection_reason || '',
        transaction_hash: transaction.transaction_hash || ''
      };
      this.showEditModal = true;
      this.message = '';
      this.messageType = '';
    },
    closeEditModal() {
      this.showEditModal = false;
      this.selectedTransaction = null;
      this.editTransactionData = {
        status: 'pending',
        rejection_reason: '',
        transaction_hash: ''
      };
      this.message = '';
      this.messageType = '';
    },
    async updateTransaction() {
      this.loading = true;
      this.message = '';
      try {
        const response = await axios.put(`/api/v1/admin/transactions/${this.selectedTransaction.id}`, this.editTransactionData);
        if (response.data.success) {
          this.message = 'Transaction updated successfully!';
          this.messageType = 'success';
          await this.loadTransactions();
          setTimeout(() => {
            this.closeEditModal();
          }, 1500);
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.message = error.response.data.message || 'Failed to update transaction';
        } else {
          this.message = 'Failed to update transaction. Please try again.';
        }
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },
    viewTransaction(transaction) {
      // TODO: Open view/edit modal
      console.log('View transaction:', transaction);
      alert(`Transaction #${transaction.id}\nUser: ${transaction.user_name}\nAmount: ${transaction.amount} ${transaction.asset}`);
    },
    formatBalance(value) {
      return parseFloat(value).toFixed(8);
    },
    formatUSD(value) {
      return parseFloat(value).toLocaleString('en-US', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
      });
    },
    formatDate(date) {
      if (!date) return 'N/A';
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
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
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 32px;
  flex-wrap: wrap;
  gap: 16px;
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

.btn-primary {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
}

.transactions-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .transactions-section {
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

.transaction-type-badge {
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  text-transform: capitalize;
}

.transaction-type-badge.deposit {
  background: #d1fae5;
  color: #059669;
}

.transaction-type-badge.withdrawal {
  background: #fee2e2;
  color: #dc2626;
}

[data-mode="dark"] .transaction-type-badge.deposit {
  background: rgba(16, 185, 129, 0.2);
  color: #34d399;
}

[data-mode="dark"] .transaction-type-badge.withdrawal {
  background: rgba(220, 38, 38, 0.2);
  color: #f87171;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  text-transform: capitalize;
}

.status-badge.pending {
  background: #fef3c7;
  color: #d97706;
}

.status-badge.completed {
  background: #d1fae5;
  color: #059669;
}

.status-badge.failed {
  background: #fee2e2;
  color: #dc2626;
}

.status-badge.cancelled {
  background: #e5e7eb;
  color: #6b7280;
}

[data-mode="dark"] .status-badge.pending {
  background: rgba(217, 119, 6, 0.2);
  color: #fbbf24;
}

[data-mode="dark"] .status-badge.completed {
  background: rgba(16, 185, 129, 0.2);
  color: #34d399;
}

[data-mode="dark"] .status-badge.failed {
  background: rgba(220, 38, 38, 0.2);
  color: #f87171;
}

[data-mode="dark"] .status-badge.cancelled {
  background: rgba(107, 114, 128, 0.2);
  color: #9ca3af;
}

.asset-symbol-text {
  font-size: 13px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .asset-symbol-text {
  color: #f9fafb;
}

.amount-value {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .amount-value {
  color: #f9fafb;
}

.amount-usd {
  font-size: 13px;
  color: #6b7280;
}

[data-mode="dark"] .amount-usd {
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

/* Modal Styles */
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
  max-width: 600px;
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
}

[data-mode="dark"] .modal-header {
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

.transaction-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
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

.form-group select,
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
  width: 100%;
}

[data-mode="dark"] .form-group select,
[data-mode="dark"] .form-group input,
[data-mode="dark"] .form-group textarea {
  background: #374151;
  border-color: #4b5563;
  color: #f9fafb;
}

.form-group select:focus,
.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.modal-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 8px;
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

.transaction-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 12px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .transaction-card {
  background: #374151;
  border-color: #4b5563;
}

.transaction-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .transaction-card-header {
  border-bottom-color: #4b5563;
}

.transaction-card-row {
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
  .transactions-section {
    padding: 16px;
  }

  .page-header {
    flex-direction: column;
    align-items: stretch;
  }

  .btn-primary {
    width: 100%;
  }
}
</style>

