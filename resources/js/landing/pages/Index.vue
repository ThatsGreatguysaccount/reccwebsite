<template>
  <div class="landing-page">
    <!-- Header -->
    <Header @open-sidebar="sidebarOpen = true" />

    <!-- OffCanvas Sidebar -->
    <OffCanvas :isOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-7">
            <div class="hero-content">
              <p class="sub-title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                {{ settings.company_name || 'Our Company' }}
              </p>
              <h3 class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                We have <span>traced</span> cryptocurrencies <span>in hundreds of</span> cybercrime cases
              </h3>
              <div class="hero-buttons" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <router-link to="/contact" class="theme-btn">
                  Contact US
                </router-link>
              </div>
            </div>
          </div>
          <div class="col-xl-5">
            <div class="hero-thumb">
              <div class="hero-thumb-2">
                <img src="/landing/img/thumb/thumb-34.png" alt="thumb" data-aos="zoom-in"
                  data-aos-duration="1000" data-aos-delay="600">
              </div>
              <div class="video-thumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <img src="/landing/img/thumb/thumb-32.png" alt="thumb">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="shape-1">
        <img src="/landing/img/shape/shape-12.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
          data-aos-delay="100">
      </div>
      <div class="shape-2">
        <img src="/landing/img/shape/shape-13.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000"
          data-aos-delay="100">
      </div>
    </section>

    <!-- Steps Section -->
    <section class="h-step-section pt-100 pb-90 pt-lg-50 pb-lg-50 pt-md-50 pb-md-80 pt-xs-30 pb-xs-60">
      <div class="container">
        <div class="row">
          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="step-wrap-2 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-1.svg" alt="icon">
              </div>
              <div class="title">
                <h4>Bespoke Services</h4>
              </div>
              <div class="text">
                <p>Tailored strategies based on a thorough evaluation of each unique case.</p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="step-wrap-2 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-2.svg" alt="icon">
              </div>
              <div class="title">
                <h4>Client Focus</h4>
              </div>
              <div class="text">
                <p>Precision in execution to meet specific client requirements and circumstances.</p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
            <div class="step-wrap-2 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-3.svg" alt="icon">
              </div>
              <div class="title">
                <h4>Adaptable Methods</h4>
              </div>
              <div class="text">
                <p>A toolbox to match the complexity and scale of each situation.</p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
            <div class="step-wrap-2 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-4.svg" alt="icon">
              </div>
              <div class="title">
                <h4>Proportionality</h4>
              </div>
              <div class="text">
                <p>Flexible approaches designed to manage costs while maximizing results.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Working Process Section -->
    <section class="h-three-step-section-2 pb-100 pb-lg-30 pb-md-30 pb-xs-10 overflow-hidden">
      <div class="container">
        <div class="row justify-content-center mb-50">
          <div class="col-xxl-4 col-xl-7 col-md-6">
            <div class="section-heading-wrap text-center">
              <div class="sub-title-3 mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <span>Working Process</span>
              </div>
              <div class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <h2>Few Easy Steps to Get The Work</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-xl-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="step-wrap-3 mb-50">
              <div class="icon">
                <div class="num">01</div>
                <img src="/landing/img/icon/icon-1.svg" alt="icon">
              </div>
              <div class="text">
                <p>Planning</p>
              </div>
              <div class="shape-border"></div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="step-wrap-3 mb-50">
              <div class="icon">
                <div class="num">02</div>
                <img src="/landing/img/icon/icon-40.svg" alt="icon">
              </div>
              <div class="text">
                <p>Research</p>
              </div>
              <div class="shape-border"></div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
            <div class="step-wrap-3 mb-50">
              <div class="icon">
                <div class="num">03</div>
                <img src="/landing/img/icon/icon-41.svg" alt="icon">
              </div>
              <div class="text">
                <p>Technical Work</p>
              </div>
              <div class="shape-border"></div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
            <div class="step-wrap-3 mb-50 shape-none">
              <div class="icon">
                <div class="num">04</div>
                <img src="/landing/img/icon/icon-42.svg" alt="icon">
              </div>
              <div class="text">
                <p>Finalization</p>
              </div>
              <div class="shape-border"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="s-shape-1">
        <img src="/landing/img/shape/shape-24.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
      </div>
      <div class="s-shape-2">
        <img src="/landing/img/shape/shape-25.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
      </div>
    </section>

    <!-- Counter Section -->
    <section class="h-five-counter-section">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="counter-wrap-5">
              <div class="content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="shape">
                  <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70" fill="none">
                    <circle cx="35" cy="35" r="35" fill="url(#paint0_linear_2801_4302)" />
                    <defs>
                      <linearGradient id="paint0_linear_2801_4302" x1="35" y1="0" x2="35" y2="70" gradientUnits="userSpaceOnUse">
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.3" />
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.1" />
                      </linearGradient>
                    </defs>
                  </svg>
                </div>
                <h3>
                  <span class="odometer" data-count="4507">00</span>+
                </h3>
                <p>Successfull Cases</p>
              </div>
              <div class="content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <div class="shape">
                  <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70" fill="none">
                    <circle cx="35" cy="35" r="35" fill="url(#paint0_linear_2801_430212)" />
                    <defs>
                      <linearGradient id="paint0_linear_2801_430212" x1="35" y1="0" x2="35" y2="70" gradientUnits="userSpaceOnUse">
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.3" />
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.1" />
                      </linearGradient>
                    </defs>
                  </svg>
                </div>
                <h3>
                  <span class="odometer" data-count="78">00</span>Mil+
                </h3>
                <p>Totally Recovered</p>
              </div>
              <div class="content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                <div class="shape">
                  <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70" fill="none">
                    <circle cx="35" cy="35" r="35" fill="url(#paint0_linear_2801_4302091)" />
                    <defs>
                      <linearGradient id="paint0_linear_2801_4302091" x1="35" y1="0" x2="35" y2="70" gradientUnits="userSpaceOnUse">
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.3" />
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.1" />
                      </linearGradient>
                    </defs>
                  </svg>
                </div>
                <h3>
                  <span class="odometer" data-count="27">00</span>+
                </h3>
                <p>Partner Organizations</p>
              </div>
              <div class="content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                <div class="shape">
                  <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70" fill="none">
                    <circle cx="35" cy="35" r="35" fill="url(#paint0_linear_2801_432w302)" />
                    <defs>
                      <linearGradient id="paint0_linear_2801_432w302" x1="35" y1="0" x2="35" y2="70" gradientUnits="userSpaceOnUse">
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.3" />
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0.1" />
                      </linearGradient>
                    </defs>
                  </svg>
                </div>
                <h3>
                  <span class="odometer" data-count="98">00</span>+
                </h3>
                <p>Success Rate</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="h-four-about-section pt-195 pb-190 pt-lg-120 pb-lg-80 pt-md-120 pb-md-80 pt-xs-100 pb-xs-60">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-xl-7 col-lg-8 col-md-10 mb-lg-80 mb-md-80 mb-xs-80">
            <div class="h-four-about-thumb">
              <div class="thumb-wrap">
                <img src="/landing/img/thumb/thumb-78.jpg" alt="thumb" data-aos="fade-up"
                  data-aos-duration="1000" data-aos-delay="200">
                <div class="thumb-1">
                  <img src="/landing/img/thumb/thumb-79.jpg" alt="thumb" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="400">
                </div>
                <div class="thumb-content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  <div class="icon">
                    <img src="/landing/img/icon/icon-46.svg" alt="icon">
                  </div>
                  <p>Call For Support</p>
                  <a :href="`tel:${settings.company_number || settings.company_phone || ''}`" class="num" v-if="settings.company_number || settings.company_phone">
                    {{ settings.company_number || settings.company_phone }}
                  </a>
                  <span v-else class="num">Contact us</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-5">
            <div class="h-four-about-content">
              <div class="section-heading-wrap">
                <div class="sub-title-4 mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                  <span>About Us</span>
                </div>
                <div class="title mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  <h2>We have helped to recover millions of dollars</h2>
                </div>
                <div class="text mb-15" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                  <p>
                    Since our inception, {{ settings.company_name || 'our company' }} has built a strong reputation for exceptional cryptocurrency-forensic expertise, catering to individuals, small businesses, enterprises, and law enforcement.
                  </p>
                </div>
              </div>
              <div class="content-author mb-50" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <p class="message">
                  "With a proven history and dedication to excellence, we are your reliable partner in navigating the intricate world of cryptocurrency."
                </p>
              </div>
              <router-link to="/about" class="theme-btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                More Details
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section class="h-two-service-section bg-dark pt-150 pb-120 pt-lg-80 pb-lg-50 pt-md-80 pb-md-50 pt-xs-60 pb-xs-30" id="service">
      <div class="container">
        <div class="row align-items-center mb-50">
          <div class="col-xxl-7 col-xl-8 mb-lg-30 mb-md-30 mb-xs-30">
            <div class="section-heading-wrap">
              <div class="sub-title text-theme-color mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <span>Our Services</span>
              </div>
              <div class="title-2" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <h2>
                  Explore Further How Our Expert Services Can Support Your 
                  <span>Crypto Case</span>
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-9.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/practice-areas/divorce">Divorce</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/practice-areas/divorce" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-10.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/practice-areas/criminal-defense">Criminal Defense</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/practice-areas/criminal-defense" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-11.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/practice-areas/consumer-protection">Consumer Protection</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/practice-areas/consumer-protection" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-12.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/practice-areas/bankruptcy">Bankruptcy</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/practice-areas/bankruptcy" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-13.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/crime-investigation/investment-fraud">Investment Fraud</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/crime-investigation/investment-fraud" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-14.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/crime-investigation/romance-scams">Romance Scams</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/crime-investigation/romance-scams" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-15.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/crime-investigation/sim-swapping">SIM-Swapping</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/crime-investigation/sim-swapping" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
            <div class="service-wrap-5 mb-30">
              <div class="icon">
                <img src="/landing/img/icon/icon-16.svg" alt="icon">
              </div>
              <div class="content">
                <div class="title">
                  <h4><router-link to="/crime-investigation/pig-butchering">Butchering Scams</router-link></h4>
                </div>
                <div class="hover-element">
                  <div class="read-more">
                    <router-link to="/crime-investigation/pig-butchering" class="theme-btn">Read More</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="s-shape-1">
        <img src="/landing/img/shape/shape-47.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
      </div>
      <div class="s-shape-2">
        <img src="/landing/img/shape/shape-47.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
      </div>
    </section>

    <!-- Brand Section -->
    <section class="h-two-brand-section bg-off-white-3 pt-50 pb-50">
      <div class="container">
        <div class="row" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
          <div class="col-xl-12 overflow-hidden">
            <div class="brand-wrapper">
              <div class="brand-layout">
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-1.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-2.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-3.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-4.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-5.svg" alt="brand">
                </div>
              </div>
              <div class="brand-layout">
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-1.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-2.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-3.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-4.svg" alt="brand">
                </div>
                <div class="brand-item">
                  <img src="/landing/img/brand/brand-5.svg" alt="brand">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Who We Work With Section -->
    <section class="h-about-section bg-off-white-3 pt-100 pb-100" id="about">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xxl-7 col-xl-6 text-center text-xl-start mb-lg-50 mb-md-50 mb-xs-50">
            <div class="h-about-us-thumb">
              <div class="video-thumb">
                <img src="/landing/img/thumb/thumb-53.jpg" alt="thumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
              </div>
              <div class="shape-1">
                <img src="/landing/img/thumb/thumb-54.jpg" alt="thumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
              </div>
              <div class="info" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                <h4>10+</h4>
                <p>Years Of Experiences</p>
                <div class="info-bar"></div>
              </div>
            </div>
          </div>
          <div class="col-xxl-5 col-xl-6">
            <div class="h-about-us-content">
              <div class="section-heading-wrap mb-15">
                <div class="sub-title text-theme-color mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                  <span>Our working Proficiency</span>
                </div>
                <div class="title mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  <h2>Who We Work With</h2>
                </div>
                <div class="text" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
                  <p>Our partners play a crucial role in the success of reimbursement cases</p>
                </div>
              </div>
              <ul class="list" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                <li><a>1. Law Firms and Litigants</a></li>
                <li><a>2. Victims of Cybercrime</a></li>
                <li><a>3. Crypto Businesses</a></li>
                <li><a>4. Law Enforcement Agencies</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="s-shape-1">
        <img src="/landing/img/shape/shape-26.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
      </div>
      <div class="s-shape-2">
        <img src="/landing/img/shape/shape-27.svg" alt="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="blog-section pt-150 pb-150 pt-lg-80 pb-lg-50 pt-md-80 pb-md-50 pt-xs-60 pb-xs-30">
      <div class="container">
        <div class="row justify-content-center mb-50">
          <div class="col-xxl-7 col-xl-8">
            <div class="section-heading-wrap text-center">
              <div class="sub-title-7 mb-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <span>Faq</span>
                <div class="shape">
                  <svg xmlns="http://www.w3.org/2000/svg" width="80" height="4" viewBox="0 0 80 4" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1.83902 1.09253C3.53458 1.2993 7.9906 1.30964 20.087 1.33032C38.976 1.36134 53.9673 1.58879 58.1338 1.91963C58.4646 1.95065 31.987 2.1781 29.2679 2.01268C25.029 1.74387 4.78557 1.97132 0.712083 2.28149C-0.445862 2.3642 -0.0116276 2.65369 0.743105 2.71572C1.92172 2.81911 5.08541 2.80877 13.7597 2.78809C19.8596 2.77775 68.3899 3.01554 73.6937 3.43943C76.6712 3.67723 78.4805 3.89434 79.3076 3.84265C80.0003 3.80129 80.0107 3.67723 79.411 3.33605C79.0078 3.10859 79.4627 2.97419 79.7522 2.91215C80.1968 2.80877 80.0107 2.45725 79.4524 2.1781C78.6976 1.79556 77.395 1.8059 78.0153 2.18844C78.1497 2.27115 78.1807 2.47792 77.7051 2.43657C76.3197 2.3125 66.5289 1.46472 63.8718 1.31998C35.5022 -0.251515 7.81484 0.896089 1.95274 0.513553C-0.125359 0.36881 0.825824 0.968461 1.83902 1.09253Z"
                      fill="#2563eb" />
                  </svg>
                </div>
              </div>
              <div class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <h2>Frequently Ask Questions</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-between align-items-center">
          <div class="col-xl-6 mb-lg-50 mb-md-50 mb-xs-50">
            <div class="faq-form-wrap" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
              <div class="faq-form">
                <form @submit.prevent="handleFaqSubmit">
                  <div class="row">
                    <div class="col-xl-6">
                      <div class="input-wrap">
                        <label for="fname">First Name</label>
                        <input type="text" v-model="faqForm.firstName" placeholder="First Name" id="fname" required>
                      </div>
                    </div>
                    <div class="col-xl-6">
                      <div class="input-wrap">
                        <label for="lname">Last Name</label>
                        <input type="text" v-model="faqForm.lastName" placeholder="Last Name" id="lname" required>
                      </div>
                    </div>
                    <div class="col-xl-12">
                      <div class="input-wrap">
                        <label for="email">Email</label>
                        <input type="email" v-model="faqForm.email" placeholder="Email" id="email" required>
                      </div>
                    </div>
                    <div class="col-xl-12">
                      <div class="input-wrap">
                        <label for="phone_number">Phone Number</label>
                        <input type="tel" v-model="faqForm.phone" placeholder="Phone Number" id="phone_number" required>
                      </div>
                    </div>
                    <div class="col-xl-12">
                      <div class="input-wrap">
                        <label for="question">Question</label>
                        <textarea v-model="faqForm.question" placeholder="Write Your Questions" id="question" required></textarea>
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
          <div class="col-xl-5">
            <div class="faq-accordion-1" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
              <div class="accordion" id="faq-accordion-1">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faq-h-1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                      data-bs-target="#faq-coll-1" aria-expanded="true" aria-controls="faq-coll-1">
                      1. How does your crypto recovery service work?
                    </button>
                  </h2>
                  <div id="faq-coll-1" class="accordion-collapse collapse show" aria-labelledby="faq-h-1"
                    data-bs-parent="#faq-accordion-1">
                    <div class="accordion-body">
                      <p>
                        Our crypto recovery service employs cutting-edge blockchain forensics and AI technology to trace and recover stolen or scammed cryptocurrencies. By analyzing transaction patterns and working closely with blockchain networks, we can locate and retrieve your lost assets efficiently and securely.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faq-h-2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#faq-coll-2" aria-expanded="false" aria-controls="faq-coll-2">
                      2. What types of cryptocurrency scams can you help with?
                    </button>
                  </h2>
                  <div id="faq-coll-2" class="accordion-collapse collapse" aria-labelledby="faq-h-2"
                    data-bs-parent="#faq-accordion-1">
                    <div class="accordion-body">
                      <p>
                        We specialize in recovering funds from a wide range of cryptocurrency scams, including phishing attacks, Ponzi schemes, exchange hacks, fraudulent ICOs, and more. If you've been a victim of any form of crypto fraud, our team is equipped to assist you.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faq-h-3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#faq-coll-3" aria-expanded="false" aria-controls="faq-coll-3">
                      3. How successful are you in recovering lost cryptocurrencies?
                    </button>
                  </h2>
                  <div id="faq-coll-3" class="accordion-collapse collapse" aria-labelledby="faq-h-3"
                    data-bs-parent="#faq-accordion-1">
                    <div class="accordion-body">
                      <p>
                        Our success rate is among the highest in the industry, with a track record of recovering millions in lost cryptocurrencies. While each case is unique and success depends on various factors, our advanced tools and expertise give us a strong advantage in recovering your assets.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faq-h-4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#faq-coll-4" aria-expanded="false" aria-controls="faq-coll-4">
                      4. Is my personal information and data secure with your service?
                    </button>
                  </h2>
                  <div id="faq-coll-4" class="accordion-collapse collapse" aria-labelledby="faq-h-4"
                    data-bs-parent="#faq-accordion-1">
                    <div class="accordion-body">
                      <p>
                        Absolutely. We prioritize your privacy and security. All information and data shared with us are encrypted and stored securely. We adhere to strict confidentiality protocols to ensure your personal information remains protected throughout the recovery process.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faq-h-5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#faq-coll-5" aria-expanded="false" aria-controls="faq-coll-5">
                      5. How long does the recovery process take?
                    </button>
                  </h2>
                  <div id="faq-coll-5" class="accordion-collapse collapse" aria-labelledby="faq-h-5"
                    data-bs-parent="#faq-accordion-1">
                    <div class="accordion-body">
                      <p>
                        The recovery process timeline can vary depending on the complexity of the case and the specific circumstances of the loss. On average, most cases are resolved within 4 to 6 weeks. We provide regular updates and work diligently to recover your funds as quickly as possible.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Scroll to Top Button -->
    <a id="scrollToTopBtn" class="progress-wrap">
      <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </a>

    <!-- Footer -->
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
  name: 'LandingIndex',
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
      // Update page title
      if (settings.value.company_name) {
        document.title = settings.value.company_name
      }
    })
    
    return {
      settings
    }
  },
  data() {
    return {
      sidebarOpen: false,
      faqForm: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        question: ''
      }
    }
  },
  methods: {
    handleFaqSubmit() {
      // Handle FAQ form submission
      console.log('FAQ Form submitted:', this.faqForm);
      // You can add API call here
      alert('Thank you for your question! We will get back to you soon.');
      this.faqForm = {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        question: ''
      };
    }
  }
}
</script>

<style>
/* Import landing page styles */
/* Landing page styles will be loaded via link tags in the blade template */
</style>

