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
                                <li>Divorce</li>
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
                        <h2>Divorce and Cryptocurrencies</h2>
                    </div>
                    <div class="text mb-50">
                        <h3>The Role of Cryptocurrencies in Divorce</h3>
                        <p>
                            Cryptocurrencies can play a significant role in divorce proceedings, often becoming a
                            contentious issue between spouses. With their decentralization and perceived anonymity, they
                            are attractive for individuals seeking to hide or move assets during divorce proceedings.
                            The complexity and evolving nature of cryptocurrencies make them a challenging asset to
                            manage in the context of a divorce, as they are not as straightforward as traditional
                            financial assets like bank accounts or property. This often leads to disputes and
                            complications when attempting to achieve a fair division of marital assets.
                        </p>
                        <h3>Our Expertise in Blockchain Forensics</h3>
                        <p>
                            Our blockchain forensic experts have played a crucial role in assisting parties and their
                            counsel in such cases by tracing and documenting cryptocurrency transactions, uncovering
                            undisclosed cryptocurrency in hidden wallets and exchange accounts, and assessing the value
                            of these assets accurately. They utilize advanced techniques and tools to track the movement
                            of cryptocurrencies across the blockchain, which is essential in providing a thorough
                            understanding of an individual's cryptocurrency holdings. By meticulously analyzing
                            transaction histories and wallet activities, our experts can identify patterns and anomalies
                            that may indicate attempts to conceal assets.
                        </p>
                        <h3>Comprehensive Valuation Services</h3>
                        <p>
                            In addition to uncovering hidden cryptocurrencies, our experts also provide comprehensive
                            valuation services. The volatile nature of cryptocurrency markets means that the value of
                            these assets can fluctuate significantly over short periods. Therefore, it is critical to
                            have an accurate and current assessment of their value at the time of the divorce
                            proceedings. Our experts are well-versed in the nuances of cryptocurrency valuation,
                            considering factors such as market trends, historical prices, and the liquidity of the
                            specific assets in question. This ensures that the division of assets is based on a fair and
                            equitable valuation of all holdings.
                        </p>
                        <h3>Expert Testimony in Court</h3>
                        <p>
                            Furthermore, our expertise extends to providing expert testimony in court. We can present
                            clear and compelling evidence to establish the true extent of a spouse's cryptocurrency
                            holdings, helping to ensure a fair and equitable distribution of assets during divorce
                            proceedings. Our testimony can be pivotal in cases where one party has gone to great lengths
                            to obscure their cryptocurrency activities. By presenting detailed reports and analyses, our
                            experts can effectively communicate complex technical information in a way that is
                            understandable to the court, thereby supporting the case for a just division of assets.
                        </p>
                        <h3>Why Choose Our Company</h3>
                        <p>
                            Our involvement in these cases not only aids in the discovery and valuation of
                            cryptocurrencies but also provides a level of transparency and accountability that is
                            essential in contentious divorce proceedings. By leveraging our blockchain forensic
                            expertise, parties can be assured that all cryptocurrency assets are accounted for and
                            valued appropriately, thereby supporting a fair resolution to the divorce. Whether through
                            investigative work, valuation assessments, or court testimony, our comprehensive services
                            play a vital role in navigating the challenges associated with cryptocurrencies in divorce
                            proceedings.
                        </p>
                        <p>
                            At our company, we pride ourselves on our commitment to excellence and our ability to handle
                            the complexities of cryptocurrency in divorce cases. Our team of experts is dedicated to
                            providing accurate, reliable, and transparent services that ensure a fair distribution of
                            assets. With years of experience and a deep understanding of blockchain technology, we are
                            the trusted choice for individuals and legal professionals seeking expert assistance in
                            cryptocurrency-related divorce proceedings.
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
  name: 'PracticeAreasDivorce',
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
