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
                                <li>Pig-Butchering Scams</li>
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
                            <h2>Pig-Butchering Scams</h2>
                        </div>
                        <div class="text mb-50">
                            <h3>Understanding Pig-Butchering Scams</h3>
                            <p>
                                Pig-butchering scams, a term that chillingly evokes the process of fattening a pig before slaughter, represent one of the most cunning and devastating forms of cryptocurrency fraud in today's digital landscape. Victims are slowly lured into a false sense of security by scammers who initially pose as helpful advisors or potential romantic interests, only to be methodically manipulated into investing significant sums into fraudulent cryptocurrency schemes. These scammers are adept at building trust and encouraging victims to pour more funds into the scam, only to disappear without a trace once a substantial amount is invested. At {{ settings.company_name || 'our company' }}, we're committed to combating these sophisticated scams and helping victims and law enforcement navigate the forensic and procedural challenges posed by these operations.
                            </p>
                            <h4>Deceptive Tactics Used by Scammers</h4>
                            <p>
                                The deceptive tactics employed in pig-butchering scams are multifaceted. Scammers often use social engineering techniques, leveraging social media platforms and dating sites to identify and approach potential victims. Once contact is established, the scammer gradually builds a relationship with the victim, fostering trust and creating an emotional bond. This process can take weeks or even months, during which the scammer provides investment advice or shares fabricated success stories to entice the victim into investing in what appears to be a lucrative cryptocurrency opportunity. As the victim's trust grows, they are encouraged to invest larger amounts, ultimately leading to significant financial loss when the scammer vanishes with the invested funds.
                            </p>
                            <h4>Emotional and Financial Impact on Victims</h4>
                            <p>
                                The impact of pig-butchering scams extends beyond financial loss. Victims often experience severe emotional distress, as they grapple with the betrayal of trust and the realization that they have been manipulated. The anonymity and irreversibility of cryptocurrency transactions make it exceptionally challenging to recover lost funds. However, at {{ settings.company_name || 'our company' }}, we employ advanced blockchain forensics to trace transactions and identify the perpetrators behind these scams. Our team collaborates closely with law enforcement agencies, providing crucial evidence and expert testimony to support investigations and prosecutions. By raising awareness and educating the public about these scams, we aim to prevent future victims from falling prey to such deceitful schemes.
                            </p>
                            <h4>Building Trust Through Social Engineering</h4>
                            <p>
                                Social engineering is a critical component of pig-butchering scams. Scammers use various methods to build trust, including posing as financial advisors or potential romantic partners. They carefully craft their online personas, often using stolen photos and fabricated personal stories to make their profiles appear genuine. This trust-building phase can involve frequent communication, sharing personal anecdotes, and giving the victim the impression of a deepening relationship. The goal is to make the victim feel comfortable and confident in the scammer's intentions, setting the stage for the eventual financial exploitation.
                            </p>
                            <h4>The Role of Advanced Blockchain Forensics</h4>
                            <p>
                                At {{ settings.company_name || 'our company' }}, our role in combating pig-butchering scams is pivotal. We utilize advanced blockchain forensic techniques to trace the flow of cryptocurrencies and uncover the identities of those behind these fraudulent schemes. Our experts meticulously analyze transaction histories, identify patterns, and follow the digital trail to piece together the scammers' operations. This forensic work is crucial in providing law enforcement with the evidence needed to pursue legal action against the perpetrators. Our commitment to transparency and accuracy ensures that victims have the best possible chance of recovering their lost funds.
                            </p>
                            <h4>Preventative Measures and Education</h4>
                            <p>
                                Prevention is a key aspect of combating pig-butchering scams. By educating the public about the warning signs and tactics used by scammers, we can help individuals protect themselves from becoming victims. Key preventative measures include being cautious about unsolicited investment advice, verifying the identity of online acquaintances, and being skeptical of opportunities that seem too good to be true. Public awareness campaigns and educational resources are essential tools in reducing the prevalence of these scams and safeguarding potential victims.
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
  name: 'CrimeInvestigationPigButchering',
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

