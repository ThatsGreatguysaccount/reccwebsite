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
                            <h2>Contact</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Contact</li>
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

    <!-- contact-section start -->
    <div class="contact-section pt-150 pb-120 pt-lg-80 pb-lg-50 pt-md-80 pb-md-50 pt-xs-60 pb-xs-30">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="col-xl-6 col-lg-6">
                    <div class="contact-form">
                        <form action="#">
                            <div class="title">
                                <h3>Send us Message</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="input-wrap">
                                        <label for="fname">First Name</label>
                                        <input type="text" placeholder="First Name" id="fname">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-wrap">
                                        <label for="lname">Last Name</label>
                                        <input type="text" placeholder="Last Name" id="lname">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-wrap">
                                        <label for="email">Email</label>
                                        <input type="email" placeholder="Email" id="email">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-wrap">
                                        <label for="phone">Phone No</label>
                                        <input type="text" placeholder="Phone No" id="phone">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-wrap">
                                        <label for="country">Country</label>
                                        <input type="text" placeholder="Country Name" id="country">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-wrap">
                                        <label for="birthdate">Birthdate</label>
                                        <input type="text" placeholder="DD/MM/YYYY" id="birthdate">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="input-wrap">
                                        <label for="Case">Case</label>
                                        <textarea placeholder="Write details about your case" id="case"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="input-submit">
                                        <input type="submit" value="Send Request">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-map" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.25422179926!2d-74.14482761874562!3d40.697630744097786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1699931839741!5m2!1sen!2sbd"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <!-- contact-section end -->

    <!-- contact-info-section start -->
    <div class="contact-info-section bg-off-white-3 pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-30" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="contact-info">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.02779 5.22654C4.0312 5.22654 3.94584 5.31532 3.83828 5.42117C3.42511 5.82238 2.56976 6.65725 2.56114 8.40381C2.54757 10.8469 4.15413 15.3832 11.8899 23.1172C19.5898 30.8137 24.1192 32.4391 26.5675 32.4391H26.6033C28.3499 32.4305 29.183 31.5735 29.5859 31.162C29.7089 31.0357 29.8079 30.9435 29.8779 30.8854C31.5784 29.1747 32.4491 27.9011 32.4406 27.085C32.4286 26.2518 31.3923 25.2667 29.9598 23.9043C29.504 23.4707 29.0089 22.9994 28.4865 22.477C27.1326 21.1265 26.4616 21.357 24.9865 21.876C22.9463 22.5914 20.1463 23.5646 15.7962 19.2127C11.4391 14.8591 12.414 12.0625 13.1277 10.0223C13.6433 8.54722 13.8789 7.87455 12.5233 6.51896C11.9923 5.9897 11.516 5.48775 11.0772 5.02678C9.72331 3.6029 8.74674 2.57341 7.91871 2.56145H7.90505C7.08725 2.56145 5.81703 3.43559 4.01925 5.23337C4.02437 5.22824 4.02608 5.22654 4.02779 5.22654ZM26.5692 35C22.3146 35 16.7676 31.6127 10.0801 24.9287C3.36707 18.2173 -0.0253232 12.6533 0.000142307 8.39015C0.0156518 5.57312 1.49246 4.13046 2.04733 3.58924C2.07635 3.55339 2.17538 3.45608 2.20952 3.42193C4.65778 0.971966 6.30873 -0.0182638 7.95114 0.000254621C9.85819 0.0261258 11.2155 1.45342 12.933 3.26144C13.3581 3.70875 13.8191 4.19533 14.333 4.70752C16.8256 7.20017 16.1154 9.23355 15.5452 10.8657C14.9237 12.6464 14.3859 14.183 17.6059 17.4029C20.8292 20.6229 22.3658 20.0851 24.1397 19.4585C25.7736 18.8883 27.8018 18.1746 30.2979 20.6673C30.8032 21.1726 31.283 21.6285 31.7252 22.0502C33.5417 23.7763 34.9759 25.1404 35.0001 27.0526C35.0203 28.683 34.03 30.3442 31.5852 32.7908L30.5028 32.0566L31.4179 32.9512C30.8767 33.5061 29.4357 34.9846 26.617 35H26.5692Z"
                                    fill="#2563eb"></path>
                            </svg>
                        </div>
                        <div class="content">
                            <p><a :href="`tel:${settings.company_number || settings.company_phone}`">{{ settings.company_number || settings.company_phone || 'N/A' }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-30" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="contact-info">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="35" viewBox="0 0 30 35"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.8077 0C22.9726 0 29.6154 6.69308 29.6154 14.9208C29.6154 25.0349 18.0277 35 14.8077 35C11.5877 35 0 25.0349 0 14.9208C0 6.69308 6.64282 0 14.8077 0ZM14.8077 2.69231C8.12718 2.69231 2.69231 8.17923 2.69231 14.9208C2.69231 23.4985 12.7867 31.8554 14.8077 32.3005C16.8287 31.8536 26.9231 23.4967 26.9231 14.9208C26.9231 8.17923 21.4882 2.69231 14.8077 2.69231ZM14.8095 8.97436C18.0259 8.97436 20.6428 11.5913 20.6428 14.8095C20.6428 18.0259 18.0259 20.641 14.8095 20.641C11.5931 20.641 8.97615 18.0259 8.97615 14.8095C8.97615 11.5913 11.5931 8.97436 14.8095 8.97436ZM14.8095 11.6667C13.0774 11.6667 11.6685 13.0756 11.6685 14.8095C11.6685 16.5415 13.0774 17.9487 14.8095 17.9487C16.5415 17.9487 17.9505 16.5415 17.9505 14.8095C17.9505 13.0756 16.5415 11.6667 14.8095 11.6667Z"
                                    fill="#2563eb"></path>
                            </svg>
                        </div>
                        <div class="content">
                            <p>
                                {{ settings.company_address || 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-30" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                    <div class="contact-info">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="39" height="35" viewBox="0 0 39 35"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M28.1059 0C34.0828 0 38.5897 4.87667 38.5897 11.3436V23.6708C38.5897 26.9805 37.4195 29.9708 35.2926 32.0923C33.3846 33.9931 30.9095 35 28.1346 35H10.4497C7.68026 35 5.20692 33.9949 3.29718 32.0923C1.17026 29.9708 0 26.9805 0 23.6708V11.3436C0 4.87667 4.50692 0 10.4838 0H28.1059ZM28.1059 2.69231H10.4838C5.96974 2.69231 2.69231 6.33051 2.69231 11.3436V23.6708C2.69231 26.2608 3.58256 28.5744 5.19795 30.1844C6.59077 31.5754 8.40897 32.3077 10.4551 32.3077H28.1059C28.1095 32.3041 28.1238 32.3077 28.1346 32.3077C30.1826 32.3077 31.999 31.5754 33.3918 30.1844C35.009 28.5744 35.8974 26.2608 35.8974 23.6708V11.3436C35.8974 6.33051 32.62 2.69231 28.1059 2.69231ZM30.9346 11.0004C31.4031 11.5766 31.3151 12.4237 30.739 12.894L22.7626 19.3771C21.7538 20.1776 20.5477 20.5778 19.3433 20.5778C18.1426 20.5778 16.9454 20.1812 15.9438 19.3878L7.89385 12.8976C7.3141 12.4309 7.22436 11.5819 7.68923 11.004C8.15769 10.4278 9.00487 10.3363 9.58282 10.8012L17.6256 17.2843C18.6362 18.0848 20.0595 18.0848 21.0772 17.2771L29.0392 10.8048C29.6172 10.3327 30.4644 10.4225 30.9346 11.0004Z"
                                    fill="#2563eb"></path>
                            </svg>
                        </div>
                        <div class="content">
                            <p><a :href="`mailto:${settings.company_email}`">{{ settings.company_email || 'N/A' }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-30" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                    <div class="contact-info" v-if="settings.company_email">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M37.2272 25.7864C37.95 25.8407 38.4907 26.4724 38.4365 27.1952L38.104 31.5859C37.8292 35.2084 34.772 38.0452 31.1407 38.0452H10.8407C7.20948 38.0452 4.15222 35.2084 3.87747 31.5859L3.54497 27.1952C3.49073 26.4724 4.03322 25.8407 4.75597 25.7864C5.48222 25.7602 6.10872 26.2729 6.16472 26.9974L6.49547 31.3864C6.66697 33.6474 8.57448 35.4202 10.8407 35.4202H31.1407C33.407 35.4202 35.3162 33.6474 35.486 31.3864L35.8185 26.9974C35.8745 26.2729 36.5167 25.7584 37.2272 25.7864ZM23.2486 3.5C25.8787 3.5 28.0577 5.47096 28.3859 8.0133L31.8325 8.01483C35.5005 8.01483 38.4825 11.0056 38.4825 14.6841V20.7023C38.4825 21.1696 38.234 21.6001 37.8332 21.8346C33.5137 24.3642 28.0418 25.8397 22.3029 26.0365L22.3036 29.1841C22.3036 29.9086 21.7156 30.4966 20.9911 30.4966C20.2666 30.4966 19.6786 29.9086 19.6786 29.1841L19.6774 26.0369C13.9443 25.8419 8.47202 24.3661 4.14925 21.8346C3.74675 21.6001 3.5 21.1696 3.5 20.7023V14.6666C3.5 10.9986 6.49075 8.01483 10.1675 8.01483L13.5963 8.0133C13.9245 5.47096 16.1034 3.5 18.7336 3.5H23.2486ZM31.8325 10.6398H10.1675C7.938 10.6398 6.125 12.4458 6.125 14.6666V19.9376C10.279 22.1947 15.5159 23.4317 20.9667 23.4341L20.9911 23.4318L21.0105 23.4325L21.8438 23.4238C26.9989 23.301 31.9167 22.0779 35.8575 19.9376V14.6841C35.8575 12.4528 34.0532 10.6398 31.8325 10.6398ZM23.2486 6.125H18.7336C17.5552 6.125 16.5605 6.92698 16.2667 8.01374H25.7155C25.4216 6.92698 24.4269 6.125 23.2486 6.125Z"
                                    fill="#2563eb"></path>
                            </svg>
                        </div>
                        <div class="content">
                            <p><a :href="`mailto:${settings.company_email}`">{{ settings.company_email }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact-section end -->
    
    <!--scrollToTopBtn end-->
    <a id="scrollToTopBtn" class="progress-wrap">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </a>
    
    <Footer />
  </div>
</template>

<script>
import { onMounted } from 'vue'
import Header from '../components/layouts/Header.vue'
import Footer from '../components/layouts/Footer.vue'
import OffCanvas from '../components/layouts/OffCanvas.vue'
import { useSettings } from '../composables/useSettings'

export default {
  name: 'Contact',
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
      sidebarOpen: false
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
