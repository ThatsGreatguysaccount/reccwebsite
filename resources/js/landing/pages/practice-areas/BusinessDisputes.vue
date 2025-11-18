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
                                <li>Business Disputes
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
                        <h2>Business Disputes</h2>
                    </div>
                    <div class="text mb-50">
                        <h3>Understanding Business Disputes in the Blockchain Era</h3>
                        <p>
                            In the realm of business disputes, especially those involving partnerships, contracts, or financial transactions, cryptocurrencies and blockchain technology introduce a layer of complexity that traditional forensic analysis might not adequately address. The immutable and transparent nature of blockchain can serve as a double-edged sword—offering a clear record of transactions that, on one hand, can prove invaluable in disputes over financial transactions, asset transfers, or breaches of contract, but on the other, may require specialized skills to interpret accurately. A blockchain-forensic expert becomes indispensable in such scenarios.
                        </p>
                        <h4>The Role of Blockchain in Business Disputes</h4>
                        <p>
                            Blockchain technology, with its transparent and immutable ledger, provides a detailed record of every transaction. This can be crucial in business disputes, offering clear evidence of financial transactions, asset transfers, or breaches of contract. However, interpreting this data requires specialized expertise to ensure its accuracy and relevance to the dispute at hand.
                        </p>
                        <h4>Our Forensic Analysis Approach</h4>
                        <p>
                            By meticulously analyzing transaction histories, wallet addresses, and smart contracts, our experts can unearth evidence of fraudulent transactions, unauthorized asset transfers, misappropriation of funds, or other misrepresentations. This thorough approach ensures that all relevant data is considered, providing a comprehensive view of the dispute.
                        </p>
                        <h4>Specialized Skill Set</h4>
                        <p>
                            The unique skill set of our blockchain forensic experts not only helps in pinpointing the exact nature of the dispute but also in crafting a litigation strategy that leverages the transparency of blockchain to support or refute claims. Our experts have the technical knowledge and experience to interpret complex blockchain data accurately, ensuring that the evidence presented is robust and reliable.
                        </p>
                        <h4>Litigation Strategy</h4>
                        <p>
                            Our expertise extends beyond mere analysis; we assist in developing effective litigation strategies. By leveraging blockchain's transparency, we can support or refute claims with precise evidence, ensuring that the case is presented in the strongest possible light. This strategic approach enhances the chances of a favorable outcome in legal proceedings.
                        </p>
                        <h4>Supporting Legal Teams</h4>
                        <p>
                            We work closely with legal teams to provide expert testimony and support throughout the litigation process. Our in-depth knowledge of blockchain technology and forensic analysis ensures that all aspects of the case are thoroughly understood and accurately represented in court.
                        </p>
                        <h4>Ensuring Fair Resolutions</h4>
                        <p>
                            Our ultimate goal is to ensure fair resolutions in business disputes involving blockchain technology. By providing clear, accurate, and reliable evidence, we help to resolve conflicts and support the enforcement of contracts and agreements. This contributes to maintaining trust and integrity within the business community.
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
  name: 'PracticeAreasBusinessDisputes',
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

