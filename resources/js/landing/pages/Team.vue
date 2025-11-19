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
            <div v-if="loading" class="col-12 text-center team-loading">
                <div class="loading-spinner"></div>
                <p>Loading team members...</p>
            </div>
            <div v-else-if="teamMembers.length === 0" class="col-12 text-center team-empty">
                <i class="fa-solid fa-user-group"></i>
                <p>No team members available at the moment.</p>
            </div>
            <div v-else v-for="(member, index) in teamMembers" :key="member.id" 
                 class="col-xl-4 col-lg-4 col-md-6" 
                 :data-aos="'fade-up'" 
                 :data-aos-duration="1000" 
                 :data-aos-delay="200 + (index * 100)">
                <div class="team-wrap mb-30">
                    <div class="thumb">
                        <img :src="member.photo || '/customer/images/user.png'" :alt="member.name" @error="handleImageError">
                    </div>
                    <div class="content">
                        <div class="author">
                            <h4 class="name">
                                {{ member.name }}
                            </h4>
                            <p class="designation">{{ member.designation }}</p>
                        </div>
                        <div v-if="member.email" class="social-wrap">
                            <ul>
                                <li><a :href="`mailto:${member.email}`" :title="`Email ${member.name}`"><i class="fa-regular fa-envelope"></i></a></li>
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
      sidebarOpen: false,
      teamMembers: [],
      loading: true
    }
  },
  async mounted() {
    if (window.AOS) {
      window.AOS.init();
    }
    await this.fetchTeamMembers();
  },
  methods: {
    async fetchTeamMembers() {
      try {
        const response = await window.axios.get('/api/v1/public/team-members');
        if (response.data.success) {
          this.teamMembers = response.data.data.team_members || [];
        }
      } catch (error) {
        console.error('Failed to fetch team members:', error);
        this.teamMembers = [];
      } finally {
        this.loading = false;
      }
    },
    handleImageError(event) {
      // Fallback to default user image if photo fails to load
      event.target.src = '/customer/images/user.png';
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

.team-loading,
.team-empty {
  padding: 60px 20px;
}

.team-loading {
  color: #6b7280;
}

.team-empty {
  color: #6b7280;
}

.team-empty i {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.5;
  display: block;
}

.loading-spinner {
  display: inline-block;
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #2563eb;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

.team-wrap {
  border-radius: 12px;
  overflow: hidden;
}

.team-wrap .thumb {
  position: relative;
  width: 100%;
  height: 450px;
  overflow: hidden;
}

.team-wrap .thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.3s ease;
}

.team-wrap:hover .thumb img {
  transform: scale(1.05);
}

.team-wrap .content .author .name {
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 8px;
  color: #ffffff;
}

.team-wrap .content .author .designation {
  font-size: 14px;
  color: #ffffff;
  margin-bottom: 12px;
}

.team-wrap .content .social-wrap ul li a {
  transition: all 0.3s ease;
}

.team-wrap .content .social-wrap ul li a:hover {
  transform: translateY(-2px);
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 991px) {
  .team-wrap .thumb {
    height: 400px;
  }
}

@media (max-width: 768px) {
  .team-loading,
  .team-empty {
    padding: 40px 15px;
  }
  
  .team-empty i {
    font-size: 36px;
  }
  
  .team-wrap .thumb {
    height: 350px;
  }
}

@media (max-width: 576px) {
  .team-wrap .thumb {
    height: 300px;
  }
}
</style>
