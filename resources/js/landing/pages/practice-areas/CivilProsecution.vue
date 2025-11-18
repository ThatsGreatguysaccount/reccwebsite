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
                                <li>     Civil Prosecution
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
                        <h2>Civil Prosecution</h2>
                    </div>
                    <div class="text mb-50">
                        <h3>Assisting Victims of Cryptocurrency-Related Cybercrime</h3>
                        <p>
                            Blockchain-forensic experts are indispensable in assisting victims of cryptocurrency-related cybercrime and their lawyers when pursuing civil procedures, like civil prosecution for fraud, to recover stolen assets. Our experts, deeply familiar with the cryptocurrency ecosystem, can meticulously trace the flow of cryptocurrency funds through the blockchain, identifying wallets and addresses associated with the cybercriminals and the destination of the stolen funds.
                        </p>
                        <h4>Tracing Stolen Funds</h4>
                        <p>
                            Our forensic experts can trace the flow of cryptocurrency funds, identifying wallets and addresses associated with cybercriminals and the destinations of the stolen funds. This detailed tracing is crucial in building a solid case for civil prosecution.
                        </p>
                        <h4>Seizing and Freezing Illicitly Obtained Cryptocurrencies</h4>
                        <p>
                            They can also liaise with cryptocurrency exchanges and provide insights on how to seize and freeze illicitly obtained cryptocurrencies, as well as offer hands-on assistance with the process. This cooperation with exchanges is vital for stopping the further dispersal of stolen assets.
                        </p>
                        <h4>Building a Compelling Legal Argument</h4>
                        <p>
                            Moreover, their insights can help legal counsel navigate complex legal frameworks and build a compelling argument to demonstrate the extent of the financial losses incurred. By providing clear evidence and expert testimony, they support the legal process effectively.
                        </p>
                        <h4>Increasing Chances of a Successful Outcome</h4>
                        <p>
                            Through their expertise, blockchain-forensic experts play a pivotal role in increasing the chances of a successful outcome, ensuring that victims have a fighting chance to recover at least a portion of their stolen assets. They help victims seek justice and restitution in the face of cryptocurrency-related cybercrime.
                        </p>
                        <h4>Ensuring Justice and Restitution</h4>
                        <p>
                            Our ultimate goal is to ensure that victims of cryptocurrency-related cybercrime can achieve justice and restitution. By meticulously tracing stolen assets and providing expert support throughout the legal process, we strive to help victims reclaim what is rightfully theirs.
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
import Header from '../../components/layouts/Header.vue'
import Footer from '../../components/layouts/Footer.vue'
import OffCanvas from '../../components/layouts/OffCanvas.vue'

export default {
  name: 'PracticeAreasCivilProsecution',
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

