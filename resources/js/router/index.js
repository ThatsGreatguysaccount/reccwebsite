import { createRouter, createWebHistory } from 'vue-router';

// Main Landing Pages
import LandingIndex from '../landing/pages/Index.vue';
import About from '../landing/pages/About.vue';
import Contact from '../landing/pages/Contact.vue';
import Team from '../landing/pages/Team.vue';
import Faq from '../landing/pages/Faq.vue';
import SignIn from '../landing/pages/SignIn.vue';
import SignUp from '../landing/pages/SignUp.vue';

// Practice Areas Pages
import PracticeAreasDivorce from '../landing/pages/practice-areas/Divorce.vue';
import PracticeAreasBankruptcy from '../landing/pages/practice-areas/Bankruptcy.vue';
import PracticeAreasBusinessDisputes from '../landing/pages/practice-areas/BusinessDisputes.vue';
import PracticeAreasCivilProsecution from '../landing/pages/practice-areas/CivilProsecution.vue';
import PracticeAreasConsumerProtection from '../landing/pages/practice-areas/ConsumerProtection.vue';
import PracticeAreasCriminalDefense from '../landing/pages/practice-areas/CriminalDefense.vue';
import PracticeAreasEstateAdministration from '../landing/pages/practice-areas/EstateAdministration.vue';

// Crime Investigation Pages
import CrimeInvestigationCorporateHacks from '../landing/pages/crime-investigation/CorporateHacksDeFiExploits.vue';
import CrimeInvestigationInvestmentFraud from '../landing/pages/crime-investigation/InvestmentFraud.vue';
import CrimeInvestigationPigButchering from '../landing/pages/crime-investigation/PigButcheringScams.vue';
import CrimeInvestigationRomanceScams from '../landing/pages/crime-investigation/RomanceScams.vue';
import CrimeInvestigationSIMSwapping from '../landing/pages/crime-investigation/SIMSwapping.vue';
import CrimeInvestigationWalletCompromise from '../landing/pages/crime-investigation/WalletCompromise.vue';

// Services Pages
import ServicesDiscoverySupport from '../landing/pages/services/DiscoverySupport.vue';
import ServicesEvidentiaryStrategy from '../landing/pages/services/EvidentiaryStrategy.vue';
import ServicesExpertTestimony from '../landing/pages/services/ExpertTestimony.vue';
import ServicesForensicInvestigation from '../landing/pages/services/ForensicInvestigation.vue';

// Customer Pages
import CustomerDashboard from '../customer/pages/Dashboard.vue';
import CustomerWallet from '../customer/pages/Wallet.vue';
import CustomerSettings from '../customer/pages/Settings.vue';
import CustomerPassword from '../customer/pages/Password.vue';
import CustomerContact from '../customer/pages/Contact.vue';

// Admin Pages
import AdminAccounts from '../admin/pages/Accounts.vue';
import AdminTransactions from '../admin/pages/Transactions.vue';
import AdminSettings from '../admin/pages/Settings.vue';

// Old pages (keeping for reference)
import Home from '../views/Home.vue';
import Users from '../views/Users.vue';

const routes = [
  // Landing Pages
  {
    path: '/',
    name: 'Landing',
    component: LandingIndex
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact
  },
  {
    path: '/team',
    name: 'Team',
    component: Team
  },
  {
    path: '/faq',
    name: 'Faq',
    component: Faq
  },
  {
    path: '/sign-in',
    name: 'SignIn',
    component: SignIn
  },
  {
    path: '/sign-up',
    name: 'SignUp',
    component: SignUp
  },
  
  // Practice Areas Routes
  {
    path: '/practice-areas/divorce',
    name: 'PracticeAreasDivorce',
    component: PracticeAreasDivorce
  },
  {
    path: '/practice-areas/bankruptcy',
    name: 'PracticeAreasBankruptcy',
    component: PracticeAreasBankruptcy
  },
  {
    path: '/practice-areas/business-disputes',
    name: 'PracticeAreasBusinessDisputes',
    component: PracticeAreasBusinessDisputes
  },
  {
    path: '/practice-areas/civil-prosecution',
    name: 'PracticeAreasCivilProsecution',
    component: PracticeAreasCivilProsecution
  },
  {
    path: '/practice-areas/consumer-protection',
    name: 'PracticeAreasConsumerProtection',
    component: PracticeAreasConsumerProtection
  },
  {
    path: '/practice-areas/criminal-defense',
    name: 'PracticeAreasCriminalDefense',
    component: PracticeAreasCriminalDefense
  },
  {
    path: '/practice-areas/estate-administration',
    name: 'PracticeAreasEstateAdministration',
    component: PracticeAreasEstateAdministration
  },
  
  // Crime Investigation Routes
  {
    path: '/crime-investigation/corporate-hacks-defi-exploits',
    name: 'CrimeInvestigationCorporateHacks',
    component: CrimeInvestigationCorporateHacks
  },
  {
    path: '/crime-investigation/investment-fraud',
    name: 'CrimeInvestigationInvestmentFraud',
    component: CrimeInvestigationInvestmentFraud
  },
  {
    path: '/crime-investigation/pig-butchering-scams',
    name: 'CrimeInvestigationPigButchering',
    component: CrimeInvestigationPigButchering
  },
  {
    path: '/crime-investigation/romance-scams',
    name: 'CrimeInvestigationRomanceScams',
    component: CrimeInvestigationRomanceScams
  },
  {
    path: '/crime-investigation/sim-swapping',
    name: 'CrimeInvestigationSIMSwapping',
    component: CrimeInvestigationSIMSwapping
  },
  {
    path: '/crime-investigation/wallet-compromise',
    name: 'CrimeInvestigationWalletCompromise',
    component: CrimeInvestigationWalletCompromise
  },
  
  // Services Routes
  {
    path: '/services/discovery-support',
    name: 'ServicesDiscoverySupport',
    component: ServicesDiscoverySupport
  },
  {
    path: '/services/evidentiary-strategy',
    name: 'ServicesEvidentiaryStrategy',
    component: ServicesEvidentiaryStrategy
  },
  {
    path: '/services/expert-testimony',
    name: 'ServicesExpertTestimony',
    component: ServicesExpertTestimony
  },
  {
    path: '/services/forensic-investigation',
    name: 'ServicesForensicInvestigation',
    component: ServicesForensicInvestigation
  },
  
  // Customer Routes
  {
    path: '/customer/dashboard',
    name: 'CustomerDashboard',
    component: CustomerDashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/customer/wallet',
    name: 'CustomerWallet',
    component: CustomerWallet,
    meta: { requiresAuth: true }
  },
  {
    path: '/customer/settings',
    name: 'CustomerSettings',
    component: CustomerSettings,
    meta: { requiresAuth: true }
  },
  {
    path: '/customer/password',
    name: 'CustomerPassword',
    component: CustomerPassword,
    meta: { requiresAuth: true }
  },
  {
    path: '/customer/contact',
    name: 'CustomerContact',
    component: CustomerContact,
    meta: { requiresAuth: true }
  },
  
  // Admin Routes
  {
    path: '/admin/accounts',
    name: 'AdminAccounts',
    component: AdminAccounts,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/transactions',
    name: 'AdminTransactions',
    component: AdminTransactions,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/settings',
    name: 'AdminSettings',
    component: AdminSettings,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  
  // Old routes (keeping for reference)
  {
    path: '/old-home',
    name: 'Home',
    component: Home
  },
  {
    path: '/users',
    name: 'Users',
    component: Users
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation guard to protect authenticated routes
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth_token');
  const user = JSON.parse(localStorage.getItem('user') || '{}');
  
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      // Redirect to login if not authenticated
      next({
        path: '/sign-in',
        query: { redirect: to.fullPath }
      });
    } else if (to.matched.some(record => record.meta.requiresAdmin)) {
      // Check if user is administrator
      if (user.account_type !== 'administrator') {
        // Redirect to customer dashboard if not admin
        next('/customer/dashboard');
      } else {
        next();
      }
    } else {
      next();
    }
  } else {
    // If already authenticated and trying to access login/signup, redirect to dashboard
    if ((to.path === '/sign-in' || to.path === '/sign-up') && isAuthenticated) {
      // Redirect to admin or customer dashboard based on account type
      const redirectPath = user.account_type === 'administrator' ? '/admin/accounts' : '/customer/dashboard';
      next(redirectPath);
    } else {
      next();
    }
  }
});

export default router;
