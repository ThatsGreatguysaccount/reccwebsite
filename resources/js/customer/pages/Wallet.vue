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
            <h4>Crypto Wallets</h4>
          </div>

          <!-- Crypto Price Cards -->
          <div class="crypto-price-cards">
            <div v-if="loadingPrices" class="price-cards-loading">
              <div class="loading-spinner"></div>
              <p>Loading crypto prices...</p>
            </div>
            <div v-else-if="cryptoPrices.length === 0" class="price-cards-error">
              <p>Unable to load crypto prices. Please try again later.</p>
            </div>
            <div v-else v-for="crypto in cryptoPrices" :key="crypto.symbol" class="price-card">
              <div class="price-card-header">
                <div class="crypto-info">
                  <img :src="crypto.icon" :alt="crypto.name" class="crypto-icon" />
                  <h4>{{ crypto.name }}</h4>
                </div>
              </div>
              <div class="price-card-body">
                <div class="price-info">
                  <span class="price-label">Price</span>
                  <h4 class="price-value">${{ formatUSD(crypto.price) }}</h4>
                </div>
                <div class="divider"></div>
                <div class="price-info">
                  <span class="price-label">Market Cap</span>
                  <h4 class="price-value">${{ formatMarketCap(crypto.marketCap) }}</h4>
                </div>
              </div>
            </div>
          </div>

          <!-- Wallet Addresses Table -->
          <div class="wallet-section">
            <div class="section-header-row">
              <h4>Crypto Wallets</h4>
            </div>
            
            <!-- Desktop Table View -->
            <div class="holdings-table-wrapper">
              <table class="holdings-table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Chain</th>
                    <th>Wallet Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="wallets.length === 0" class="holdings-row">
                    <td colspan="4" style="text-align: center; padding: 40px; color: #6b7280;">
                      Loading wallets...
                    </td>
                  </tr>
                  <tr v-for="wallet in wallets" :key="wallet.symbol" class="holdings-row">
                    <td>
                      <div class="asset-info">
                        <img :src="wallet.icon" :alt="wallet.name" class="asset-icon" />
                        <span class="asset-name">{{ wallet.name }}</span>
                      </div>
                    </td>
                    <td>
                      <span class="chain-name">{{ wallet.chain }}</span>
                    </td>
                    <td>
                      <span class="wallet-address" :id="`${wallet.symbol}-address`" :class="{ 'not-set': !wallet.address }">
                        {{ wallet.address || 'Not set' }}
                      </span>
                    </td>
                    <td>
                      <button 
                        class="btn-copy" 
                        :data-symbol="wallet.symbol"
                        @click="copyAddress(wallet.symbol, wallet.address)"
                        :disabled="!wallet.address"
                        :title="wallet.address ? 'Copy address' : 'No address to copy'"
                      >
                        <i class="fa-solid fa-copy"></i>
                        Copy
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Mobile Card View -->
            <div class="holdings-cards-mobile">
              <div v-if="wallets.length === 0" class="wallet-card">
                <div class="wallet-card-body" style="text-align: center; padding: 40px; color: #6b7280;">
                  Loading wallets...
                </div>
              </div>
              <div v-for="wallet in wallets" :key="wallet.symbol" class="wallet-card">
                <div class="wallet-card-header">
                  <div class="asset-info">
                    <img :src="wallet.icon" :alt="wallet.name" class="asset-icon" />
                    <div>
                      <div class="asset-name">{{ wallet.name }}</div>
                      <div class="asset-symbol">{{ wallet.chain }}</div>
                    </div>
                  </div>
                </div>
                <div class="wallet-card-body">
                  <div class="wallet-card-row">
                    <span class="holding-label">Wallet Address</span>
                    <span class="wallet-address-mobile" :class="{ 'not-set': !wallet.address }">
                      {{ wallet.address || 'Not set' }}
                    </span>
                  </div>
                  <button 
                    class="btn-copy-mobile" 
                    :data-symbol="wallet.symbol"
                    @click="copyAddress(wallet.symbol, wallet.address)"
                    :disabled="!wallet.address"
                    :title="wallet.address ? 'Copy address' : 'No address to copy'"
                  >
                    <i class="fa-solid fa-copy"></i>
                    Copy Address
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Transaction History -->
          <div class="transactions-section">
            <div class="section-header-row">
              <h4>Transaction History</h4>
            </div>
            <div class="transactions-list">
              <div v-if="transactions.length === 0" class="no-transactions">
                <p>No transactions yet</p>
              </div>
              <div v-for="transaction in transactions" :key="transaction.id" class="transaction-item">
                <div class="transaction-item-top">
                  <div class="transaction-icon" :class="transaction.type">
                    <i :class="transaction.type === 'deposit' ? 'fa-solid fa-arrow-down' : 'fa-solid fa-arrow-up'"></i>
                  </div>
                  <div class="transaction-details">
                    <div class="transaction-type">{{ transaction.type === 'deposit' ? 'Deposit' : 'Withdrawal' }}</div>
                    <div class="transaction-date">{{ formatDate(transaction.date) }}</div>
                    <div class="transaction-asset">{{ transaction.asset }}</div>
                  </div>
                  <div class="transaction-amount">
                    <span class="amount" :class="transaction.type">
                      {{ transaction.type === 'deposit' ? '+' : '-' }}{{ formatBalance(transaction.amount) }} {{ transaction.asset }}
                    </span>
                    <span class="amount-usd">${{ formatUSD(transaction.amountUSD) }}</span>
                  </div>
                </div>
                <div class="transaction-status" :class="transaction.status">
                  {{ transaction.status }}
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
  name: 'CustomerWallet',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      cryptoPrices: [],
      loadingPrices: true,
      wallets: [],
      transactions: []
    }
  },
  mounted() {
    this.loadWalletData();
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
    async loadWalletData() {
      try {
        // Load wallet addresses and transactions
        const walletResponse = await axios.get('/api/v1/customer/wallet');
        if (walletResponse.data.success && walletResponse.data.data) {
          this.wallets = walletResponse.data.data.wallets || [];
          this.transactions = walletResponse.data.data.transactions || [];
        }
      } catch (error) {
        console.error('Error loading wallet data:', error);
      }

      // Load crypto prices separately
      await this.loadCryptoPrices();
    },
    async loadCryptoPrices() {
      this.loadingPrices = true;
      try {
        const priceResponse = await axios.get('/api/v1/customer/crypto-prices');
        if (priceResponse.data.success && priceResponse.data.data) {
          const prices = priceResponse.data.data.prices;
          this.cryptoPrices = [
            {
              symbol: 'BTC',
              name: 'Bitcoin',
              icon: '/customer/images/bitcoin_mid.png',
              price: prices.BTC?.price || prices.BTC || 0,
              marketCap: prices.BTC?.market_cap || 0,
              change24h: prices.BTC?.change_24h || 0
            },
            {
              symbol: 'ETH',
              name: 'Ethereum',
              icon: '/customer/images/ethereum_mid.png',
              price: prices.ETH?.price || prices.ETH || 0,
              marketCap: prices.ETH?.market_cap || 0,
              change24h: prices.ETH?.change_24h || 0
            },
            {
              symbol: 'TRX',
              name: 'Tron',
              icon: '/customer/images/tron_med.png',
              price: prices.TRX?.price || prices.TRX || 0,
              marketCap: prices.TRX?.market_cap || 0,
              change24h: prices.TRX?.change_24h || 0
            },
            {
              symbol: 'USDT',
              name: 'Tether',
              icon: '/customer/images/tether_mid.png',
              price: prices.USDT?.price || prices.USDT || 0,
              marketCap: prices.USDT?.market_cap || 0,
              change24h: prices.USDT?.change_24h || 0
            }
          ];
        }
      } catch (error) {
        console.error('Error loading crypto prices:', error);
        this.cryptoPrices = [];
      } finally {
        this.loadingPrices = false;
      }
    },
    async copyAddress(symbol, address) {
      if (!address || address === 'Not set' || address === null) {
        alert('No address to copy');
        return;
      }
      
      try {
        await navigator.clipboard.writeText(address);
        // Show success feedback
        this.showCopyFeedback(symbol);
      } catch (error) {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = address;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        document.body.appendChild(textArea);
        textArea.select();
        try {
          document.execCommand('copy');
          this.showCopyFeedback(symbol);
        } catch (err) {
          alert('Failed to copy address. Please copy manually.');
        }
        document.body.removeChild(textArea);
      }
    },
    showCopyFeedback(symbol) {
      // Update button text temporarily for both desktop and mobile
      const buttons = document.querySelectorAll(`[data-symbol="${symbol}"]`);
      buttons.forEach(button => {
        if (button && !button.disabled) {
          const originalHTML = button.innerHTML;
          const originalBackground = button.style.background || '';
          button.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
          button.style.background = '#10b981';
          setTimeout(() => {
            button.innerHTML = originalHTML;
            button.style.background = originalBackground;
          }, 2000);
        }
      });
    },
    formatBalance(value) {
      return parseFloat(value).toFixed(8);
    },
    formatUSD(value) {
      return parseFloat(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    formatMarketCap(value) {
      if (value >= 1e12) {
        return (value / 1e12).toFixed(2) + 'T';
      } else if (value >= 1e9) {
        return (value / 1e9).toFixed(2) + 'B';
      } else if (value >= 1e6) {
        return (value / 1e6).toFixed(2) + 'M';
      }
      return value.toLocaleString();
    },
    formatDate(date) {
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
  max-width: 1400px;
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

/* Crypto Price Cards */
.crypto-price-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.price-cards-loading,
.price-cards-error {
  grid-column: 1 / -1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  min-height: 200px;
}

[data-mode="dark"] .price-cards-loading,
[data-mode="dark"] .price-cards-error {
  background: #1f2937;
}

.loading-spinner {
  width: 48px;
  height: 48px;
  border: 4px solid #e5e7eb;
  border-top-color: #2563eb;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 16px;
}

[data-mode="dark"] .loading-spinner {
  border-color: #374151;
  border-top-color: #3b82f6;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.price-cards-loading p,
.price-cards-error p {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
  text-align: center;
}

[data-mode="dark"] .price-cards-loading p,
[data-mode="dark"] .price-cards-error p {
  color: #9ca3af;
}

.price-cards-error p {
  color: #dc2626;
}

[data-mode="dark"] .price-cards-error p {
  color: #f87171;
}

.price-card {
  background: #ffffff;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .price-card {
  background: #1f2937;
}

.price-card-header {
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .price-card-header {
  border-bottom-color: #374151;
}

.crypto-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.crypto-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

.crypto-info h4 {
  font-size: 18px;
  font-weight: 600;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .crypto-info h4 {
  color: #f9fafb;
}

.price-card-body {
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
}

.price-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.price-label {
  font-size: 13px;
  color: #6b7280;
}

[data-mode="dark"] .price-label {
  color: #9ca3af;
}

.price-value {
  font-size: 18px;
  font-weight: 600;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .price-value {
  color: #f9fafb;
}

.divider {
  width: 1px;
  height: 100%;
  background: #e5e7eb;
  margin: 0 16px;
}

[data-mode="dark"] .divider {
  background: #374151;
}

/* Wallet Section */
.wallet-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  margin-bottom: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .wallet-section {
  background: #1f2937;
}

.section-header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
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

.asset-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.asset-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

.asset-name {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .asset-name {
  color: #f9fafb;
}

.chain-name {
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
}

[data-mode="dark"] .chain-name {
  color: #9ca3af;
}

.wallet-address {
  font-size: 13px;
  font-weight: 500;
  color: #181818;
  font-family: monospace;
}

.wallet-address.not-set {
  color: #9ca3af;
  font-style: italic;
}

[data-mode="dark"] .wallet-address {
  color: #f9fafb;
}

[data-mode="dark"] .wallet-address.not-set {
  color: #6b7280;
}

.btn-copy {
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

.btn-copy:hover:not(:disabled) {
  background: #1e40af;
}

.btn-copy:disabled {
  background: #d1d5db;
  color: #9ca3af;
  cursor: not-allowed;
  opacity: 0.6;
}

[data-mode="dark"] .btn-copy:disabled {
  background: #4b5563;
  color: #6b7280;
}

.btn-copy i {
  font-size: 12px;
}

/* Mobile Card View */
.holdings-cards-mobile {
  display: none;
}

.wallet-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 12px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .wallet-card {
  background: #374151;
  border-color: #4b5563;
}

.wallet-card-header {
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .wallet-card-header {
  border-bottom-color: #4b5563;
}

.wallet-card-body {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.wallet-card-row {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.holding-label {
  font-size: 13px;
  color: #6b7280;
  font-weight: 500;
}

[data-mode="dark"] .holding-label {
  color: #9ca3af;
}

.wallet-address-mobile {
  font-size: 12px;
  font-weight: 500;
  color: #181818;
  font-family: monospace;
  word-break: break-all;
}

.wallet-address-mobile.not-set {
  color: #9ca3af;
  font-style: italic;
}

[data-mode="dark"] .wallet-address-mobile {
  color: #f9fafb;
}

[data-mode="dark"] .wallet-address-mobile.not-set {
  color: #6b7280;
}

.btn-copy-mobile {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-copy-mobile:hover:not(:disabled) {
  background: #1e40af;
}

.btn-copy-mobile:disabled {
  background: #d1d5db;
  color: #9ca3af;
  cursor: not-allowed;
  opacity: 0.6;
}

[data-mode="dark"] .btn-copy-mobile:disabled {
  background: #4b5563;
  color: #6b7280;
}

/* Transactions Section */
.transactions-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .transactions-section {
  background: #1f2937;
}

.transactions-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.no-transactions {
  text-align: center;
  padding: 40px;
  color: #6b7280;
}

[data-mode="dark"] .no-transactions {
  color: #9ca3af;
}

.transaction-item {
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding: 16px;
  background: #f9fafb;
  border-radius: 8px;
  transition: all 0.2s ease;
}

[data-mode="dark"] .transaction-item {
  background: #374151;
}

.transaction-item-top {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
}

.transaction-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}

.transaction-icon.deposit {
  background: #d1fae5;
  color: #059669;
}

.transaction-icon.withdrawal {
  background: #fee2e2;
  color: #dc2626;
}

.transaction-details {
  flex: 1;
  min-width: 0;
}

.transaction-type {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 4px;
  color: #181818;
}

[data-mode="dark"] .transaction-type {
  color: #f9fafb;
}

.transaction-date {
  font-size: 12px;
  color: #6b7280;
  margin-bottom: 4px;
}

[data-mode="dark"] .transaction-date {
  color: #9ca3af;
}

.transaction-asset {
  font-size: 12px;
  color: #6b7280;
  font-weight: 500;
}

[data-mode="dark"] .transaction-asset {
  color: #9ca3af;
}

.transaction-amount {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 4px;
  flex-shrink: 0;
}

.amount {
  font-size: 15px;
  font-weight: 600;
}

.amount.deposit {
  color: #059669;
}

.amount.withdrawal {
  color: #dc2626;
}

.amount-usd {
  font-size: 12px;
  color: #6b7280;
}

[data-mode="dark"] .amount-usd {
  color: #9ca3af;
}

.transaction-status {
  width: 100%;
  text-align: center;
  padding: 8px;
  font-size: 12px;
  font-weight: 500;
  border-radius: 6px;
}

.transaction-status.completed {
  background: #d1fae5;
  color: #059669;
}

.transaction-status.pending {
  background: #fef3c7;
  color: #d97706;
}

.transaction-status.failed {
  background: #fee2e2;
  color: #ef4444;
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

  .crypto-price-cards {
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
}

@media (max-width: 768px) {
  .dashboard-wrapper {
    margin-top: 60px;
  }

  .dashboard-content {
    padding: 12px;
  }

  .page-header h4 {
    font-size: 20px;
  }

  .crypto-price-cards {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .price-card {
    padding: 16px;
  }

  .wallet-section {
    padding: 16px;
    margin-bottom: 16px;
  }

  .holdings-table-wrapper {
    display: none;
  }

  .holdings-cards-mobile {
    display: block;
  }

  .transactions-section {
    padding: 16px;
  }
}

@media (max-width: 480px) {
  .dashboard-content {
    padding: 8px;
  }

  .price-card,
  .wallet-section,
  .transactions-section {
    padding: 12px;
    border-radius: 8px;
  }
}
</style>

