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
                            <h2>Service Details</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Forensic Investigation</li>
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
                                <router-link to="/services/evidentiary-strategy">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-9.svg" alt="icon">
                                    </span>
                                    <span>Evidentiary Strategy</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/services/discovery-support">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-10.svg" alt="icon">
                                    </span>
                                    <span>Discovery Support</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/services/forensic-investigation">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-11.svg" alt="icon">
                                    </span>
                                    <span>Forensic Investigation</span>
                                    <span class="arrow-icon">
                                        <img src="/landing/img/icon/right-arrow-1.svg" alt="icon">
                                    </span>
                                </router-link>
                                <router-link to="/services/expert-testimony">
                                    <span class="icon">
                                        <img src="/landing/img/icon/icon-12.svg" alt="icon">
                                    </span>
                                    <span>Expert Testimony</span>
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
                            <h2>Forensic Investigation</h2>
                        </div>
                        <div class="text mb-50">
                            <h3>Unraveling Cryptocurrency Flows with Precision</h3>
                            <p>
                                Our forensic investigations delve deep into cryptocurrency transactions, utilizing a blend of publicly available and proprietary blockchain data. We specialize in conducting meticulous follow-the-money analyses to trace the origins, destinations, and pathways of cryptocurrency funds.
                            </p>
                            <h4>Expertise in Criminal and Civil Contexts</h4>
                            <p>
                                With extensive experience in both criminal and civil investigations, we possess the expertise to identify and interpret intricate patterns within the blockchain. Our approach integrates cutting-edge analysis and visualization tools, ensuring that our findings are meticulously documented and presented in a clear and accessible manner.
                            </p>
                            <h4>Comprehensive Analysis and Visualization</h4>
                            <p>
                                Leveraging a variety of advanced tools, we meticulously analyze blockchain data to uncover hidden connections and transactions. Our investigative process includes comprehensive visualization techniques that facilitate a deeper understanding of complex cryptocurrency flows.
                            </p>
                            <p>
                                Trust us to provide thorough forensic investigation services tailored to the unique challenges of cryptocurrency-related cases. Whether for criminal defense, civil litigation, or asset recovery, our experts are dedicated to delivering accurate insights and actionable intelligence that support your legal strategies effectively.
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
import Header from '../../components/layouts/Header.vue'
import Footer from '../../components/layouts/Footer.vue'
import OffCanvas from '../../components/layouts/OffCanvas.vue'

export default {
  name: 'ServicesForensicInvestigation',
  components: {
    Header,
    Footer,
    OffCanvas
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
