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
                            <h2>Practice Areas</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Consumer Protection
                                </li>
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

    <div class="container">
        <div class="row">
            <div class="col-xl-4 order-2 order-xl-1" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="service-sidebar">
                    <div class="sidebar-widget mb-50">
                        <div class="service-category">
                            <router-link to="/practice-areas/divorce">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-9.svg" alt="icon">
                                </span>
                                <span>Divorce</span>
                                <span class="arrow-icon">
                                    <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                </span>
                            </router-link>
                            <router-link to="/practice-areas/business-disputes">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-10.svg" alt="icon">
                                </span>
                                <span>Business Disputes</span>
                                <span class="arrow-icon">
                                    <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                </span>
                            </router-link>
                            <router-link to="/practice-areas/criminal-defense">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-11.svg" alt="icon">
                                </span>
                                <span>Criminal Defense</span>
                                <span class="arrow-icon">
                                    <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                </span>
                            </router-link>
                            <router-link to="/practice-areas/civil-prosecution">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-12.svg" alt="icon">
                                </span>
                                <span>Civil Prosecution
                                </span>
                                <span class="arrow-icon">
                                    <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                </span>
                            </router-link>
                            <router-link to="/practice-areas/consumer-protection">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-13.svg" alt="icon">
                                </span>
                                <span>Consumer Protection
                                </span>
                                <span class="arrow-icon">
                                    <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                </span>
                            </router-link>
                            <router-link to="/practice-areas/bankruptcy">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-13.svg" alt="icon">
                                </span>
                                <span>Bankruptcy</span>
                                <span class="arrow-icon">
                                    <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                </span>
                            </router-link>
                            <router-link to="/practice-areas/estate-administration">
                                <span class="icon">
                                    <img src="/landing/img/icon/icon-13.svg" alt="icon">
                                </span>
                                <span>Estate Administration</span>
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
                        <h2>Consumer Protection</h2>
                    </div>
                    <div class="text mb-50">
                        <h3>Addressing Claims of Negligence and Facilitation of Cybercrimes</h3>
                        <p>
                            Cryptocurrency-related cybercrime frequently gives rise to consumer protection claims against third parties such as cryptocurrency exchanges and telecommunications companies. Victims allege negligence on the part of these third parties, asserting that their actions or lack thereof facilitated cybercrimes, ultimately resulting in significant financial losses. On the other hand, cryptocurrency exchanges, wallet providers, and telecommunications companies often find themselves defending against these allegations by demonstrating that they took all proper precautions and that no action they could reasonably have been expected to take would have prevented the incident.
                        </p>
                        <p>
                            These claims can be complex and multifaceted, involving issues of cybersecurity, regulatory compliance, and the evolving landscape of digital assets. Plaintiffs seek recourse, arguing that negligence, inadequate security measures, or breaches of fiduciary duty on the part of service providers contributed directly to their financial harm. Conversely, defendants argue that they implemented industry-standard security protocols, adhered to regulatory requirements, and took swift corrective action upon discovering any potential vulnerabilities or threats.
                        </p>
                        <p>
                            Our experts at {{ settings.company_name || 'our company' }} have extensive experience in evaluating and analyzing the intricate dynamics of consumer protection claims in the realm of cryptocurrency-related cybercrimes. They provide thorough and unbiased assessments of the events leading to alleged financial losses, meticulously examining the actions and responsibilities of all involved parties. Through detailed forensic analysis and expert testimony, our team offers clarity and insight into the technical and legal complexities of these cases, helping to establish a comprehensive understanding of the facts and circumstances surrounding each incident.
                        </p>
                        <h4>Expert Analysis and Reconstruction</h4>
                        <p>
                            Central to our approach is the independent reconstruction of events and analysis of the causal chain underlying consumer protection claims. Our experts meticulously trace the flow of cryptocurrency transactions, identify relevant wallet addresses, and assess the security measures implemented by service providers. This process enables us to discern whether alleged negligence or inadequate security practices directly facilitated cybercrimes, contributing to financial losses experienced by victims.
                        </p>
                        <p>
                            By conducting in-depth forensic examinations of digital evidence and blockchain transactions, we uncover critical insights into the sequence of events leading up to a cyber incident. This forensic approach not only aids in understanding the technical intricacies of blockchain technology but also facilitates the identification of potential vulnerabilities or breaches that may have been exploited by malicious actors.
                        </p>
                        <h4>Supporting Fair Resolutions</h4>
                        <p>
                            Our mission is to support fair and just resolutions in consumer protection claims related to cryptocurrency cybercrimes. We strive to provide comprehensive and objective analysis that assists legal professionals and adjudicators in reaching informed decisions. Through our expertise in blockchain forensics and cybersecurity, we aim to enhance transparency, accountability, and trust within the digital asset ecosystem, ensuring that all parties involved are appropriately represented and that justice is served.
                        </p>
                        <p>
                            Whether advocating for plaintiffs seeking restitution for financial losses or defending the interests of service providers facing allegations of negligence, our team remains committed to delivering thorough and reliable expert testimony. We collaborate closely with legal counsel to develop robust litigation strategies that leverage our technical expertise and forensic findings effectively. By offering nuanced insights into the complexities of cryptocurrency-related cybercrimes, we contribute to the advancement of legal precedent and regulatory frameworks governing digital assets.
                        </p>
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
  name: 'PracticeAreasConsumerProtection',
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
      // Handle contact form submission
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
