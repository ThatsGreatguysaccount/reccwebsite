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
                                <li>Wallet Compromise</li>
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
                            <h2>Wallet Compromise</h2>
                        </div>
                        <div class="text mb-50">
                            <h3>The Threat of Wallet Compromise</h3>
                            <p>
                                Cryptocurrency wallet compromises pose a significant threat in the digital asset landscape, jeopardizing the security and integrity of individuals' holdings. These compromises occur when unauthorized parties gain access to private keys or mnemonic phrases, enabling them to illicitly transfer funds from the compromised wallets. Such incidents can result from various factors, including phishing attacks, malware infections, vulnerabilities in wallet software, and even offline theft of credentials. Each type of compromise requires a unique approach both in terms of prevention and response. Our investigators at {{ settings.company_name || 'our company' }} are adept at navigating the aftermath of these breaches, offering comprehensive forensic analysis to trace unauthorized transactions and pinpoint the methods used by attackers.
                            </p>
                            <h4>Common Causes of Wallet Compromise</h4>
                            <p>
                                Wallet compromises can occur due to a variety of reasons. Phishing attacks, where attackers deceive individuals into providing their private keys or mnemonic phrases, are a common cause. Malware infections can also lead to wallet compromises, as malicious software can capture keystrokes or access stored credentials. Additionally, vulnerabilities in wallet software can be exploited by attackers to gain unauthorized access. Offline theft of credentials, such as physically stealing a hardware wallet or written mnemonic phrase, also poses a risk. Understanding these causes is crucial for developing effective prevention strategies and responding appropriately to compromises.
                            </p>
                            <h4>Preventative Measures for Wallet Security</h4>
                            <p>
                                To protect against wallet compromises, it is essential to implement robust security measures. Using hardware wallets, which store private keys offline, can significantly reduce the risk of online attacks. Regularly updating wallet software and using reputable wallet providers can help mitigate vulnerabilities. Employing multi-factor authentication and keeping mnemonic phrases secure and offline are also vital steps. Education and awareness about phishing attacks and malware are crucial in preventing individuals from falling victim to these threats. By adopting these preventative measures, individuals can safeguard their cryptocurrency holdings against potential compromises.
                            </p>
                            <h4>Forensic Analysis and Response</h4>
                            <p>
                                In the event of a wallet compromise, timely and thorough forensic analysis is essential. At {{ settings.company_name || 'our company' }}, our experts conduct detailed investigations to trace unauthorized transactions and identify the methods used by attackers. This involves analyzing blockchain transactions, examining malware, and investigating potential security breaches. By understanding the attack vectors and tracing the flow of stolen funds, we can provide valuable insights to victims and law enforcement. Our comprehensive forensic analysis helps in developing strategies to recover lost funds and prevent future compromises.
                            </p>
                            <h4>Collaboration with Law Enforcement</h4>
                            <p>
                                Collaboration with law enforcement agencies is a key component of our response to wallet compromises. By providing detailed forensic reports and expert testimony, we assist law enforcement in pursuing legal action against perpetrators. Our expertise in blockchain forensics enables us to uncover crucial evidence that can support investigations and prosecutions. Through close cooperation with law enforcement, we aim to hold attackers accountable and contribute to the broader effort of combating cryptocurrency-related crimes. Our commitment to transparency and accuracy ensures that our forensic findings are reliable and actionable.
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
  name: 'CrimeInvestigationWalletCompromise',
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

