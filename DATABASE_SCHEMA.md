# Database Schema Documentation

## Overview
This document outlines all database tables and fields required for the Platform application based on the current implementation.

---

## 1. USER INFORMATION & HOLDINGS

### Table: `users`
**Purpose**: Store user account information and profile data

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | User ID |
| `username` | VARCHAR(255) | UNIQUE, NOT NULL | Username for login |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | User email address |
| `password` | VARCHAR(255) | NOT NULL | Hashed password |
| `uid` | VARCHAR(255) | UNIQUE, NULLABLE | Unique user identifier (e.g., UID12345678) |
| `first_name` | VARCHAR(255) | NULLABLE | User's first name |
| `last_name` | VARCHAR(255) | NULLABLE | User's last name |
| `email_verified_at` | TIMESTAMP | NULLABLE | Email verification timestamp |
| `remember_token` | VARCHAR(100) | NULLABLE | Remember me token |
| `account_type` | ENUM('user', 'administrator') | DEFAULT 'user' | Account type: user or administrator |
| `country` | VARCHAR(255) | NULLABLE | User's country |
| `address1` | VARCHAR(255) | NULLABLE | Address line 1 |
| `address2` | VARCHAR(255) | NULLABLE | Address line 2 |
| `zip_code` | VARCHAR(50) | NULLABLE | Zip/Postal code |
| `id_verification_status` | ENUM('pending', 'verified', 'rejected') | DEFAULT 'pending' | ID verification status |
| `bank_verification_status` | ENUM('pending', 'verified', 'rejected') | DEFAULT 'pending' | Bank verification status |
| `front_id` | VARCHAR(255) | NULLABLE | Path to front ID document image |
| `back_id` | VARCHAR(255) | NULLABLE | Path to back ID document image |
| `bank_statement` | VARCHAR(255) | NULLABLE | Path to bank statement document |
| `avatar` | VARCHAR(255) | NULLABLE | Path to user avatar image |
| `created_at` | TIMESTAMP | NULLABLE | Account creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

---

### Table: `crypto_holdings`
**Purpose**: Store user's cryptocurrency holdings

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Holding ID |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NOT NULL | User who owns the holding |
| `symbol` | VARCHAR(10) | NOT NULL | Crypto symbol (BTC, ETH, TRX, USDT) |
| `balance` | DECIMAL(20, 8) | DEFAULT 0.00000000 | Current balance |
| `value_usd` | DECIMAL(15, 2) | DEFAULT 0.00 | Current value in USD |
| `allocation_percentage` | DECIMAL(5, 2) | DEFAULT 0.00 | Portfolio allocation percentage |
| `created_at` | TIMESTAMP | NULLABLE | Creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes**: 
- `idx_user_symbol` on (`user_id`, `symbol`) - UNIQUE

---

### Table: `fiat_holdings`
**Purpose**: Store user's fiat currency holdings

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Holding ID |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NOT NULL | User who owns the holding |
| `symbol` | VARCHAR(10) | NOT NULL | Fiat symbol (USD, EUR, GBP, CAD) |
| `balance` | DECIMAL(15, 2) | DEFAULT 0.00 | Current balance |
| `value_usd` | DECIMAL(15, 2) | DEFAULT 0.00 | Current value in USD |
| `allocation_percentage` | DECIMAL(5, 2) | DEFAULT 0.00 | Portfolio allocation percentage |
| `created_at` | TIMESTAMP | NULLABLE | Creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes**: 
- `idx_user_symbol` on (`user_id`, `symbol`) - UNIQUE

---

### Table: `wallet_addresses`
**Purpose**: Store user's cryptocurrency wallet addresses

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Address ID |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NOT NULL | User who owns the wallet |
| `symbol` | VARCHAR(10) | NOT NULL | Crypto symbol (BTC, ETH, TRX, USDT) |
| `chain` | VARCHAR(50) | NOT NULL | Blockchain network (Blockchain, Ethereum, Tron) |
| `address` | VARCHAR(255) | NULLABLE | Wallet address |
| `created_at` | TIMESTAMP | NULLABLE | Creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes**: 
- `idx_user_symbol` on (`user_id`, `symbol`) - UNIQUE

---

### Table: `withdrawal_requests`
**Purpose**: Store user withdrawal requests with status tracking

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Request ID |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NOT NULL | User who made the request |
| `type` | ENUM('crypto', 'fiat') | NOT NULL | Withdrawal type |
| `asset` | VARCHAR(10) | NOT NULL | Asset symbol (BTC, ETH, TRX, USDT, USD, EUR, GBP, CAD) |
| `amount` | DECIMAL(20, 8) | NOT NULL | Withdrawal amount |
| `amount_usd` | DECIMAL(15, 2) | NOT NULL | Withdrawal amount in USD |
| `wallet_address` | VARCHAR(255) | NULLABLE | Wallet address (for crypto withdrawals) |
| `bank_account` | TEXT | NULLABLE | Bank account details (for fiat withdrawals) |
| `network_fee` | DECIMAL(20, 8) | DEFAULT 0.00000000 | Network/processing fee |
| `status` | ENUM('pending', 'confirmed', 'rejected') | DEFAULT 'pending' | Request status |
| `rejection_reason` | TEXT | NULLABLE | Reason for rejection (if rejected) |
| `notes` | TEXT | NULLABLE | User notes or admin notes |
| `confirmed_at` | TIMESTAMP | NULLABLE | Confirmation timestamp |
| `rejected_at` | TIMESTAMP | NULLABLE | Rejection timestamp |
| `confirmed_by` | BIGINT UNSIGNED | NULLABLE | Admin user ID who confirmed |
| `rejected_by` | BIGINT UNSIGNED | NULLABLE | Admin user ID who rejected |
| `transaction_hash` | VARCHAR(255) | NULLABLE | Blockchain transaction hash (when processed) |
| `created_at` | TIMESTAMP | NULLABLE | Request creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes**: 
- `idx_user_id` on (`user_id`)
- `idx_user_status` on (`user_id`, `status`)
- `idx_status` on (`status`)
- `idx_type` on (`type`)

---

### Table: `transactions`
**Purpose**: Store completed transactions (deposits, approved withdrawals)

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Transaction ID |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NOT NULL | User who made the transaction |
| `withdrawal_request_id` | BIGINT UNSIGNED | FOREIGN KEY → withdrawal_requests.id, NULLABLE | Related withdrawal request (if applicable) |
| `type` | ENUM('deposit', 'withdrawal') | NOT NULL | Transaction type |
| `asset` | VARCHAR(10) | NOT NULL | Asset symbol (BTC, ETH, TRX, USDT, USD, EUR, GBP, CAD) |
| `amount` | DECIMAL(20, 8) | NOT NULL | Transaction amount |
| `amount_usd` | DECIMAL(15, 2) | NOT NULL | Transaction amount in USD |
| `status` | ENUM('pending', 'completed', 'failed', 'cancelled') | DEFAULT 'pending' | Transaction status |
| `wallet_address` | VARCHAR(255) | NULLABLE | Wallet address used (for withdrawals) |
| `transaction_hash` | VARCHAR(255) | NULLABLE | Blockchain transaction hash |
| `notes` | TEXT | NULLABLE | Additional notes |
| `date_time` | TIMESTAMP | NOT NULL | Transaction date and time |
| `created_at` | TIMESTAMP | NULLABLE | Record creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes**: 
- `idx_user_id` on (`user_id`)
- `idx_user_date` on (`user_id`, `date_time`)
- `idx_status` on (`status`)
- `idx_type` on (`type`)
- `idx_withdrawal_request` on (`withdrawal_request_id`)

---

## 2. COMPANY/SETTINGS INFORMATION

### Table: `settings`
**Purpose**: Store company-wide settings and configuration

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Setting ID |
| `key` | VARCHAR(255) | UNIQUE, NOT NULL | Setting key (e.g., 'company_name', 'contact_email') |
| `value` | TEXT | NULLABLE | Setting value |
| `type` | VARCHAR(50) | DEFAULT 'text' | Setting type (text, number, boolean, json) |
| `description` | TEXT | NULLABLE | Setting description |
| `created_at` | TIMESTAMP | NULLABLE | Creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Required Settings Keys**:

**Company Information**:
- `company_name` - Company name
- `company_email` - Support/contact email
- `company_phone` - Contact phone number
- `company_address` - Physical address
- `company_address_map_url` - Google Maps or map service URL for company location
- `company_number` - Alternative phone number format
- `company_website` - Company website URL
- `company_working_hours` - Business hours (e.g., "10:00AM - 10:00PM")
- `tidio_link` - Tidio chat widget link/ID for customer support

**SMTP Settings (Zoho - for password recovery)**:
- `smtp_host` - SMTP server host (e.g., smtp.zoho.com)
- `smtp_port` - SMTP port (e.g., 587 for TLS, 465 for SSL)
- `smtp_username` - SMTP authentication username/email
- `smtp_password` - SMTP authentication password (encrypted)
- `smtp_encryption` - Encryption type (tls, ssl, or null)
- `smtp_from_email` - Email address to send from
- `smtp_from_name` - Display name for sender (e.g., "Platform Support")
- `smtp_enabled` - Boolean flag to enable/disable SMTP (default: false)

---

### Table: `contact_messages`
**Purpose**: Store contact form submissions from users

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Message ID |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NULLABLE | User who sent the message (if logged in) |
| `name` | VARCHAR(255) | NULLABLE | Sender's name (if not logged in) |
| `email` | VARCHAR(255) | NOT NULL | Sender's email |
| `subject` | VARCHAR(255) | NOT NULL | Message subject |
| `message` | TEXT | NOT NULL | Message content |
| `status` | ENUM('new', 'read', 'replied', 'archived') | DEFAULT 'new' | Message status |
| `read_at` | TIMESTAMP | NULLABLE | When message was read |
| `replied_at` | TIMESTAMP | NULLABLE | When message was replied to |
| `created_at` | TIMESTAMP | NULLABLE | Message creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes**: 
- `idx_user_id` on (`user_id`)
- `idx_status` on (`status`)

---

## 3. AUTHENTICATION & SESSIONS

### Table: `personal_access_tokens`
**Purpose**: Laravel Sanctum API tokens (already exists)

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY | Token ID |
| `tokenable_type` | VARCHAR(255) | NOT NULL | Model type (App\Models\User) |
| `tokenable_id` | BIGINT UNSIGNED | NOT NULL | User ID |
| `name` | VARCHAR(255) | NOT NULL | Token name |
| `token` | VARCHAR(64) | UNIQUE, NOT NULL | Hashed token |
| `abilities` | TEXT | NULLABLE | Token abilities |
| `last_used_at` | TIMESTAMP | NULLABLE | Last usage timestamp |
| `expires_at` | TIMESTAMP | NULLABLE | Token expiration |
| `created_at` | TIMESTAMP | NULLABLE | Creation timestamp |
| `updated_at` | TIMESTAMP | NULLABLE | Last update timestamp |

---

### Table: `sessions`
**Purpose**: Laravel session storage (already exists)

---

### Table: `password_reset_tokens`
**Purpose**: Password reset tokens (already exists)

---

### Table: `cache` & `cache_locks`
**Purpose**: Laravel cache storage (already exists)

---

## 4. SUMMARY OF REQUIRED TABLES

### Must Create:
1. ✅ `users` - Enhanced with profile fields
2. ✅ `crypto_holdings` - User crypto balances
3. ✅ `fiat_holdings` - User fiat balances
4. ✅ `wallet_addresses` - User wallet addresses
5. ✅ `transactions` - Transaction history
6. ❌ `crypto_prices` - Removed (using external API for real-time prices)
7. ✅ `settings` - Company settings
8. ✅ `contact_messages` - Contact form submissions

### Already Exists:
- ✅ `personal_access_tokens` (Laravel Sanctum)
- ✅ `sessions` (Laravel)
- ✅ `password_reset_tokens` (Laravel)
- ✅ `cache` & `cache_locks` (Laravel)

---

## 5. DATA RELATIONSHIPS

```
users (1) ──< (many) crypto_holdings
users (1) ──< (many) fiat_holdings
users (1) ──< (many) wallet_addresses
users (1) ──< (many) transactions
users (1) ──< (many) contact_messages
users (1) ──< (many) personal_access_tokens
```

---

## 6. CALCULATED FIELDS (Computed in Application)

These fields are calculated from database data and don't need separate tables:

- **Total Deposits**: Sum of all `transactions` where `type = 'deposit'` and `status = 'completed'`
- **Total Withdrawals**: Sum of all `transactions` where `type = 'withdrawal'` and `status = 'completed'`
- **Available Balance**: Sum of all `crypto_holdings.value_usd` + `fiat_holdings.value_usd`
- **Total Transactions**: Count of `transactions` for user
- **Portfolio Allocation**: Calculated from individual holdings vs total portfolio value

---

## 7. NOTES

- All monetary values should use DECIMAL type for precision
- Crypto balances use 8 decimal places (standard for most cryptocurrencies)
- Fiat balances use 2 decimal places
- All timestamps use Laravel's standard timestamp format
- Foreign keys should have CASCADE on delete for data integrity
- Consider adding soft deletes for important tables (users, transactions)

