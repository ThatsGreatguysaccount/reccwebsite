<template>
  <div v-if="isOpen" class="modal-overlay" @click="closeModal">
    <div class="modal-content" @click.stop>
      <div class="modal-header">
        <h4>Withdraw {{ assetType === 'crypto' ? 'Crypto' : 'Fiat' }}</h4>
        <button class="modal-close" @click="closeModal">
          <i class="fa-solid fa-times"></i>
        </button>
      </div>

      <div class="modal-body">
        <div v-if="message" :class="['message', messageType]">
          {{ message }}
        </div>

        <form @submit.prevent="submitWithdrawal" class="withdraw-form">
          <div class="form-group">
            <label for="asset">Select Asset</label>
            <select id="asset" v-model="withdrawData.asset" @change="updateAssetInfo" required>
              <option value="">-- Select Asset --</option>
              <optgroup v-if="assetType === 'crypto'" label="Cryptocurrency">
                <option value="BTC">Bitcoin (BTC)</option>
                <option value="ETH">Ethereum (ETH)</option>
                <option value="TRX">Tron (TRX)</option>
                <option value="USDT">Tether (USDT)</option>
              </optgroup>
              <optgroup v-if="assetType === 'fiat'" label="Fiat Currency">
                <option value="USD">US Dollar (USD)</option>
                <option value="EUR">Euro (EUR)</option>
                <option value="GBP">British Pound (GBP)</option>
                <option value="CAD">Canadian Dollar (CAD)</option>
              </optgroup>
            </select>
          </div>

          <div v-if="withdrawData.asset" class="balance-info">
            <div class="balance-display">
              <span class="balance-label">Available Balance:</span>
              <span class="balance-value">{{ formatBalance(availableBalance) }} {{ withdrawData.asset }}</span>
            </div>
            <div class="balance-usd">
              ≈ ${{ formatUSD(availableBalanceUSD) }} USD
            </div>
          </div>

          <div class="form-group">
            <label for="amount">Amount</label>
            <input 
              type="number" 
              id="amount" 
              v-model.number="withdrawData.amount" 
              :step="assetType === 'crypto' ? '0.00000001' : '0.01'"
              :min="0"
              :max="availableBalance"
              required 
              placeholder="Enter withdrawal amount"
              @input="calculateUSD"
            />
            <div class="input-actions">
              <button type="button" class="btn-max" @click="setMaxAmount">Max</button>
            </div>
            <span v-if="withdrawData.amount > availableBalance" class="error-text">
              Insufficient balance
            </span>
            <div v-if="withdrawData.amount > 0" class="amount-usd-display">
              ≈ ${{ formatUSD(calculatedUSD) }} USD
            </div>
          </div>

          <div v-if="assetType === 'crypto'" class="form-group">
            <label for="walletAddress">Wallet Address</label>
            <input 
              type="text" 
              id="walletAddress" 
              v-model="withdrawData.walletAddress" 
              required 
              placeholder="Enter recipient wallet address"
            />
            <div class="form-help">
              <i class="fa-solid fa-info-circle"></i>
              Make sure the address is correct. Transactions cannot be reversed.
            </div>
          </div>

          <div v-if="assetType === 'fiat'" class="form-group">
            <label for="bankAccount">Bank Account Details</label>
            <textarea 
              id="bankAccount" 
              v-model="withdrawData.bankAccount" 
              required 
              rows="4"
              placeholder="Enter bank account number, routing number, and account holder name"
            ></textarea>
            <div class="form-help">
              <i class="fa-solid fa-info-circle"></i>
              Include all necessary bank details for the withdrawal.
            </div>
          </div>

          <div class="form-group">
            <label for="notes">Notes (Optional)</label>
            <textarea 
              id="notes" 
              v-model="withdrawData.notes" 
              rows="3"
              placeholder="Any additional notes or instructions"
            ></textarea>
          </div>

          <div class="withdrawal-fee-info">
            <div class="fee-item">
              <span>Withdrawal Amount:</span>
              <span>{{ formatBalance(withdrawData.amount || 0) }} {{ withdrawData.asset || '' }}</span>
            </div>
            <div class="fee-item">
              <span>Network Fee:</span>
              <span>{{ formatBalance(networkFee) }} {{ withdrawData.asset || '' }}</span>
            </div>
            <div class="fee-item total">
              <span>You Will Receive:</span>
              <span>{{ formatBalance(receivingAmount) }} {{ withdrawData.asset || '' }}</span>
            </div>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
            <button type="submit" class="btn-submit" :disabled="loading || !isFormValid">
              <span v-if="loading">Processing...</span>
              <span v-else>Submit Withdrawal Request</span>
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
  name: 'WithdrawModal',
  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    assetType: {
      type: String,
      default: 'crypto', // 'crypto' or 'fiat'
      validator: (value) => ['crypto', 'fiat'].includes(value)
    },
    preselectedAsset: {
      type: String,
      default: null
    },
    cryptoHoldings: {
      type: Array,
      default: () => []
    },
    fiatHoldings: {
      type: Array,
      default: () => []
    },
    cryptoPrices: {
      type: Object,
      default: () => ({})
    }
  },
  data() {
    return {
      withdrawData: {
        asset: this.preselectedAsset || '',
        amount: null,
        walletAddress: '',
        bankAccount: '',
        notes: ''
      },
      availableBalance: 0,
      availableBalanceUSD: 0,
      calculatedUSD: 0,
      networkFee: 0,
      cryptoPrice: 0,
      message: '',
      messageType: '',
      loading: false,
      balances: {
        BTC: 0.0,
        ETH: 0.0,
        TRX: 0.0,
        USDT: 0.0,
        USD: 0.0,
        EUR: 0.0,
        GBP: 0.0,
        CAD: 0.0
      }
    }
  },
  computed: {
    isFormValid() {
      if (!this.withdrawData.asset || !this.withdrawData.amount || this.withdrawData.amount <= 0) {
        return false;
      }
      if (this.withdrawData.amount > this.availableBalance) {
        return false;
      }
      if (this.assetType === 'crypto' && !this.withdrawData.walletAddress) {
        return false;
      }
      if (this.assetType === 'fiat' && !this.withdrawData.bankAccount) {
        return false;
      }
      return true;
    },
    receivingAmount() {
      const amount = parseFloat(this.withdrawData.amount) || 0;
      const fee = parseFloat(this.networkFee) || 0;
      return Math.max(0, amount - fee);
    }
  },
  watch: {
    isOpen(newVal) {
      if (newVal) {
        this.resetForm();
        this.loadBalances().then(() => {
          if (this.preselectedAsset) {
            this.withdrawData.asset = this.preselectedAsset;
            this.updateAssetInfo();
          }
        });
      }
    },
    preselectedAsset(newVal) {
      if (newVal && this.isOpen) {
        this.withdrawData.asset = newVal;
        this.updateAssetInfo();
      }
    },
    'withdrawData.asset'(newVal) {
      if (newVal && this.isOpen) {
        this.updateAssetInfo();
      }
    }
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    resetForm() {
      this.withdrawData = {
        asset: this.preselectedAsset || '',
        amount: null,
        walletAddress: '',
        bankAccount: '',
        notes: ''
      };
      this.message = '';
      this.messageType = '';
      this.availableBalance = 0;
      this.availableBalanceUSD = 0;
      this.calculatedUSD = 0;
      this.networkFee = 0;
    },
    async loadBalances() {
      try {
        // First try to use props if available
        if (this.cryptoHoldings && this.cryptoHoldings.length > 0) {
          this.cryptoHoldings.forEach(holding => {
            if (holding && holding.symbol) {
              this.balances[holding.symbol] = parseFloat(holding.balance) || 0;
            }
          });
        }
        
        if (this.fiatHoldings && this.fiatHoldings.length > 0) {
          this.fiatHoldings.forEach(holding => {
            if (holding && holding.symbol) {
              this.balances[holding.symbol] = parseFloat(holding.balance) || 0;
            }
          });
        }
        
        // If props are empty, fetch from API
        if (Object.values(this.balances).every(b => b === 0)) {
          const response = await axios.get('/api/v1/customer/dashboard');
          if (response.data.success && response.data.data) {
            const data = response.data.data;
            
            // Update balances from holdings - load both crypto and fiat
            if (data.cryptoHoldings && Array.isArray(data.cryptoHoldings)) {
              data.cryptoHoldings.forEach(holding => {
                if (holding && holding.symbol) {
                  this.balances[holding.symbol] = parseFloat(holding.balance) || 0;
                }
              });
            }
            
            if (data.fiatHoldings && Array.isArray(data.fiatHoldings)) {
              data.fiatHoldings.forEach(holding => {
                if (holding && holding.symbol) {
                  this.balances[holding.symbol] = parseFloat(holding.balance) || 0;
                }
              });
            }
          }
        }
        
        // If asset is already selected, update its info
        if (this.withdrawData.asset) {
          this.updateAssetInfo();
        }
      } catch (error) {
        console.error('Error loading balances:', error);
      }
    },
    async updateAssetInfo() {
      if (!this.withdrawData.asset) {
        this.availableBalance = 0;
        this.availableBalanceUSD = 0;
        this.cryptoPrice = 0;
        return;
      }
      
      // Get balance from loaded balances
      const balance = parseFloat(this.balances[this.withdrawData.asset]) || 0;
      this.availableBalance = balance;
      
      if (this.assetType === 'crypto') {
        // Get current crypto prices - first try props, then API
        let price = 0;
        
        // Try to get price from props first
        if (this.cryptoPrices && this.cryptoPrices[this.withdrawData.asset]) {
          const priceData = this.cryptoPrices[this.withdrawData.asset];
          if (typeof priceData === 'object' && priceData.price) {
            price = parseFloat(priceData.price) || 0;
          } else if (typeof priceData === 'number') {
            price = priceData;
          }
        }
        
        // If no price from props, fetch from API
        if (price === 0) {
          try {
            const response = await axios.get('/api/v1/customer/crypto-prices');
            if (response.data.success && response.data.data && response.data.data.prices) {
              const prices = response.data.data.prices;
              const priceData = prices[this.withdrawData.asset];
              
              if (priceData) {
                if (typeof priceData === 'object' && priceData.price) {
                  price = parseFloat(priceData.price) || 0;
                } else if (typeof priceData === 'number') {
                  price = priceData;
                }
              }
            }
          } catch (error) {
            console.error('Error fetching crypto prices:', error);
          }
        }
        
        this.cryptoPrice = price;
        this.availableBalanceUSD = balance * price;
        
        // Crypto network fees (example values)
        const fees = {
          'BTC': 0.0001,
          'ETH': 0.001,
          'TRX': 0.1,
          'USDT': 0.001
        };
        this.networkFee = fees[this.withdrawData.asset] || 0;
      } else {
        // Fiat currencies - use exchange rates
        const fiatRates = {
          'USD': 1.0,
          'EUR': 1.1,
          'GBP': 1.27,
          'CAD': 0.74
        };
        const rate = fiatRates[this.withdrawData.asset] || 1.0;
        this.cryptoPrice = rate; // Store rate for calculations
        this.availableBalanceUSD = balance * rate;
        
        // Fiat withdrawal fees (usually a percentage or fixed amount)
        this.networkFee = 0; // Can be calculated as percentage
      }
      
      // Recalculate USD if amount is already entered
      if (this.withdrawData.amount) {
        this.calculateUSD();
      }
    },
    calculateUSD() {
      if (this.withdrawData.amount && this.withdrawData.asset) {
        if (this.assetType === 'crypto' && this.cryptoPrice > 0) {
          this.calculatedUSD = this.withdrawData.amount * this.cryptoPrice;
        } else if (this.assetType === 'fiat') {
          // Use fiat exchange rates
          const fiatRates = {
            'USD': 1.0,
            'EUR': 1.1,
            'GBP': 1.27,
            'CAD': 0.74
          };
          const rate = fiatRates[this.withdrawData.asset] || 1.0;
          this.calculatedUSD = this.withdrawData.amount * rate;
        } else {
          this.calculatedUSD = 0;
        }
      } else {
        this.calculatedUSD = 0;
      }
    },
    setMaxAmount() {
      this.withdrawData.amount = this.availableBalance;
      this.calculateUSD();
    },
    async submitWithdrawal() {
      if (!this.isFormValid) {
        return;
      }

      this.loading = true;
      this.message = '';

      try {
        const withdrawalData = {
          asset: this.withdrawData.asset,
          amount: this.withdrawData.amount,
          type: this.assetType,
          wallet_address: this.withdrawData.walletAddress,
          bank_account: this.withdrawData.bankAccount,
          notes: this.withdrawData.notes,
          network_fee: this.networkFee
        };

        const response = await axios.post('/api/v1/customer/withdrawals', withdrawalData);

        if (response.data.success) {
          this.message = 'Withdrawal request submitted successfully! It will be reviewed by our team.';
          this.messageType = 'success';
        } else {
          throw new Error(response.data.message || 'Failed to submit withdrawal request');
        }

        // Emit success event
        this.$emit('withdrawal-submitted', withdrawalData);

        // Close modal after 2 seconds
        setTimeout(() => {
          this.closeModal();
        }, 2000);
      } catch (error) {
        if (error.response && error.response.data) {
          this.message = error.response.data.message || 'Failed to submit withdrawal request';
        } else {
          this.message = 'Failed to submit withdrawal request. Please try again.';
        }
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },
    formatBalance(value) {
      if (this.assetType === 'crypto') {
        return parseFloat(value).toFixed(8);
      }
      return parseFloat(value).toFixed(2);
    },
    formatUSD(value) {
      return parseFloat(value).toLocaleString('en-US', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
      });
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
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

[data-mode="dark"] .modal-close:hover {
  background: #4b5563;
  color: #f9fafb;
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

.withdraw-form {
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

[data-mode="dark"] .form-group select:focus,
[data-mode="dark"] .form-group input:focus,
[data-mode="dark"] .form-group textarea:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.input-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 4px;
}

.btn-max {
  padding: 4px 12px;
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  color: #2563eb;
  cursor: pointer;
  transition: all 0.2s ease;
}

[data-mode="dark"] .btn-max {
  background: #374151;
  border-color: #4b5563;
  color: #60a5fa;
}

.btn-max:hover {
  background: #e5e7eb;
}

[data-mode="dark"] .btn-max:hover {
  background: #4b5563;
}

.error-text {
  font-size: 12px;
  color: #dc2626;
  margin-top: 4px;
}

.amount-usd-display {
  font-size: 12px;
  color: #6b7280;
  margin-top: 4px;
}

[data-mode="dark"] .amount-usd-display {
  color: #9ca3af;
}

.balance-info {
  padding: 16px;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

[data-mode="dark"] .balance-info {
  background: #374151;
  border-color: #4b5563;
}

.balance-display {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}

.balance-label {
  font-size: 14px;
  color: #6b7280;
  font-weight: 500;
}

[data-mode="dark"] .balance-label {
  color: #9ca3af;
}

.balance-value {
  font-size: 18px;
  font-weight: 700;
  color: #181818;
}

[data-mode="dark"] .balance-value {
  color: #f9fafb;
}

.balance-usd {
  font-size: 13px;
  color: #6b7280;
  text-align: right;
}

[data-mode="dark"] .balance-usd {
  color: #9ca3af;
}

.form-help {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: #6b7280;
  margin-top: 4px;
}

[data-mode="dark"] .form-help {
  color: #9ca3af;
}

.form-help i {
  font-size: 14px;
}

.withdrawal-fee-info {
  padding: 16px;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

[data-mode="dark"] .withdrawal-fee-info {
  background: #374151;
  border-color: #4b5563;
}

.fee-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 14px;
  color: #6b7280;
}

[data-mode="dark"] .fee-item {
  color: #9ca3af;
}

.fee-item.total {
  padding-top: 12px;
  border-top: 1px solid #e5e7eb;
  font-weight: 600;
  color: #181818;
}

[data-mode="dark"] .fee-item.total {
  border-top-color: #4b5563;
  color: #f9fafb;
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

[data-mode="dark"] .btn-cancel:hover {
  background: #4b5563;
  color: #f9fafb;
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
  box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

[data-mode="dark"] .btn-submit {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.btn-submit:hover:not(:disabled) {
  background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

@media (max-width: 768px) {
  .modal-overlay {
    padding: 12px;
  }

  .modal-content {
    max-height: 95vh;
  }

  .modal-header,
  .modal-body {
    padding: 20px;
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

