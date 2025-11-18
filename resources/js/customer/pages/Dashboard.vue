<template>
  <div class="customer-dashboard">
    <Header @toggle-sidebar="toggleMobileSidebar" />
    
    <!-- Mobile Sidebar Overlay -->
    <div v-if="showMobileSidebar" class="sidebar-overlay" @click="closeMobileSidebar"></div>
    
    <!-- Withdrawal Modal -->
    <WithdrawModal 
      :isOpen="showWithdrawModal" 
      :assetType="withdrawModalType"
      :preselectedAsset="preselectedAsset"
      :cryptoHoldings="cryptoHoldings"
      :fiatHoldings="fiatHoldings"
      :cryptoPrices="cryptoPrices"
      @close="closeWithdrawModal"
      @withdrawal-submitted="handleWithdrawalSubmitted"
    />
    
    <!-- Transaction Details Modal -->
    <div v-if="showTransactionModal" class="modal-overlay" @click="closeTransactionModal">
      <div class="modal-content transaction-modal" @click.stop>
        <div class="modal-header">
          <h3>Transaction Details</h3>
          <button class="modal-close" @click="closeTransactionModal">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div v-if="selectedTransaction" class="transaction-details-content">
            <div class="detail-row">
              <span class="detail-label">Type:</span>
              <span class="detail-value">{{ selectedTransaction.type === 'deposit' ? 'Deposit' : 'Withdrawal' }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Asset:</span>
              <span class="detail-value">{{ selectedTransaction.asset }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Amount:</span>
              <span class="detail-value">{{ formatBalance(selectedTransaction.amount) }} {{ selectedTransaction.asset }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Amount (USD):</span>
              <span class="detail-value">${{ formatUSD(selectedTransaction.amountUSD) }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Status:</span>
              <span class="detail-value transaction-status-badge" :class="selectedTransaction.status">{{ selectedTransaction.status }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Date:</span>
              <span class="detail-value">{{ formatDate(selectedTransaction.date) }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Wallet Address:</span>
              <span class="detail-value">{{ selectedTransaction.wallet_address || 'N/A' }}</span>
            </div>
            <div v-if="selectedTransaction.transaction_hash" class="detail-row">
              <span class="detail-label">Transaction Hash:</span>
              <span class="detail-value">{{ selectedTransaction.transaction_hash }}</span>
            </div>
            <div v-if="selectedTransaction.rejection_reason" class="detail-row rejection-reason-row">
              <span class="detail-label">Rejection Reason:</span>
              <span class="detail-value error-text">{{ selectedTransaction.rejection_reason }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
      <div class="dashboard-wrapper">
      <Sidebar :class="{ 'mobile-open': showMobileSidebar }" @sidebar-toggle="handleSidebarToggle" @close-mobile="closeMobileSidebar" />
      
      <div class="dashboard-content" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
      <div class="container-fluid">
        <!-- User Info Section -->
        <div class="user-info-section">
          <div class="user-info-content">
            <div class="user-details">
              <img :src="userAvatar" alt="User Avatar" class="user-avatar" />
              <div class="user-text">
                <h3>{{ userFullName }}</h3>
                <div class="user-id">
                  <span>UID:</span>
                  <span class="user-id-value">{{ userId }}</span>
                  <button class="copy-uid-btn" type="button" @click="copyUserId" title="Copy User ID">
                    <i class="fa-solid fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Get Started Section -->
        <div class="section-header">
          <h4>Get Started</h4>
        </div>

        <!-- Estimated Balance Section -->
        <div class="balance-section">
          <div class="balance-header">
            <div class="balance-title-section">
              <h4>Estimated Balance</h4>
              <p class="balance-subtitle">Your total portfolio value</p>
            </div>
            <div class="withdraw-buttons">
              <button type="button" class="btn-primary" @click="openWithdrawModal('crypto')">
                <i class="fa-solid fa-arrow-up-right"></i>
                Withdraw Crypto
              </button>
              <button type="button" class="btn-primary btn-secondary" @click="openWithdrawModal('fiat')">
                <i class="fa-solid fa-arrow-up-right"></i>
                Withdraw Fiat
              </button>
            </div>
          </div>
          
          <div class="balance-main-content">
            <div class="balance-display">
              <div class="balance-usd">
                <i class="fa-solid fa-dollar-sign"></i>
                <span>${{ formatUSD(totalPortfolioValue) }} USD</span>
              </div>
            </div>
          </div>

          <div class="balance-divider"></div>
          
          <div class="balance-stats">
            <div class="balance-stat">
              <div class="balance-stat-icon deposit">
                <i class="fa-solid fa-arrow-down"></i>
              </div>
              <div class="balance-stat-content">
                <div class="balance-stat-label">Total Deposits</div>
                <div class="balance-stat-value positive">${{ formatUSD(totalDeposits) }}</div>
              </div>
            </div>
            <div class="balance-stat">
              <div class="balance-stat-icon withdrawal">
                <i class="fa-solid fa-arrow-up"></i>
              </div>
              <div class="balance-stat-content">
                <div class="balance-stat-label">Total Withdrawals</div>
                <div class="balance-stat-value negative">${{ formatUSD(totalWithdrawals) }}</div>
              </div>
            </div>
            <div class="balance-stat">
              <div class="balance-stat-icon available">
                <i class="fa-solid fa-wallet"></i>
              </div>
              <div class="balance-stat-content">
                <div class="balance-stat-label">Available Balance</div>
                <div class="balance-stat-value">${{ formatUSD(availableBalance) }}</div>
              </div>
            </div>
            <div class="balance-stat">
              <div class="balance-stat-icon transactions">
                <i class="fa-solid fa-exchange-alt"></i>
              </div>
              <div class="balance-stat-content">
                <div class="balance-stat-label">Total Transactions</div>
                <div class="balance-stat-value">{{ totalTransactions }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Crypto Holdings Section -->
        <div class="crypto-holdings-section">
          <div class="section-header-row">
            <h4>Crypto Holdings</h4>
          </div>
          
          <!-- Desktop Table View -->
          <div class="holdings-table-wrapper">
            <table class="holdings-table">
              <thead>
                <tr>
                  <th>Asset</th>
                  <th>Balance</th>
                  <th>Value (USD)</th>
                  <th>Allocation</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="asset in cryptoHoldings" :key="asset.symbol" class="holdings-row">
                  <td>
                    <div class="asset-info">
                      <img :src="asset.icon" :alt="asset.name" class="asset-icon" />
                      <div>
                        <div class="asset-name">{{ asset.name }}</div>
                        <div class="asset-symbol">{{ asset.symbol }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="holding-balance">{{ formatBalance(asset.balance) }}</td>
                  <td class="holding-value">${{ formatUSD(asset.valueUSD) }}</td>
                  <td>
                    <div class="allocation-cell">
                      <span class="allocation-percentage">{{ formatPercentage(asset.allocation) }}%</span>
                      <div class="allocation-bar">
                        <div class="allocation-fill" :style="{ width: asset.allocation + '%' }"></div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <button class="btn-withdraw" @click="openWithdrawModal('crypto', asset.symbol)">
                      Withdraw
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Mobile Card View -->
          <div class="holdings-cards-mobile">
            <div v-for="asset in cryptoHoldings" :key="asset.symbol" class="holding-card">
              <div class="holding-card-header">
                <div class="asset-info">
                  <img :src="asset.icon" :alt="asset.name" class="asset-icon" />
                  <div>
                    <div class="asset-name">{{ asset.name }}</div>
                    <div class="asset-symbol">{{ asset.symbol }}</div>
                  </div>
                </div>
                <button class="btn-withdraw-mobile" @click="openWithdrawModal('crypto', asset.symbol)">
                  <i class="fa-solid fa-arrow-up-right"></i>
                </button>
              </div>
              <div class="holding-card-body">
                <div class="holding-card-row">
                  <span class="holding-label">Balance</span>
                  <span class="holding-value-mobile">{{ formatBalance(asset.balance) }}</span>
                </div>
                <div class="holding-card-row">
                  <span class="holding-label">Value (USD)</span>
                  <span class="holding-value-mobile">${{ formatUSD(asset.valueUSD) }}</span>
                </div>
                <div class="holding-card-row">
                  <span class="holding-label">Allocation</span>
                  <div class="allocation-mobile">
                    <span class="allocation-percentage">{{ formatPercentage(asset.allocation) }}%</span>
                    <div class="allocation-bar-mobile">
                      <div class="allocation-fill" :style="{ width: asset.allocation + '%' }"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Fiat Holdings Section -->
        <div class="fiat-holdings-section">
          <div class="section-header-row">
            <h4>Fiat Holdings</h4>
          </div>
          
          <!-- Desktop Table View -->
          <div class="holdings-table-wrapper">
            <table class="holdings-table">
              <thead>
                <tr>
                  <th>Currency</th>
                  <th>Balance</th>
                  <th>Value (USD)</th>
                  <th>Allocation</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="currency in fiatHoldings" :key="currency.symbol" class="holdings-row">
                  <td>
                    <div class="asset-info">
                      <img :src="currency.icon" :alt="currency.name" class="asset-icon" />
                      <div>
                        <div class="asset-name">{{ currency.name }}</div>
                        <div class="asset-symbol">{{ currency.symbol }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="holding-balance">{{ formatBalance(currency.balance) }}</td>
                  <td class="holding-value">${{ formatUSD(currency.valueUSD) }}</td>
                  <td>
                    <div class="allocation-cell">
                      <span class="allocation-percentage">{{ formatPercentage(currency.allocation) }}%</span>
                      <div class="allocation-bar">
                        <div class="allocation-fill" :style="{ width: currency.allocation + '%' }"></div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <button class="btn-withdraw" @click="openWithdrawModal('fiat', currency.symbol)">
                      Withdraw
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Mobile Card View -->
          <div class="holdings-cards-mobile">
            <div v-for="currency in fiatHoldings" :key="currency.symbol" class="holding-card">
              <div class="holding-card-header">
                <div class="asset-info">
                  <img :src="currency.icon" :alt="currency.name" class="asset-icon" />
                  <div>
                    <div class="asset-name">{{ currency.name }}</div>
                    <div class="asset-symbol">{{ currency.symbol }}</div>
                  </div>
                </div>
                <button class="btn-withdraw-mobile" @click="openWithdrawModal('fiat', currency.symbol)">
                  <i class="fa-solid fa-arrow-up-right"></i>
                </button>
              </div>
              <div class="holding-card-body">
                <div class="holding-card-row">
                  <span class="holding-label">Balance</span>
                  <span class="holding-value-mobile">{{ formatBalance(currency.balance) }}</span>
                </div>
                <div class="holding-card-row">
                  <span class="holding-label">Value (USD)</span>
                  <span class="holding-value-mobile">${{ formatUSD(currency.valueUSD) }}</span>
                </div>
                <div class="holding-card-row">
                  <span class="holding-label">Allocation</span>
                  <div class="allocation-mobile">
                    <span class="allocation-percentage">{{ formatPercentage(currency.allocation) }}%</span>
                    <div class="allocation-bar-mobile">
                      <div class="allocation-fill" :style="{ width: currency.allocation + '%' }"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Transactions Section -->
        <div class="transactions-section">
          <div class="section-header-row">
            <h4>Recent Transactions</h4>
            <router-link to="/customer/wallet" class="view-all-link">View All</router-link>
          </div>
          <div class="transactions-list">
            <div v-if="recentTransactions.length === 0" class="no-transactions">
              <p>No transactions yet</p>
            </div>
            <div v-for="transaction in recentTransactions" :key="transaction.id" class="transaction-item clickable" @click="openTransactionModal(transaction)">
              <div class="transaction-icon" :class="transaction.type">
                <i :class="transaction.type === 'deposit' ? 'fa-solid fa-arrow-down' : 'fa-solid fa-arrow-up'"></i>
              </div>
              <div class="transaction-details">
                <div class="transaction-info-row">
                  <span class="transaction-type">{{ transaction.type === 'deposit' ? 'Deposit' : 'Withdrawal' }}</span>
                  <span class="transaction-asset">{{ transaction.asset }}</span>
                  <span class="transaction-status" :class="transaction.status">{{ transaction.status }}</span>
                </div>
                <div class="transaction-info-row">
                  <span class="transaction-date">{{ formatDate(transaction.date) }}</span>
                  <span class="amount" :class="transaction.type">
                    {{ transaction.type === 'deposit' ? '+' : '-' }}{{ formatBalance(transaction.amount) }}
                  </span>
                  <span class="amount-usd">${{ formatUSD(transaction.amountUSD) }}</span>
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
import WithdrawModal from '../components/WithdrawModal.vue'

export default {
  name: 'CustomerDashboard',
  components: {
    Header,
    Sidebar,
    WithdrawModal
  },
  data() {
    return {
      sidebarCollapsed: false,
      showMobileSidebar: false,
      showWithdrawModal: false,
      withdrawModalType: 'crypto',
      preselectedAsset: null,
      userFullName: 'John Doe',
      userId: '12345',
      userAvatar: '/customer/images/user.png',
      balances: {
        BTC: 0.0,
        ETH: 0.0,
        TRX: 0.0,
        USDT: 0.0
      },
      cryptoHoldings: [
        {
          symbol: 'BTC',
          name: 'Bitcoin',
          icon: '/customer/images/bitcoin_mid.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        },
        {
          symbol: 'ETH',
          name: 'Ethereum',
          icon: '/customer/images/ethereum_mid.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        },
        {
          symbol: 'TRX',
          name: 'Tron',
          icon: '/customer/images/tron_med.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        },
        {
          symbol: 'USDT',
          name: 'Tether',
          icon: '/customer/images/tether_mid.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        }
      ],
      fiatHoldings: [
        {
          symbol: 'USD',
          name: 'US Dollar',
          icon: '/customer/images/usd.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        },
        {
          symbol: 'EUR',
          name: 'Euro',
          icon: '/customer/images/eur.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        },
        {
          symbol: 'GBP',
          name: 'British Pound',
          icon: '/customer/images/gbp.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        },
        {
          symbol: 'CAD',
          name: 'Canadian Dollar',
          icon: '/customer/images/cad.png',
          balance: 0.0,
          valueUSD: 0.0,
          allocation: 0
        }
      ],
      totalDeposits: 0.0,
      totalWithdrawals: 0.0,
      availableBalance: 0.0,
      totalTransactions: 0,
      recentTransactions: [],
      cryptoPrices: {},
      showTransactionModal: false,
      selectedTransaction: null
    }
  },
  computed: {
    totalPortfolioValue() {
      // Calculate total portfolio value: sum of all crypto holdings USD + all fiat holdings USD
      const totalCryptoUSD = this.cryptoHoldings.reduce((sum, holding) => {
        return sum + (parseFloat(holding.valueUSD) || 0);
      }, 0);
      
      const totalFiatUSD = this.fiatHoldings.reduce((sum, holding) => {
        return sum + (parseFloat(holding.valueUSD) || 0);
      }, 0);
      
      return totalCryptoUSD + totalFiatUSD;
    }
  },
  mounted() {
    this.loadDashboardData();
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
    async loadDashboardData() {
      try {
        const response = await axios.get('/api/v1/customer/dashboard');
        
        if (response.data.success && response.data.data) {
          const data = response.data.data;
          
          // Update user info
          this.userFullName = data.user.fullName;
          this.userId = data.user.uid;
          this.userAvatar = data.user.avatar;
          
          // Update balances
          this.balances = data.balances || {};
          
          // Store crypto prices for calculations
          if (data.cryptoPrices) {
            this.cryptoPrices = data.cryptoPrices;
          }
          
          // Update crypto holdings - ensure all 4 are always present
          const cryptoSymbols = ['BTC', 'ETH', 'TRX', 'USDT'];
          // Create a map of existing holdings from API
          const cryptoHoldingsMap = {};
          if (data.cryptoHoldings && data.cryptoHoldings.length > 0) {
            data.cryptoHoldings.forEach(holding => {
              cryptoHoldingsMap[holding.symbol] = holding;
            });
          }
          
            // Map all 4 cryptos, using API data if available, otherwise default
            this.cryptoHoldings = cryptoSymbols.map(symbol => {
              const holding = cryptoHoldingsMap[symbol];
              if (holding) {
                let valueUSD = holding.valueUSD || 0;
                let price = holding.price || 0;
                const balance = holding.balance || 0;
                
                // If valueUSD is 0 but we have balance and price, recalculate
                if (valueUSD === 0 && balance > 0 && price > 0) {
                  valueUSD = balance * price;
                }
                // If price is 0 but we have balance and valueUSD, calculate price
                else if (price === 0 && balance > 0 && valueUSD > 0) {
                  price = valueUSD / balance;
                }
                // If both are 0 but we have balance, try to get price from cryptoPrices
                else if (valueUSD === 0 && price === 0 && balance > 0 && data.cryptoPrices) {
                  const apiPrice = data.cryptoPrices[symbol];
                  if (apiPrice && apiPrice > 0) {
                    price = typeof apiPrice === 'object' ? apiPrice.price : apiPrice;
                    valueUSD = balance * price;
                  }
                }
                
                return {
                  symbol: holding.symbol,
                  name: holding.name,
                  icon: holding.icon,
                  balance: balance,
                  valueUSD: valueUSD,
                  price: price,
                  allocation: holding.allocation || 0
                };
              } else {
                // Fallback to default if not in API response
                const defaultHolding = this.cryptoHoldings.find(h => h.symbol === symbol);
                return defaultHolding || {
                  symbol: symbol,
                  name: this.getCryptoName(symbol),
                  icon: this.getCryptoIcon(symbol),
                  balance: 0,
                  valueUSD: 0,
                  price: 0,
                  allocation: 0
                };
              }
            });
          
          // Update fiat holdings - ensure all 4 are always present
          const fiatSymbols = ['USD', 'EUR', 'GBP', 'CAD'];
          // Create a map of existing holdings from API
          const fiatHoldingsMap = {};
          if (data.fiatHoldings && data.fiatHoldings.length > 0) {
            data.fiatHoldings.forEach(holding => {
              fiatHoldingsMap[holding.symbol] = holding;
            });
          }
          
          // Map all 4 fiats, using API data if available, otherwise default
          this.fiatHoldings = fiatSymbols.map(symbol => {
            const holding = fiatHoldingsMap[symbol];
            if (holding) {
              return {
                symbol: holding.symbol,
                name: holding.name,
                icon: holding.icon,
                balance: holding.balance || 0,
                valueUSD: holding.valueUSD || 0,
                allocation: holding.allocation || 0
              };
            } else {
              // Fallback to default if not in API response
              const defaultHolding = this.fiatHoldings.find(h => h.symbol === symbol);
              return defaultHolding || {
                symbol: symbol,
                name: this.getFiatName(symbol),
                icon: this.getFiatIcon(symbol),
                balance: 0,
                valueUSD: 0,
                allocation: 0
              };
            }
          });
          
          // Update totals
          this.totalDeposits = data.totalDeposits || 0;
          this.totalWithdrawals = data.totalWithdrawals || 0;
          this.availableBalance = data.availableBalance || 0;
          this.totalTransactions = data.totalTransactions || 0;
          
          // Update recent transactions
          if (data.recentTransactions) {
            this.recentTransactions = data.recentTransactions.map(transaction => ({
              id: transaction.id,
              type: transaction.type,
              asset: transaction.asset,
              amount: transaction.amount,
              amountUSD: transaction.amountUSD,
              status: transaction.status,
              date: transaction.date,
              wallet_address: transaction.wallet_address || null,
              transaction_hash: transaction.transaction_hash || null,
              rejection_reason: transaction.rejection_reason || null
            }));
          }
        }
      } catch (error) {
        console.error('Error loading dashboard data:', error);
        // Ensure holdings are still visible even on error
        // They already have default values in data(), so they'll show with 0 balances
      }
    },
    formatBalance(value) {
      return parseFloat(value).toFixed(8);
    },
    formatUSD(value) {
      return parseFloat(value).toFixed(2);
    },
    formatPercentage(value) {
      return parseFloat(value).toFixed(1);
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    },
    getCryptoName(symbol) {
      const names = {
        'BTC': 'Bitcoin',
        'ETH': 'Ethereum',
        'TRX': 'Tron',
        'USDT': 'Tether'
      };
      return names[symbol] || symbol;
    },
    getCryptoIcon(symbol) {
      const icons = {
        'BTC': '/customer/images/bitcoin_mid.png',
        'ETH': '/customer/images/ethereum_mid.png',
        'TRX': '/customer/images/tron_med.png',
        'USDT': '/customer/images/tether_mid.png'
      };
      return icons[symbol] || '';
    },
    getFiatName(symbol) {
      const names = {
        'USD': 'US Dollar',
        'EUR': 'Euro',
        'GBP': 'British Pound',
        'CAD': 'Canadian Dollar'
      };
      return names[symbol] || symbol;
    },
    getFiatIcon(symbol) {
      const icons = {
        'USD': '/customer/images/usd.png',
        'EUR': '/customer/images/eur.png',
        'GBP': '/customer/images/gbp.png',
        'CAD': '/customer/images/cad.png'
      };
      return icons[symbol] || '';
    },
    updateBalance() {
      // Update balance display when currency changes
    },
    copyUserId() {
      navigator.clipboard.writeText(this.userId);
      // Show toast notification
      alert('User ID copied to clipboard!');
    },
    openWithdrawModal(type = 'crypto', asset = null) {
      this.withdrawModalType = type;
      this.preselectedAsset = asset;
      this.showWithdrawModal = true;
    },
    closeWithdrawModal() {
      this.showWithdrawModal = false;
      this.preselectedAsset = null;
    },
    handleWithdrawalSubmitted(withdrawalData) {
      // Reload dashboard data
      this.loadDashboardData();
    },
    openTransactionModal(transaction) {
      // Open modal for all transactions
      this.selectedTransaction = transaction;
      this.showTransactionModal = true;
    },
    closeTransactionModal() {
      this.showTransactionModal = false;
      this.selectedTransaction = null;
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

/* User Info Section */
.user-info-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 24px;
  margin-bottom: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .user-info-section {
  background: #1f2937;
}

.user-info-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.user-details {
  display: flex;
  align-items: center;
  gap: 16px;
}

.user-avatar {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  object-fit: cover;
}

.user-text h3 {
  font-size: 24px;
  font-weight: 700;
  color: #181818;
  margin: 0 0 8px 0;
}

[data-mode="dark"] .user-text h3 {
  color: #f9fafb;
}

.user-id {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: #6b7280;
}

[data-mode="dark"] .user-id {
  color: #9ca3af;
}

.user-id-value {
  font-weight: 600;
  color: #2563eb;
}

.copy-uid-btn {
  background: none;
  border: none;
  color: #6b7280;
  cursor: pointer;
  padding: 4px;
  border-radius: 4px;
  transition: all 0.2s ease;
}

.copy-uid-btn:hover {
  background: #f3f4f6;
  color: #2563eb;
}

[data-mode="dark"] .copy-uid-btn:hover {
  background: #374151;
  color: #60a5fa;
}

/* Section Headers */
.section-header {
  margin-bottom: 24px;
}

.section-header h4 {
  font-size: 20px;
  font-weight: 700;
  color: #181818;
  margin: 0;
}

[data-mode="dark"] .section-header h4 {
  color: #f9fafb;
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

/* Balance Section */
.balance-section {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
  border-radius: 16px;
  padding: 32px;
  margin-bottom: 32px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border: 1px solid rgba(37, 99, 235, 0.1);
  position: relative;
  overflow: hidden;
}

.balance-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
}

[data-mode="dark"] .balance-section {
  background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
  border-color: rgba(37, 99, 235, 0.2);
}

.balance-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 32px;
}

.balance-title-section {
  flex: 1;
}

.balance-header h4 {
  font-size: 24px;
  font-weight: 700;
  color: #181818;
  margin: 0 0 4px 0;
  letter-spacing: -0.5px;
}

[data-mode="dark"] .balance-header h4 {
  color: #f9fafb;
}

.balance-subtitle {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
}

[data-mode="dark"] .balance-subtitle {
  color: #9ca3af;
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

.btn-secondary {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.btn-secondary:hover {
  box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

.btn-primary:active {
  transform: translateY(0);
}

.withdraw-buttons {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: center;
}

.btn-primary i {
  font-size: 14px;
}

.balance-main-content {
  margin-bottom: 24px;
}

.balance-display {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.balance-amount {
  font-size: 56px;
  font-weight: 800;
  color: #181818;
  margin: 0;
  letter-spacing: -1px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

[data-mode="dark"] .balance-amount {
  background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.balance-usd {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 20px;
  color: #6b7280;
  font-weight: 600;
}

.balance-usd i {
  font-size: 18px;
  color: #2563eb;
}

[data-mode="dark"] .balance-usd {
  color: #9ca3af;
}

[data-mode="dark"] .balance-usd i {
  color: #60a5fa;
}

.balance-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);
  margin: 32px 0;
}

[data-mode="dark"] .balance-divider {
  background: linear-gradient(90deg, transparent 0%, #374151 50%, transparent 100%);
}

.balance-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

.balance-stat {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 20px;
  background: #f9fafb;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
}

.balance-stat:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  border-color: #2563eb;
}

[data-mode="dark"] .balance-stat {
  background: #374151;
  border-color: #4b5563;
}

[data-mode="dark"] .balance-stat:hover {
  border-color: #2563eb;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.balance-stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}

.balance-stat-icon.deposit {
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  color: #059669;
}

.balance-stat-icon.withdrawal {
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  color: #dc2626;
}

.balance-stat-icon.available {
  background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
  color: #2563eb;
}

.balance-stat-icon.transactions {
  background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
  color: #7c3aed;
}

.balance-stat-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.balance-stat-label {
  font-size: 13px;
  color: #6b7280;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

[data-mode="dark"] .balance-stat-label {
  color: #9ca3af;
}

.balance-stat-value {
  font-size: 22px;
  font-weight: 700;
  color: #181818;
  letter-spacing: -0.5px;
}

[data-mode="dark"] .balance-stat-value {
  color: #f9fafb;
}

.balance-stat-value.positive {
  color: #059669;
}

.balance-stat-value.negative {
  color: #dc2626;
}

/* Crypto Holdings Section */
.crypto-holdings-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  margin-bottom: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .crypto-holdings-section {
  background: #1f2937;
}

/* Fiat Holdings Section */
.fiat-holdings-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 32px;
  margin-bottom: 32px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .fiat-holdings-section {
  background: #1f2937;
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

.asset-symbol {
  font-size: 12px;
  color: #6b7280;
}

[data-mode="dark"] .asset-symbol {
  color: #9ca3af;
}

.holding-balance {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .holding-balance {
  color: #f9fafb;
}

.holding-value {
  font-size: 14px;
  color: #6b7280;
}

[data-mode="dark"] .holding-value {
  color: #9ca3af;
}

.allocation-cell {
  display: flex;
  align-items: center;
  gap: 12px;
}

.allocation-percentage {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
  min-width: 40px;
}

[data-mode="dark"] .allocation-percentage {
  color: #f9fafb;
}

.allocation-bar {
  width: 80px;
  height: 8px;
  background: #e5e7eb;
  border-radius: 4px;
  overflow: hidden;
}

[data-mode="dark"] .allocation-bar {
  background: #374151;
}

.allocation-fill {
  height: 100%;
  background: #2563eb;
  border-radius: 4px;
  transition: width 0.3s ease;
}

.btn-withdraw {
  padding: 8px 16px;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-withdraw:hover {
  background: #1e40af;
}

/* Mobile Card View for Holdings */
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

.holding-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 12px;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
}

[data-mode="dark"] .holding-card {
  background: #374151;
  border-color: #4b5563;
}

.holding-card:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

[data-mode="dark"] .holding-card:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.holding-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid #e5e7eb;
}

[data-mode="dark"] .holding-card-header {
  border-bottom-color: #4b5563;
}

.btn-withdraw-mobile {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #2563eb;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-withdraw-mobile:hover {
  background: #1e40af;
  transform: scale(1.05);
}

.btn-withdraw-mobile i {
  font-size: 14px;
}

.holding-card-body {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.holding-card-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.holding-label {
  font-size: 13px;
  color: #6b7280;
  font-weight: 500;
}

[data-mode="dark"] .holding-label {
  color: #9ca3af;
}

.holding-value-mobile {
  font-size: 14px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .holding-value-mobile {
  color: #f9fafb;
}

.allocation-mobile {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
}

.allocation-bar-mobile {
  flex: 1;
  height: 6px;
  background: #e5e7eb;
  border-radius: 3px;
  overflow: hidden;
}

[data-mode="dark"] .allocation-bar-mobile {
  background: #374151;
}

/* Transactions Section */
.transactions-section {
  background: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

[data-mode="dark"] .transactions-section {
  background: #1f2937;
}

.view-all-link {
  color: #2563eb;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
  transition: color 0.2s ease;
}

.view-all-link:hover {
  color: #1e40af;
  text-decoration: underline;
}

.transactions-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
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
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  background: #f9fafb;
  border-radius: 6px;
  transition: all 0.2s ease;
}

[data-mode="dark"] .transaction-item {
  background: #374151;
}

.transaction-item:hover {
  background: #f3f4f6;
}

[data-mode="dark"] .transaction-item:hover {
  background: #4b5563;
}

.transaction-icon {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  flex-shrink: 0;
}

.transaction-icon.deposit {
  background: #d1fae5;
  color: #10b981;
}

.transaction-icon.withdrawal {
  background: #fee2e2;
  color: #ef4444;
}

.transaction-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.transaction-info-row {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 13px;
}

.transaction-type {
  font-size: 13px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .transaction-type {
  color: #f9fafb;
}

.transaction-asset {
  font-size: 12px;
  color: #6b7280;
  font-weight: 500;
}

[data-mode="dark"] .transaction-asset {
  color: #9ca3af;
}

.transaction-date {
  font-size: 11px;
  color: #6b7280;
}

[data-mode="dark"] .transaction-date {
  color: #9ca3af;
}

.amount {
  font-size: 13px;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .amount {
  color: #f9fafb;
}

.amount.deposit {
  color: #10b981;
}

.amount.withdrawal {
  color: #ef4444;
}

.amount-usd {
  font-size: 11px;
  color: #6b7280;
  margin-left: auto;
}

[data-mode="dark"] .amount-usd {
  color: #9ca3af;
}

.transaction-status {
  padding: 2px 8px;
  border-radius: 10px;
  font-size: 10px;
  font-weight: 600;
  text-transform: capitalize;
  margin-left: auto;
}

.transaction-status.completed {
  background: #d1fae5;
  color: #10b981;
}

.transaction-status.pending {
  background: #fef3c7;
  color: #f59e0b;
}

.transaction-status.failed {
  background: #fee2e2;
  color: #ef4444;
}

/* Transaction Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  padding: 20px;
}

.transaction-modal {
  background: #ffffff;
  border-radius: 12px;
  max-width: 500px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

[data-mode="dark"] .transaction-modal {
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
  border-bottom-color: #4b5563;
}

.modal-header h3 {
  margin: 0;
  font-size: 20px;
  font-weight: 700;
  color: #111827;
}

[data-mode="dark"] .modal-header h3 {
  color: #f9fafb;
}

.modal-close {
  background: none;
  border: none;
  font-size: 20px;
  color: #6b7280;
  cursor: pointer;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.modal-close:hover {
  background: #f3f4f6;
  color: #111827;
}

[data-mode="dark"] .modal-close {
  color: #9ca3af;
}

[data-mode="dark"] .modal-close:hover {
  background: #374151;
  color: #f9fafb;
}

.transaction-details-content {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 12px 0;
  border-bottom: 1px solid #f3f4f6;
}

[data-mode="dark"] .detail-row {
  border-bottom-color: #4b5563;
}

.detail-row:last-child {
  border-bottom: none;
}

.detail-label {
  font-size: 14px;
  color: #6b7280;
  font-weight: 500;
  flex-shrink: 0;
  margin-right: 16px;
}

[data-mode="dark"] .detail-label {
  color: #9ca3af;
}

.detail-value {
  font-size: 14px;
  color: #111827;
  font-weight: 600;
  text-align: right;
  word-break: break-word;
  flex: 1;
}

[data-mode="dark"] .detail-value {
  color: #f9fafb;
}

.transaction-status-badge {
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  text-transform: capitalize;
  display: inline-block;
}

.transaction-status-badge.completed {
  background: #d1fae5;
  color: #10b981;
}

.transaction-status-badge.pending {
  background: #fef3c7;
  color: #f59e0b;
}

.transaction-status-badge.failed {
  background: #fee2e2;
  color: #ef4444;
}

.transaction-status-badge.cancelled {
  background: #fee2e2;
  color: #ef4444;
}

.rejection-reason-row {
  background: #fef2f2;
  border-radius: 8px;
  padding: 16px;
  margin-top: 8px;
}

[data-mode="dark"] .rejection-reason-row {
  background: #7f1d1d;
}

.rejection-reason-row .detail-value {
  color: #dc2626;
}

[data-mode="dark"] .rejection-reason-row .detail-value {
  color: #fca5a5;
}

.error-text {
  color: #dc2626;
}

[data-mode="dark"] .error-text {
  color: #fca5a5;
}

.transaction-item.clickable {
  cursor: pointer;
}

.transaction-item.clickable:hover {
  background: #f3f4f6;
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

[data-mode="dark"] .transaction-item.clickable:hover {
  background: #4b5563;
}

/* Sidebar Overlay for Mobile */
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
}

/* Tablet and below */
@media (max-width: 1024px) {
  .dashboard-content {
    margin-left: 0;
    padding: 16px;
  }

  .dashboard-content.sidebar-collapsed {
    margin-left: 0;
  }

  .container-fluid {
    padding: 0;
  }

  .balance-section {
    padding: 24px;
  }

  .crypto-holdings-section {
    padding: 24px;
  }

  .fiat-holdings-section {
    padding: 24px;
  }

  .balance-stats {
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
}

/* Mobile devices */
@media (max-width: 768px) {
  .dashboard-wrapper {
    margin-top: 60px;
  }

  .customer-dashboard {
    overflow-x: hidden;
  }

  .dashboard-content {
    padding: 12px;
  }

  /* User Info Section */
  .user-info-section {
    padding: 16px;
    margin-bottom: 16px;
  }

  .user-info-content {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }

  .user-details {
    width: 100%;
  }

  .user-avatar {
    width: 48px;
    height: 48px;
  }

  .user-text h3 {
    font-size: 18px;
  }

  .user-id {
    font-size: 12px;
  }

  /* Balance Section */
  .balance-section {
    padding: 20px;
    margin-bottom: 16px;
    border-radius: 12px;
  }

  .balance-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
  }

  .balance-header h4 {
    font-size: 20px;
  }

  .balance-subtitle {
    font-size: 13px;
  }

  .withdraw-buttons {
    flex-direction: column;
    width: 100%;
    gap: 10px;
  }

  .btn-primary {
    width: 100%;
    justify-content: center;
    padding: 12px 20px;
  }

  .balance-main-content {
    margin-bottom: 20px;
  }

  .balance-display {
    gap: 14px;
  }

  .balance-amount {
    font-size: 40px;
  }

  .balance-usd {
    font-size: 18px;
  }

  .balance-divider {
    margin: 24px 0;
  }

  .balance-stats {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .balance-stat {
    padding: 16px;
    gap: 14px;
  }

  .balance-stat-icon {
    width: 44px;
    height: 44px;
    font-size: 18px;
  }

  .balance-stat-value {
    font-size: 20px;
  }

  /* Crypto Holdings Section */
  .crypto-holdings-section {
    padding: 16px;
    margin-bottom: 16px;
  }

  /* Fiat Holdings Section */
  .fiat-holdings-section {
    padding: 16px;
    margin-bottom: 16px;
  }

  .section-header-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
  }

  .section-header-row h4 {
    font-size: 18px;
  }

  /* Hide desktop table on mobile */
  .holdings-table-wrapper {
    display: none;
  }

  /* Show mobile cards */
  .holdings-cards-mobile {
    display: block;
  }

  .holding-card {
    margin-bottom: 12px;
  }

  .holding-card-header {
    margin-bottom: 12px;
    padding-bottom: 12px;
  }

  .asset-icon {
    width: 40px;
    height: 40px;
  }

  .asset-name {
    font-size: 14px;
  }

  .asset-symbol {
    font-size: 12px;
  }

  .transaction-modal {
    max-width: 90%;
  }

  .detail-label {
    min-width: auto;
  }

  /* Transactions Section */
  .transactions-section {
    padding: 16px;
    margin-bottom: 16px;
  }

  .transactions-list {
    gap: 10px;
  }

  .transaction-item {
    padding: 12px;
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }

  .transaction-item-top {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
  }

  .transaction-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
  }

  .transaction-details {
    flex: 1;
    min-width: 0;
  }

  .transaction-type {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
  }

  .transaction-date {
    font-size: 12px;
    color: #6b7280;
  }

  [data-mode="dark"] .transaction-date {
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
}

/* Small mobile devices */
@media (max-width: 480px) {
  .dashboard-content {
    padding: 8px;
  }

  .user-info-section,
  .balance-section,
  .crypto-holdings-section,
  .fiat-holdings-section {
    padding: 12px;
    border-radius: 8px;
  }

  .balance-section {
    padding: 16px;
  }

  .balance-header h4 {
    font-size: 18px;
  }

  .balance-amount {
    font-size: 36px;
  }

  .balance-usd {
    font-size: 16px;
  }

  .balance-stat {
    padding: 14px;
  }

  .balance-stat-icon {
    width: 40px;
    height: 40px;
    font-size: 16px;
  }

  .balance-stat-value {
    font-size: 18px;
  }

  .section-header-row h4,
  .balance-header h4 {
    font-size: 16px;
  }

  .holding-card {
    padding: 12px;
  }

  .holding-card-header {
    margin-bottom: 10px;
    padding-bottom: 10px;
  }

  .asset-icon {
    width: 36px;
    height: 36px;
  }

  .btn-withdraw-mobile {
    width: 32px;
    height: 32px;
  }

  .holding-card-body {
    gap: 10px;
  }

  .holding-label {
    font-size: 12px;
  }

  .holding-value-mobile {
    font-size: 13px;
  }

  .transaction-item {
    padding: 10px;
    gap: 10px;
  }

  .transaction-icon {
    width: 36px;
    height: 36px;
  }

  .transaction-type {
    font-size: 13px;
  }

  .transaction-date {
    font-size: 11px;
  }

  .amount {
    font-size: 14px;
  }

  .amount-usd {
    font-size: 11px;
  }

  .transaction-status {
    padding: 6px;
    font-size: 11px;
  }
}
</style>

