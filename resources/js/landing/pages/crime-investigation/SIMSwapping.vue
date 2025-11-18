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
                                <li>SIM-Swapping</li>
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
                            <h2>SIM-Swapping</h2>
                        </div>
                        <div class="text mb-50">
                            <h3>Understanding SIM-Swapping</h3>
                            <p>
                                SIM swapping is a cybercrime tactic where attackers gain unauthorized access to a victim's phone number by convincing the mobile carrier to transfer it to a SIM card under their control. Once successful, perpetrators can bypass two-factor authentication, gain access to sensitive personal and financial accounts, and potentially drain cryptocurrency wallets and exchange accounts.
                            </p>
                            <h4>How SIM-Swapping Works</h4>
                            <p>
                                Attackers typically use social engineering techniques to deceive mobile carrier representatives. They may pose as the victim, armed with personal information obtained through phishing, data breaches, or other means. Once the phone number is transferred to the attacker's SIM card, they receive calls and texts meant for the victim, including verification codes for two-factor authentication. This access allows them to reset passwords and gain control of various online accounts.
                            </p>
                            <h4>The Impact of SIM-Swapping</h4>
                            <p>
                                The consequences of SIM swapping can be devastating. Victims can lose access to email accounts, social media profiles, and financial accounts. For cryptocurrency holders, the stakes are even higher, as attackers can quickly transfer digital assets to their own wallets, often making recovery difficult. The financial and emotional toll on victims can be severe, with long-lasting repercussions.
                            </p>
                            <h4>{{ settings.company_name || 'Our Company' }}'s Expertise in Combating SIM-Swapping</h4>
                            <p>
                                {{ settings.company_name || 'Our company' }} has a long-running history of investigating SIM swapping attacks within the context of cryptocurrency theft, utilizing advanced forensic techniques and blockchain analysis to trace stolen funds, identify perpetrators, and assist victims in recovering their assets. Our team is dedicated to combating SIM swapping and other forms of cybercrime, leveraging our expertise in blockchain and cryptocurrency forensics to safeguard the security and integrity of digital assets for individuals and businesses worldwide.
                            </p>
                            <h4>Advanced Forensic Techniques</h4>
                            <p>
                                Our investigators employ cutting-edge forensic techniques to track the movement of stolen cryptocurrency across the blockchain. By analyzing transaction patterns and utilizing sophisticated tools, we can uncover the paths taken by stolen funds and identify those responsible for the theft. This meticulous approach aids in the recovery of assets and the prosecution of offenders.
                            </p>
                            <h4>Comprehensive Support for Victims</h4>
                            <p>
                                Supporting victims of SIM swapping is a core component of our mission. We provide guidance on immediate steps to take following an attack, assist in securing accounts, and work with law enforcement and mobile carriers to prevent future incidents. Our goal is to help victims regain control and confidence in their digital security.
                            </p>
                            <h4>Preventive Measures</h4>
                            <p>
                                Prevention is key to combating SIM swapping. We advocate for stronger security measures within mobile carriers, such as enhanced verification processes and user awareness programs. Educating the public on safeguarding personal information and implementing robust two-factor authentication methods can significantly reduce the risk of SIM swapping attacks.
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
  name: 'CrimeInvestigationSIMSwapping',
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

