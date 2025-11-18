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
                            <h2>Our Team</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Our Team</li>
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

<!-- team-section start -->
<div class="team-section pt-150 pb-120 pt-lg-80 pb-lg-50 pt-md-80 pb-md-50 pt-xs-60 pb-xs-30">
    <div class="container">
        <div class="row justify-content-center mb-50">
            <div class="col-xxl-7 col-xl-8">
                <div class="section-heading-wrap text-center">
                    <div class="sub-title-2 mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <span>Meet Our Team</span>
                    </div>
                    <div class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <h2>
                            These dedicated professionals play a crucial role in recovering your funds.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="team-wrap mb-30">
                    <div class="thumb">
                        <img src="/landing/img/team/hans-(Compressify.io).png" alt="team">
                    </div>
                    <div class="content">
                        <div class="author">
                            <h4 class="designation">
                                Hans Peter Smith
                            </h4>
                            <p class="designation">Head of the Financial Department</p>
                        </div>
                        <div class="social-wrap">
                            <ul>
                                <li><a href="mailto:Hans.Peter.Smith@blockchain-guard.us"><i class="fa-regular fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="team-wrap mb-30">
                    <div class="thumb">
                        <img src="/landing/img/team/emily-(Compressify.io).png" alt="team">
                    </div>
                    <div class="content">
                        <div class="author">
                            <h4 class="designation">
                                Emily Ann Rich
                            </h4>
                            <p class="designation">Financial Department</p>
                        </div>
                        <div class="social-wrap">
                            <ul>
                                <li><a href="mailto:Emily.Ann.Rich@blockchain-guard.us"><i class="fa-regular fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="team-wrap mb-30">
                    <div class="thumb">
                        <img src="/landing/img/team/sean-(Compressify.io).png" alt="team">
                    </div>
                    <div class="content">
                        <div class="author">
                            <h4 class="designation">
                                Sean Kruger
                            </h4>
                            <p class="designation">Financial Department</p>
                        </div>
                        <div class="social-wrap">
                            <ul>
                                <li><a href="mailto:Sean.Kruger@blockchain-guard.us"><i class="fa-regular fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="team-wrap mb-30">
                    <div class="thumb">
                        <img src="/landing/img/team/michael-(Compressify.io).png" alt="team">
                    </div>
                    <div class="content">
                        <div class="author">
                            <h4 class="designation">
                               <span>Michael George Richard</span>
                            </h4>
                            <p class="designation">CEO</p>
                        </div>
                        <div class="social-wrap">
                            <ul>
                                <li><a href="mailto:Michael.George.Richard@blockchain-guard.us"><i class="fa-regular fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- team-section end -->
    
    <!--scrollToTopBtn end-->
    <a id="scrollToTopBtn" class="progress-wrap">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </a>
    
    <Footer />
  </div>
</template>

<script>
import Header from '../components/layouts/Header.vue'
import Footer from '../components/layouts/Footer.vue'
import OffCanvas from '../components/layouts/OffCanvas.vue'

export default {
  name: 'Team',
  components: {
    Header,
    Footer,
    OffCanvas
  },
  data() {
    return {
      sidebarOpen: false
    }
  },
  mounted() {
    if (window.AOS) {
      window.AOS.init();
    }
  }
}
</script>

<style scoped>
/* Styles are loaded globally from /landing/css/main.css */
.breadcrumb-area {
  min-height: 50% !important;
  padding-top: 75px !important;
  padding-bottom: 75px !important;
}
</style>
