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
                            <h2>Faq</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Faq</li>
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

    <!-- blog-section start -->
    <div class="blog-section pt-150 pb-120 pt-lg-80 pb-lg-50 pt-md-80 pb-md-50 pt-xs-60 pb-xs-30">
        <div class="container">
            <div class="row justify-content-center mb-50">
                <div class="col-xxl-7 col-xl-8">
                    <div class="section-heading-wrap text-center">
                        <div class="sub-title-2 mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                            <span>Faq</span>
                        </div>
                        <div class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                            <h2>
                                Frequently Ask Questions
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-xl-6 mb-lg-50 mb-md-50 mb-xs-50" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="600">
                    <div class="faq-form-wrap">
                        <div class="faq-form">
                            <form @submit.prevent="handleFaqSubmit">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="input-wrap">
                                            <label for="fname">First Name</label>
                                            <input type="text" placeholder="First Name" id="fname" v-model="faqForm.firstName">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="input-wrap">
                                            <label for="lname">Last Time</label>
                                            <input type="text" placeholder="Last Name" id="lname" v-model="faqForm.lastName">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="input-wrap">
                                            <label for="email">Email</label>
                                            <input type="email" placeholder="Email" id="email" v-model="faqForm.email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="input-wrap">
                                            <label for="question">Question</label>
                                            <textarea placeholder="Write Your Questions" id="question" v-model="faqForm.question"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="input-button">
                                            <input type="submit" value="Submit Now">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="shape-1">
                            <img src="/landing/img/shape/shape-23.svg" alt="shape">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                    <div class="faq-accordion-1">
                        <div class="accordion" id="faq-accordion-1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq-h-1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-coll-1" aria-expanded="true" aria-controls="faq-coll-1">
                                        1. What does business consulting do?
                                    </button>
                                </h2>
                                <div id="faq-coll-1" class="accordion-collapse collapse show" aria-labelledby="faq-h-1"
                                    data-bs-parent="#faq-accordion-1">
                                    <div class="accordion-body">
                                        <p>
                                            Interactively provide access to world-class materials for unique is
                                            catalysts for
                                            change progressively change my ocardinations is th li go.Interactively
                                            provide
                                            access to world.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq-h-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-coll-2" aria-expanded="false" aria-controls="faq-coll-2">
                                        2. Is a business consultant a good job?
                                    </button>
                                </h2>
                                <div id="faq-coll-2" class="accordion-collapse collapse" aria-labelledby="faq-h-2"
                                    data-bs-parent="#faq-accordion-1">
                                    <div class="accordion-body">
                                        <p>
                                            Interactively provide access to world-class materials for unique is
                                            catalysts for
                                            change progressively change my ocardinations is th li go.Interactively
                                            provide
                                            access to world.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq-h-3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-coll-3" aria-expanded="false" aria-controls="faq-coll-3">
                                        3. Is business consulting a skill?
                                    </button>
                                </h2>
                                <div id="faq-coll-3" class="accordion-collapse collapse" aria-labelledby="faq-h-3"
                                    data-bs-parent="#faq-accordion-1">
                                    <div class="accordion-body">
                                        <p>
                                            Interactively provide access to world-class materials for unique is
                                            catalysts for
                                            change progressively change my ocardinations is th li go.Interactively
                                            provide
                                            access to world.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq-h-4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-coll-4" aria-expanded="false" aria-controls="faq-coll-4">
                                        4. Who needs business consultant?
                                    </button>
                                </h2>
                                <div id="faq-coll-4" class="accordion-collapse collapse" aria-labelledby="faq-h-4"
                                    data-bs-parent="#faq-accordion-1">
                                    <div class="accordion-body">
                                        <p>
                                            Interactively provide access to world-class materials for unique is
                                            catalysts for
                                            change progressively change my ocardinations is th li go.Interactively
                                            provide
                                            access to world.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq-h-5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-coll-5" aria-expanded="false" aria-controls="faq-coll-5">
                                        5. What kind of job is consulting?
                                    </button>
                                </h2>
                                <div id="faq-coll-5" class="accordion-collapse collapse" aria-labelledby="faq-h-5"
                                    data-bs-parent="#faq-accordion-1">
                                    <div class="accordion-body">
                                        <p>
                                            Interactively provide access to world-class materials for unique is
                                            catalysts for
                                            change progressively change my ocardinations is th li go.Interactively
                                            provide
                                            access to world.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog-section end -->

    <Footer />
  </div>
</template>

<script>
import Header from '../components/layouts/Header.vue'
import Footer from '../components/layouts/Footer.vue'
import OffCanvas from '../components/layouts/OffCanvas.vue'

export default {
  name: 'Faq',
  components: {
    Header,
    Footer,
    OffCanvas
  },
  data() {
    return {
      sidebarOpen: false,
      faqForm: {
        firstName: '',
        lastName: '',
        email: '',
        question: ''
      }
    }
  },
  methods: {
    handleFaqSubmit() {
      // Handle form submission
      console.log('FAQ form submitted:', this.faqForm)
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
</style>
