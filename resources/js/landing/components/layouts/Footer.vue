<template>
  <footer class="footer-section-2">
    <div class="footer-top-2 pt-md-30 pb-md-30 pt-xs-30 pb-xs-30">
      <div class="container footer-newsletter-shape-wrap">
        <div class="row align-items-center">
          <div class="col-xl-12">
            <div class="footer-contact-info-2">
              <div v-if="settings.company_address" class="f-info-item">
                <div class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M20.416 3.33301C27.9977 3.33301 34.166 9.54801 34.166 17.188C34.166 26.5797 23.406 35.833 20.416 35.833C17.426 35.833 6.66602 26.5797 6.66602 17.188C6.66602 9.54801 12.8343 3.33301 20.416 3.33301ZM20.416 5.83301C14.2127 5.83301 9.16602 10.928 9.16602 17.188C9.16602 25.153 18.5393 32.913 20.416 33.3263C22.2927 32.9113 31.666 25.1513 31.666 17.188C31.666 10.928 26.6193 5.83301 20.416 5.83301ZM20.4177 11.6663C23.4043 11.6663 25.8343 14.0963 25.8343 17.0847C25.8343 20.0713 23.4043 22.4997 20.4177 22.4997C17.431 22.4997 15.001 20.0713 15.001 17.0847C15.001 14.0963 17.431 11.6663 20.4177 11.6663ZM20.4177 14.1663C18.8093 14.1663 17.501 15.4747 17.501 17.0847C17.501 18.693 18.8093 19.9997 20.4177 19.9997C22.026 19.9997 23.3343 18.693 23.3343 17.0847C23.3343 15.4747 22.026 14.1663 20.4177 14.1663Z"
                      fill="#E8112B" />
                  </svg>
                </div>
                <div class="content">
                  <span>Location</span>
                  <p>{{ settings.company_address }}</p>
                </div>
              </div>
              <div v-if="settings.company_email" class="f-info-item">
                <div class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M27.7643 3.33301C33.3143 3.33301 37.4993 7.86134 37.4993 13.8663V25.313C37.4993 28.3863 36.4127 31.163 34.4377 33.133C32.666 34.898 30.3677 35.833 27.791 35.833H11.3693C8.79768 35.833 6.50102 34.8997 4.72768 33.133C2.75268 31.163 1.66602 28.3863 1.66602 25.313V13.8663C1.66602 7.86134 5.85102 3.33301 11.401 3.33301H27.7643ZM27.7643 5.83301H11.401C7.20935 5.83301 4.16602 9.21134 4.16602 13.8663V25.313C4.16602 27.718 4.99268 29.8663 6.49268 31.3613C7.78602 32.653 9.47435 33.333 11.3743 33.333H27.7643C27.7677 33.3297 27.781 33.333 27.791 33.333C29.6927 33.333 31.3793 32.653 32.6727 31.3613C34.1743 29.8663 34.9993 27.718 34.9993 25.313V13.8663C34.9993 9.21134 31.956 5.83301 27.7643 5.83301ZM30.391 13.5477C30.826 14.0827 30.7443 14.8693 30.2093 15.306L22.8027 21.326C21.866 22.0693 20.746 22.441 19.6277 22.441C18.5127 22.441 17.401 22.0727 16.471 21.336L8.99602 15.3093C8.45768 14.876 8.37435 14.0877 8.80602 13.551C9.24102 13.016 10.0277 12.931 10.5643 13.3627L18.0327 19.3827C18.971 20.126 20.2927 20.126 21.2377 19.376L28.631 13.366C29.1677 12.9277 29.9543 13.011 30.391 13.5477Z"
                      fill="white" />
                  </svg>
                </div>
                <div class="content">
                  <span>Email</span>
                  <p><a :href="`mailto:${settings.company_email}`">{{ settings.company_email }}</a></p>
                </div>
              </div>
              <div v-if="settings.company_number || settings.company_phone" class="f-info-item">
                <div class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M11.0959 3.33391C12.9576 3.35891 14.2843 4.75391 15.9626 6.51891C16.3776 6.95391 16.8259 7.42891 17.3276 7.92891C19.7593 10.3622 19.0676 12.3472 18.5093 13.9406C17.9026 15.6789 17.3776 17.1789 20.5209 20.3222C23.6643 23.4656 25.1626 22.9406 26.8993 22.3289C28.4943 21.7722 30.4743 21.0756 32.9109 23.5089C33.4059 24.0039 33.8726 24.4472 34.3059 24.8589C36.0776 26.5456 37.4776 27.8772 37.5012 29.7439C37.5193 31.3339 36.5526 32.9572 34.1659 35.3439L33.1093 34.6272L34.0043 35.4989C33.4759 36.0406 32.0709 37.4839 29.3193 37.5006H29.2693C25.1159 37.5006 19.7009 34.1939 13.1743 27.6689C6.62093 21.1172 3.30926 15.6856 3.33412 11.5239C3.34926 8.77391 4.79093 7.36557 5.3326 6.83724L5.37883 6.78675L5.49093 6.67391C7.8826 4.28224 9.52593 3.29891 11.0959 3.33391ZM11.0643 5.83391H11.0509C10.3025 5.83391 9.16587 6.58391 7.58064 8.12373L7.26232 8.43634L7.26593 8.43557C7.26793 8.43557 7.23873 8.46677 7.19237 8.51405L7.08093 8.62557C6.6776 9.01724 5.8426 9.83224 5.83418 11.5372C5.82093 13.9222 7.38926 18.3506 14.9409 25.9006C22.4559 33.4139 26.8776 35.0006 29.2693 35.0006H29.3043C31.0093 34.9906 31.8226 34.1556 32.2143 33.7539C32.3326 33.6322 32.4293 33.5406 32.4976 33.4856C34.1593 31.8139 35.0093 30.5722 35.001 29.7739C34.9909 28.9606 33.9793 28.0006 32.5809 26.6689C32.1359 26.2472 31.6526 25.7856 31.1426 25.2756C29.8193 23.9572 29.1676 24.1822 27.7259 24.6889C25.7343 25.3872 23.0059 26.3439 18.7543 22.0889C14.5009 17.8372 15.4543 15.1089 16.1493 13.1156C16.6526 11.6756 16.8826 11.0206 15.5609 9.69724C15.0443 9.18057 14.5793 8.69057 14.1509 8.24057C12.8276 6.85057 11.8726 5.84557 11.0643 5.83391ZM25.4111 9.26307C28.8794 9.93641 31.5578 12.6131 32.2328 16.0831C32.3644 16.7631 31.9228 17.4181 31.2461 17.5497C31.1644 17.5647 31.0844 17.5731 31.0044 17.5731C30.4178 17.5731 29.8961 17.1597 29.7794 16.5631C29.2994 14.0964 27.3978 12.1947 24.9344 11.7164C24.2561 11.5847 23.8144 10.9297 23.9461 10.2514C24.0778 9.57307 24.7444 9.12974 25.4111 9.26307ZM25.3113 3.34341C32.1079 4.09841 37.3863 9.37007 38.1479 16.1651C38.2246 16.8517 37.7313 17.4701 37.0463 17.5467C36.9996 17.5517 36.9513 17.5551 36.9046 17.5551C36.2763 17.5551 35.7363 17.0834 35.6646 16.4451C35.0329 10.8184 30.6629 6.45174 25.0346 5.82674C24.3496 5.75007 23.8546 5.13341 23.9313 4.44674C24.0063 3.76174 24.6179 3.25674 25.3113 3.34341Z"
                      fill="#E8112B" />
                  </svg>
                </div>
                <div class="content">
                  <span>Call Now</span>
                  <p><a :href="`tel:${settings.company_number || settings.company_phone}`">{{ settings.company_number || settings.company_phone }}</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-middle-2 pt-160 pb-50 pt-lg-120 pt-md-60 pb-md-10 pt-xs-60 pb-xs-10">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-8 col-md-6 mb-lg-30">
            <div class="footer-widget-2">
              <div class="footer-about-widget-2">
                <div class="footer-logo mb-30">
                  <router-link to="/">
                    <img :src="settings.company_logo || '/landing/img/logo/logo.svg'" alt="logo">
                  </router-link>
                </div>
                <div class="text" style="font-size: x-small;">
                  <p>
                    Our globally distributed and multilingual team is the cornerstone of our exceptional investigative capabilities. Our positioning across multiple continents allows for round-the-clock support, leveraging diverse expertise to uncover critical insights.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 d-block d-lg-none">
            <div class="footer-widget-2">
              <h3 class="title">Subscribe To Our Newsletter</h3>
              <div class="footer-newsletter-wrap-2">
                <form @submit.prevent="handleNewsletter">
                  <div class="input-wrap">
                    <input type="email" v-model="newsletterEmail" placeholder="Email Address" required>
                    <div class="submit-wrap">
                      <button class="theme-btn" type="submit">subscribe</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xl-8">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="footer-widget-2">
                  <h3 class="title">Quick Links</h3>
                  <div class="footer-menu">
                    <ul>
                      <li><router-link to="/">Home</router-link></li>
                      <li><router-link to="/practice-areas">Practice Areas</router-link></li>
                      <li><router-link to="/services">Services</router-link></li>
                      <li><router-link to="/about">About Us</router-link></li>
                      <li><router-link to="/contact">Contact</router-link></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="footer-widget-2">
                  <h3 class="title">Crime Investigation</h3>
                  <div class="footer-menu">
                    <ul>
                      <li><router-link to="/crime-investigation/pig-butchering">Pig-Butchering Scams</router-link></li>
                      <li><router-link to="/crime-investigation/wallet-compromise">Wallet Compromise</router-link></li>
                      <li><router-link to="/crime-investigation/investment-fraud">Investment Fraud</router-link></li>
                      <li><router-link to="/crime-investigation/romance-scams">Romance Scams</router-link></li>
                      <li><router-link to="/crime-investigation/sim-swapping">SIM-Swapping</router-link></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                <div class="footer-widget-2">
                  <h3 class="title">Subscribe To Our Newsletter</h3>
                  <div class="footer-newsletter-wrap-2">
                    <form @submit.prevent="handleNewsletter">
                      <div class="input-wrap">
                        <input type="email" v-model="newsletterEmail" placeholder="Email Address" required>
                        <div class="submit-wrap">
                          <button class="theme-btn" type="submit">subscribe</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="shape-1">
        <img src="/landing/img/shape/shape-14.svg" alt="shape">
      </div>
      <div class="shape-2">
        <img src="/landing/img/shape/shape-16.svg" alt="shape">
      </div>
      <div class="shape-3">
        <img src="/landing/img/shape/shape-17.svg" alt="shape">
      </div>
      <div class="shape-4">
        <img src="/landing/img/shape/shape-18.svg" alt="shape">
      </div>
      <div class="shape-5">
        <img src="/landing/img/shape/shape-19.svg" alt="shape">
      </div>
    </div>
    <div class="footer-bottom-2 pt-60 pb-60 pt-lg-30 pb-lg-30 pt-md-30 pb-md-30 pt-xs-30 pb-xs-30">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-6 col-lg-5 mb-md-20 mb-xs-20 text-center text-lg-start">
            <div class="copyright">
              All rights reserved ©2024 {{ settings.company_name || 'Platform' }}
            </div>
          </div>
          <div class="col-xl-6 col-lg-7 text-center text-lg-end">
            <div class="footer-bottom-menu">
              <ul>
                <li><router-link to="/faq">FAQ</router-link></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="shape-2">
        <img src="/landing/img/shape/shape-15.svg" alt="shape">
      </div>
    </div>
  </footer>
</template>

<script>
import { onMounted } from 'vue'
import { useSettings } from '../../composables/useSettings'

export default {
  name: 'Footer',
  setup() {
    const { settings, fetchSettings } = useSettings()
    
    onMounted(() => {
      fetchSettings()
    })
    
    return {
      settings
    }
  },
  data() {
    return {
      newsletterEmail: ''
    }
  },
  methods: {
    handleNewsletter() {
      // Handle newsletter subscription
      console.log('Newsletter subscription:', this.newsletterEmail);
      this.newsletterEmail = '';
    }
  }
}
</script>

<style scoped>
/* Footer styles are in main.css */
</style>

