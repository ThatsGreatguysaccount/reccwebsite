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
                            <h2>Sign Up</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>Sign Up</li>
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

    <!-- sign-up-section start -->
    <div class="sign-up-section pt-150 pb-120 pt-lg-80 pb-lg-50 pt-md-80 pb-md-50 pt-xs-60 pb-xs-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="sign-up-form-wrapper">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-6 col-lg-6 mb-md-50 mb-xs-50" data-aos="fade-up" data-aos-duration="1000"
                                data-aos-delay="200" style="opacity: 1; visibility: visible;">
                                <form @submit.prevent="handleSignUp" class="sign-up-form">
                                    <div class="title">
                                        <h3>Create Your Account</h3>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" placeholder="Username" v-model="signUpForm.username">
                                        <div class="icon">
                                            <img src="/landing/img/icon/s-icon-1.svg" alt="icon">
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="email" placeholder="Email Name" v-model="signUpForm.email">
                                        <div class="icon">
                                            <img src="/landing/img/icon/s-icon-2.svg" alt="icon">
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="password" placeholder="Password" v-model="signUpForm.password">
                                        <div class="icon">
                                            <img src="/landing/img/icon/s-icon-4.svg" alt="icon">
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="password" placeholder="Confirm Password" v-model="signUpForm.confirmPassword">
                                        <div class="icon">
                                            <img src="/landing/img/icon/s-icon-4.svg" alt="icon">
                                        </div>
                                    </div>
                                    <div class="input-checkbox">
                                        <input type="checkbox" id="agree" v-model="signUpForm.agree">
                                        <label for="agree">
                                            <span class="check-mark"></span>
                                            I have read and agree to the Terms & Conditions
                                        </label>
                                    </div>
                                    <div v-if="error" class="error-message" style="color: #2563eb; margin-bottom: 15px; padding: 10px; background: #dbeafe; border-radius: 5px; border-left: 3px solid #2563eb;">
                                        {{ error }}
                                    </div>
                                    <div class="input-submit">
                                        <input type="submit" :value="loading ? 'Creating Account...' : 'Submit Now'" :disabled="loading">
                                    </div>
                                    <div class="input-info">
                                        <p>Have an account? <router-link to="/sign-in">Sign in</router-link></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sign-up-section end -->

    <Footer />
  </div>
</template>

<script>
import Header from '../components/layouts/Header.vue'
import Footer from '../components/layouts/Footer.vue'
import OffCanvas from '../components/layouts/OffCanvas.vue'

export default {
  name: 'SignUp',
  components: {
    Header,
    Footer,
    OffCanvas
  },
  data() {
    return {
      sidebarOpen: false,
      signUpForm: {
        username: '',
        email: '',
        password: '',
        confirmPassword: '',
        agree: false
      },
      loading: false,
      error: null
    }
  },
  mounted() {
    // Use nextTick to ensure DOM is fully rendered
    this.$nextTick(() => {
      // Initialize AOS on mount
      if (window.AOS) {
        window.AOS.init({
          duration: 1000,
          once: true,
          offset: 0,
          disable: false
        });
        // Refresh AOS to ensure elements are visible
        window.AOS.refresh();
      }
      
      // Force visibility as fallback
      const formElement = this.$el.querySelector('.sign-up-form');
      if (formElement) {
        formElement.style.opacity = '1';
        formElement.style.visibility = 'visible';
      }
    });
  },
  methods: {
    async handleSignUp() {
      // Reset error
      this.error = null;
      
      // Validation
      if (!this.signUpForm.username || !this.signUpForm.email || !this.signUpForm.password || !this.signUpForm.confirmPassword) {
        this.error = 'Please fill in all required fields';
        return;
      }
      
      // Email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.signUpForm.email)) {
        this.error = 'Please enter a valid email address';
        return;
      }
      
      // Password validation
      if (this.signUpForm.password.length < 6) {
        this.error = 'Password must be at least 6 characters long';
        return;
      }
      
      // Password confirmation
      if (this.signUpForm.password !== this.signUpForm.confirmPassword) {
        this.error = 'Passwords do not match';
        return;
      }
      
      if (!this.signUpForm.agree) {
        this.error = 'Please agree to the Terms & Conditions';
        return;
      }
      
      this.loading = true;
      
      try {
        // Make API call to register
        const response = await window.axios.post('/api/v1/auth/register', {
          username: this.signUpForm.username,
          email: this.signUpForm.email,
          password: this.signUpForm.password,
          password_confirmation: this.signUpForm.confirmPassword
        });
        
        // Store auth token if provided
        // Response structure: { success: true, message: '...', data: { user: {...}, token: '...' } }
        if (response.data.data && response.data.data.token) {
          localStorage.setItem('auth_token', response.data.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.data.user));
          
          // Redirect based on account type
          const user = response.data.data.user;
          if (user.account_type === 'administrator') {
            this.$router.push('/admin/accounts');
          } else {
            this.$router.push('/customer/dashboard');
          }
        } else {
          this.error = 'Registration successful but no token received. Please try logging in.';
        }
      } catch (error) {
        // Handle error
        console.error('Registration error:', error);
        
        if (error.response) {
          // Server responded with error
          const responseData = error.response.data;
          
          if (responseData.errors) {
            // Laravel validation errors
            const errors = responseData.errors;
            this.error = Object.values(errors).flat().join(', ');
          } else if (responseData.message) {
            this.error = responseData.message;
          } else if (responseData.data && responseData.data.message) {
            this.error = responseData.data.message;
          } else {
            this.error = 'Registration failed. Please check your information and try again.';
          }
        } else if (error.request) {
          // Request made but no response
          this.error = 'Unable to connect to server. Please check if the server is running.';
        } else {
          // Error setting up request
          this.error = 'An error occurred. Please try again.';
        }
      } finally {
        this.loading = false;
      }
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

/* Ensure sign-up form is always visible */
.sign-up-form-wrapper {
  opacity: 1 !important;
  visibility: visible !important;
}

.sign-up-form {
  opacity: 1 !important;
  visibility: visible !important;
}

/* Override AOS initial state */
.sign-up-form-wrapper [data-aos] {
  opacity: 1 !important;
  visibility: visible !important;
}
</style>
