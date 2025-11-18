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
                                <li>Romance Scams</li>
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
                            <h2>Romance Scams</h2>
                        </div>
                        <div class="text mb-50">
                            <h3>The Heartbreaking Reality of Romance Scams</h3>
                            <p>
                                Romance scams represent a pervasive and heartbreaking form of deception which exploits the fundamental human need for connection and companionship, turning the search for love into a devastating financial and emotional trap. In recent years, the rise of cryptocurrencies has provided scammers with an additional avenue to exploit victims, offering a cloak of anonymity and facilitating financial transactions outside traditional banking channels. These scams often involve promises of love and companionship followed by requests for money or cryptocurrency, under false pretenses such as medical emergencies, travel expenses, or investment opportunities.
                            </p>
                            <h4>How Romance Scams Operate</h4>
                            <p>
                                Scammers typically create fake profiles on dating sites and social media platforms, presenting themselves as attractive and trustworthy individuals seeking a genuine relationship. They build emotional connections with their victims over time, gaining their trust and affection. Once the trust is established, scammers fabricate urgent situations that require financial assistance, such as medical emergencies or travel expenses. Victims, believing they are helping a loved one, transfer money or cryptocurrency, which is often untraceable and irretrievable once sent.
                            </p>
                            <h4>The Emotional and Financial Toll on Victims</h4>
                            <p>
                                The impact of romance scams on victims extends beyond financial loss. The emotional toll can be severe, as victims experience feelings of betrayal, humiliation, and heartbreak. Many victims are reluctant to come forward due to embarrassment, further complicating efforts to seek justice and recover lost assets. The combination of financial loss and emotional distress can have long-lasting effects on victims' well-being and trust in others.
                            </p>
                            <h4>{{ settings.company_name || 'Our Company' }}'s Approach to Combating Romance Scams</h4>
                            <p>
                                At {{ settings.company_name || 'our company' }}, we confront these heart-wrenching schemes head-on, leveraging our expertise in blockchain and cryptocurrency forensics to trace the flow of stolen assets and uncover the identities behind the anonymous screens. Our mission is to protect individuals from falling victim to these devastating scams and to hold accountable those responsible for preying on vulnerable victims. Through our expertise in blockchain and cryptocurrency forensics, we strive to raise awareness, provide support, and combat romance scams, contributing to a safer and more secure online environment for all.
                            </p>
                            <h4>Advanced Forensic Analysis</h4>
                            <p>
                                Our team uses advanced forensic analysis to track the movement of funds across blockchain networks. By analyzing transaction patterns and utilizing sophisticated tools, we can identify the origin and destination of funds, providing crucial evidence in the pursuit of justice. This process not only helps in identifying scammers but also plays a pivotal role in recovering assets and preventing future scams.
                            </p>
                            <h4>Raising Awareness and Providing Support</h4>
                            <p>
                                Raising awareness about the tactics used in romance scams is a critical component of our strategy. We aim to educate the public on recognizing warning signs and protecting themselves from potential scams. Additionally, we offer support to victims, guiding them through the recovery process and helping them navigate the emotional aftermath. By empowering individuals with knowledge and resources, we strive to reduce the incidence of romance scams and foster a more secure online environment.
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
  name: 'CrimeInvestigationRomanceScams',
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
