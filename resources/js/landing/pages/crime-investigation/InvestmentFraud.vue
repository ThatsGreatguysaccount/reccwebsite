<template>
  <div class="landing-page">
    <Header @open-sidebar="sidebarOpen = true" />
    <OffCanvas :isOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />
    
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area" style="background-image: url(/landing/img/bg/team-bg.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="breadcrumb-title">
                        <div class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                            <h2>Crime Investigation</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Investment Fraud</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-1">
            <img src="/landing/img/shape/shape-5.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="100">
        </div>
        <div class="shape-2">
            <img src="/landing/img/shape/shape-6.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="200">
        </div>
        <div class="shape-3">
            <img src="/landing/img/shape/shape-7.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="300">
        </div>
        <div class="shape-4">
            <img src="/landing/img/shape/shape-8.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="100">
        </div>
        <div class="shape-5">
            <img src="/landing/img/shape/shape-9.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="200">
        </div>
        <div class="shape-6">
            <img src="/landing/img/shape/shape-10.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="300">
        </div>
    </div>
    <!-- breadcrumb-area end -->

    <div class="service-details pt-150 pb-150 pt-lg-80 pb-lg-80 pt-md-80 pb-md-80 pt-xs-60 pb-xs-60">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 order-2 order-xl-1" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="200">
                    <div class="service-sidebar">
                        <div class="sidebar-widget mb-50">
                            <div class="service-category">
                                <router-link to="/crime-investigation/pig-butchering-scams">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-9.svg" alt="icon">
                                    </span>
                                    <span>Pig-Butchering Scams</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/crime-investigation/wallet-compromise">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-10.svg" alt="icon">
                                    </span>
                                    <span>Wallet Compromise</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/crime-investigation/investment-fraud">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-11.svg" alt="icon">
                                    </span>
                                    <span>Investment Fraud</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/crime-investigation/romance-scams">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-12.svg" alt="icon">
                                    </span>
                                    <span>Romance Scams</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/crime-investigation/sim-swapping">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-13.svg" alt="icon">
                                    </span>
                                    <span>SIM-Swapping</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/crime-investigation/corporate-hacks-defi-exploits">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-14.svg" alt="icon">
                                    </span>
                                    <span>Corporate Hacks & DeFi Exploits</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                            </div>
                        </div>
                        <div class="sidebar-widget mb-50">
                            <div class="sidebar-contact-us"
                                style="background-image: url(/landing/img/thumb/thumb-36.png); color: black; border: 3px solid #2563eb; padding: 10px;">
                                <h3 style="color: black;">Contact Us</h3>
                                <p style="color: black;">
                                    Collaboratively engineer prospective imperatives with transparent technology.
                                </p>
                                <form @submit.prevent="handleContactSubmit">
                                    <div class="input-wrap" style="margin-bottom: 10px;">
                                        <input type="text" placeholder="Enter Name" v-model="contactForm.name"
                                            style="color: black; border: 1px solid rgb(0, 0, 0); background-color: rgba(128, 128, 128, 0.5); width: 100%; padding: 5px;">
                                    </div>
                                    <div class="input-wrap" style="margin-bottom: 10px;">
                                        <input type="text" placeholder="Email" v-model="contactForm.email"
                                            style="color: black; border: 1px solid black; background-color: rgba(128, 128, 128, 0.5); width: 100%; padding: 5px;">
                                    </div>
                                    <div class="input-wrap" style="margin-bottom: 10px;">
                                        <textarea placeholder="Write Message" v-model="contactForm.message"
                                            style="color: black; border: 1px solid black; background-color: rgba(128, 128, 128, 0.5); width: 100%; padding: 5px;"></textarea>
                                    </div>
                                    <div class="input-submit" style="margin-bottom: 10px;">
                                        <input type="submit" value="Contact Now"
                                            style="color: black; border: 3px solid #2563eb; background-color: rgba(128, 128, 128, 0.5); padding: 5px 10px;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-1 order-xl-2 mb-lg-50 mb-md-50 mb-xs-50" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="400">
                    <div class="service-details-wrap">
                        <div class="thumb mb-40">
                            <img src="/landing/img/thumb/thumb-37.jpg" alt="thumb">
                        </div>
                        <div class="title mb-30">
                            <h2>Investment Fraud</h2>
                        </div>
                        <div class="text mb-50">
                            <h3>The Rise of Cryptocurrency-Related Investment Scams</h3>
                            <p>
                                Cryptocurrency-related investment scams have proliferated alongside the rapid growth of the digital asset market, posing significant risks to investors worldwide. These scams often promise high returns with little to no risk, enticing individuals to invest their hard-earned money in fraudulent schemes. Common tactics include Ponzi schemes, fake ICOs (Initial Coin Offerings), and pump-and-dump schemes, where scammers artificially inflate the price of a cryptocurrency before selling off their holdings, leaving investors with significant losses.
                            </p>
                            <h4>Common Tactics Used by Scammers</h4>
                            <p>
                                Investment scams in the cryptocurrency space employ a variety of tactics to deceive investors. Ponzi schemes lure investors with the promise of high returns, using funds from new investors to pay earlier investors, creating an illusion of profitability. Fake ICOs offer fraudulent tokens, often backed by fabricated projects, to raise funds from unsuspecting investors. Pump-and-dump schemes involve artificially inflating the price of a cryptocurrency through misleading information, then selling off holdings at the peak, leaving investors with devalued assets. Understanding these tactics is crucial for identifying and avoiding investment scams.
                            </p>
                            <h4>The Impact on Investors</h4>
                            <p>
                                The impact of cryptocurrency-related investment scams on investors can be devastating. Financial losses can be substantial, affecting individuals' savings and financial stability. Beyond the financial damage, victims often experience emotional distress, including feelings of betrayal and embarrassment. The anonymity and decentralized nature of cryptocurrency transactions make it challenging to recover lost funds, adding to the victims' difficulties. At {{ settings.company_name || 'our company' }}, we are dedicated to mitigating these impacts by providing support, forensic analysis, and expertise to help victims navigate the aftermath of investment scams.
                            </p>
                            <h4>{{ settings.company_name || 'Our Company' }}'s Role in Combating Investment Fraud</h4>
                            <p>
                                {{ settings.company_name || 'Our company' }} specializes in investigating cryptocurrency-related investment scams, employing advanced forensic techniques to trace funds, identify perpetrators, and uncover fraudulent activities. Our mission is to protect investors from falling victim to these scams and to hold accountable those responsible for perpetrating them. Through our expertise in blockchain and cryptocurrency forensics, we strive to promote transparency, integrity, and trust within the digital asset ecosystem, safeguarding investors and fostering a safer investment environment.
                            </p>
                            <h4>Advanced Forensic Techniques</h4>
                            <p>
                                Our team utilizes advanced forensic techniques to investigate investment fraud in the cryptocurrency space. By analyzing blockchain transactions, we can trace the flow of funds and identify patterns that indicate fraudulent activity. This detailed analysis allows us to uncover the identities of those behind the scams and provide crucial evidence to law enforcement agencies. Our forensic work is essential in building strong cases against perpetrators and helping victims recover lost funds.
                            </p>
                            <h4>Promoting Transparency and Trust</h4>
                            <p>
                                At {{ settings.company_name || 'our company' }}, promoting transparency and trust within the digital asset ecosystem is a core part of our mission. We believe that by exposing fraudulent activities and holding scammers accountable, we can contribute to a safer and more trustworthy investment environment. Our commitment to transparency extends to educating the public about the risks and warning signs of investment scams, empowering investors to make informed decisions and protect their assets.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import { onMounted } from 'vue'
import Header from '../../components/layouts/Header.vue'
import Footer from '../../components/layouts/Footer.vue'
import OffCanvas from '../../components/layouts/OffCanvas.vue'
import { useSettings } from '../../composables/useSettings'

export default {
  name: 'CrimeInvestigationInvestmentFraud',
  components: {
    Header,
    Footer,
    OffCanvas
  },
  setup() {
    const { settings, fetchSettings } = useSettings()
    
    onMounted(() => {
      fetchSettings()
      if (window.AOS) {
        window.AOS.init();
      }
    })
    
    return {
      settings
    }
  },
  data() {
    return {
      sidebarOpen: false,
      contactForm: {
        name: '',
        email: '',
        message: ''
      }
    }
  },
  methods: {
    handleContactSubmit() {
      console.log('Contact form submitted:', this.contactForm)
    }
  }
}
</script>

<style scoped>
.breadcrumb-area {
  min-height: 50% !important;
  padding-top: 75px !important;
  padding-bottom: 75px !important;
}

.service-details-wrap .thumb img {
  border-radius: 16px;
  overflow: hidden;
}

.service-details-wrap .thumb {
  overflow: hidden;
  border-radius: 16px;
  margin-top: 10px;
}
</style>

