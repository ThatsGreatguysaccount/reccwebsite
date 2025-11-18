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
                            <h2>About us</h2>
                        </div>
                        <div class="breadcrumb-content" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            <ul>
                                <li>
                                    <router-link to="/">Home</router-link>
                                </li>
                                <li>
                                    <router-link to="/">About US</router-link>
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

    <!-- project-details start -->
    <div class="project-details pt-150 pb-150 pt-lg-80 pb-lg-80 pt-md-80 pb-md-80 pt-xs-60 pb-xs-60">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 pr-50" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="project-details-wrap">
                        <div class="title mb-30">
                            <h2>About Us</h2>
                        </div>
                        <div class="short-description mb-30">
                            <p>
                                Welcome to {{ settings.company_name || 'our company' }} – Your Trusted Partner in Cryptocurrency Recovery. {{ settings.company_name || 'Our company' }} is a pioneering firm specializing in the recovery of stolen and scammed cryptocurrencies. Founded with the mission to bring justice and security to the decentralized world, we have established ourselves as leaders in the field of blockchain forensics and digital asset recovery. Our headquarters are located at {{ settings.company_address || 'our headquarters' }}.
                            </p>
                        </div>
                        <div class="text mb-30">
                            <h3>Who We Are</h3>
                            <p>
                                {{ settings.company_name || 'Our company' }} is dedicated to helping victims of cryptocurrency fraud recover their assets and restore their peace of mind. In an industry often marred by scams and cyber threats, we stand as a beacon of hope, providing the expertise and technological prowess needed to trace and retrieve lost digital assets.
                            </p>
                            <h3>Our Vision</h3>
                            <p>
                                We envision a world where the blockchain ecosystem is secure, transparent, and trustworthy. By pioneering advanced recovery methods and fostering a community of vigilant and informed cryptocurrency users, we aim to significantly reduce the prevalence of crypto scams and contribute to a safer digital financial environment.
                            </p>
                            <h3>Our Values</h3>
                            <ul>
                                <li><strong>Integrity:</strong> We operate with the highest ethical standards, ensuring transparency and honesty in all our dealings. Our clients' trust is paramount, and we are committed to upholding it through every step of the recovery process.</li>
                                <li><strong>Excellence:</strong> We strive for excellence in everything we do, from our cutting-edge recovery techniques to our unparalleled customer service. Our team consists of top-tier professionals who bring their expertise and dedication to each case.</li>
                                <li><strong>Innovation:</strong> The world of blockchain is ever-evolving, and so are we. We continuously innovate, adopting the latest technologies and methodologies to stay ahead in the fight against cryptocurrency fraud.</li>
                                <li><strong>Client-Centric Approach:</strong> Our clients are at the heart of our operations. We are dedicated to providing personalized, compassionate, and effective services that meet the unique needs of each individual and organization we serve.</li>
                            </ul>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Our Services</h3>
                            <p>
                                At {{ settings.company_name || 'our company' }}, we offer a comprehensive range of services designed to address the various facets of cryptocurrency recovery:
                            </p>
                            <ol>
                                <li><strong>Cryptocurrency Recovery:</strong> Utilizing state-of-the-art blockchain forensics, we trace and recover stolen or scammed cryptocurrencies. Our process involves meticulous analysis of transaction patterns, leveraging advanced tools and technologies to locate and reclaim lost assets.</li>
                                <li><strong>Fraud Investigation:</strong> We conduct in-depth investigations into cryptocurrency scams and frauds. Our experts analyze digital footprints, uncovering the perpetrators behind fraudulent activities and gathering evidence to support recovery efforts and legal actions.</li>
                                <li><strong>Consulting Services:</strong> We provide expert consulting services to individuals and organizations, helping them navigate the complexities of the cryptocurrency landscape. From security audits to risk assessments, our consultancy services are designed to fortify your digital assets against potential threats.</li>
                                <li><strong>Legal Support:</strong> In collaboration with legal experts, we offer support in pursuing legal actions against fraudsters. Our team works closely with law enforcement agencies and legal professionals to ensure that justice is served and victims are compensated.</li>
                            </ol>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Our Expertise</h3>
                            <p>
                                {{ settings.company_name || 'Our company' }} boasts a team of highly skilled professionals with diverse backgrounds in blockchain technology, cybersecurity, law enforcement, and financial forensics. Our multidisciplinary approach enables us to tackle complex cases with precision and efficacy.
                            </p>
                            <ul>
                                <li><strong>Blockchain Forensics Experts:</strong> Our forensic specialists possess deep knowledge of blockchain technology and cryptocurrency transactions. They are adept at tracing the movement of digital assets across various blockchain networks, identifying patterns, and pinpointing the destination of stolen funds.</li>
                                <li><strong>Cybersecurity Professionals:</strong> With extensive experience in cybersecurity, our team is well-equipped to address the technical challenges associated with cryptocurrency recovery. They implement robust security measures to protect clients' information and prevent further incidents of fraud.</li>
                                <li><strong>Legal Advisors:</strong> Our legal advisors bring their expertise in digital law and cybercrime, providing valuable insights and support in the recovery process. They help navigate the legal intricacies of cryptocurrency fraud, ensuring compliance and maximizing the chances of successful recovery.</li>
                            </ul>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Our Process</h3>
                            <p>
                                Our recovery process is designed to be thorough, transparent, and efficient. Here's a step-by-step overview of how we work:
                            </p>
                            <ol>
                                <li><strong>Initial Consultation:</strong> We begin with a free, no-obligation consultation to understand your case. During this session, we gather essential information about the incident, the type of cryptocurrency involved, and the circumstances surrounding the loss.</li>
                                <li><strong>Case Assessment:</strong> After the initial consultation, our team conducts a detailed assessment of your case. We analyze transaction data, review relevant documentation, and develop a customized recovery plan tailored to your specific needs.</li>
                                <li><strong>Forensic Investigation:</strong> Our forensic experts delve into the blockchain, tracing the path of the stolen funds. Using advanced tools and techniques, we identify the addresses involved and map out the movement of the assets.</li>
                                <li><strong>Recovery Strategy:</strong> Based on our findings, we devise a strategic plan to recover the lost assets. This may involve contacting exchanges, collaborating with law enforcement, and implementing technical measures to reclaim the funds.</li>
                                <li><strong>Execution and Monitoring:</strong> We execute the recovery strategy, closely monitoring the process to ensure timely and successful retrieval of the assets. Throughout this phase, we keep you informed with regular updates on the progress.</li>
                                <li><strong>Post-Recovery Support:</strong> Once the assets are recovered, we provide post-recovery support to help secure your digital wallet and prevent future incidents. We also offer consulting services to enhance your overall cryptocurrency security posture.</li>
                            </ol>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Success Stories</h3>
                            <p>
                                Our success is measured by the satisfaction and relief of our clients. Here are a few testimonials from individuals and organizations who have benefited from our services:
                            </p>
                            <ul>
                                <li><strong>Client A:</strong> "After falling victim to a phishing scam, I thought I had lost my bitcoins forever. {{ settings.company_name || 'Our company' }} not only recovered my funds but also provided valuable insights on securing my digital assets. Their expertise and dedication are truly commendable."</li>
                                <li><strong>Client B:</strong> "When our exchange was hacked, we faced significant financial losses and reputational damage. {{ settings.company_name || 'Our company' }}'s team acted swiftly, tracing the stolen funds and working with authorities to recover a substantial portion of our assets. Their professionalism and efficiency were critical to our recovery."</li>
                                <li><strong>Client C:</strong> "{{ settings.company_name || 'Our company' }}'s consulting services have been invaluable in fortifying our security measures. Their comprehensive risk assessments and proactive strategies have greatly enhanced our protection against potential threats."</li>
                            </ul>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Why Choose {{ settings.company_name || 'Our Company' }}?</h3>
                            <p>
                                Choosing {{ settings.company_name || 'our company' }} means partnering with a trusted leader in cryptocurrency recovery. Here are a few reasons why we stand out:
                            </p>
                            <ol>
                                <li><strong>Proven Expertise:</strong> With a team of seasoned professionals and a track record of successful recoveries, we have the expertise needed to handle even the most complex cases.</li>
                                <li><strong>Advanced Technology:</strong> We leverage the latest advancements in blockchain forensics and cybersecurity to provide top-notch recovery services. Our cutting-edge tools and techniques set us apart in the industry.</li>
                                <li><strong>Personalized Service:</strong> We understand that each case is unique. Our personalized approach ensures that your specific needs are met, and our dedicated support team is always available to assist you.</li>
                                <li><strong>Confidentiality and Security:</strong> Your privacy and security are our top priorities. We adhere to strict confidentiality protocols and implement robust security measures to protect your information throughout the recovery process.</li>
                                <li><strong>No Recovery, No Fee:</strong> Our contingency-based fee structure means you only pay if we successfully recover your assets. This ensures that we are fully committed to achieving the best possible outcome for you.</li>
                            </ol>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Our Community Involvement</h3>
                            <p>
                                At {{ settings.company_name || 'our company' }}, we believe in giving back to the community. We actively participate in initiatives aimed at educating and empowering cryptocurrency users. Our community involvement includes:
                            </p>
                            <ul>
                                <li><strong>Educational Workshops:</strong> We conduct workshops and seminars to educate the public about cryptocurrency security and fraud prevention. Our goal is to raise awareness and promote safe practices in the digital asset space.</li>
                                <li><strong>Industry Collaboration:</strong> We collaborate with other industry leaders, law enforcement agencies, and regulatory bodies to combat cryptocurrency fraud. By sharing knowledge and resources, we contribute to a more secure and trustworthy blockchain ecosystem.</li>
                                <li><strong>Research and Development:</strong> We invest in ongoing research and development to stay at the forefront of blockchain technology and cybersecurity. Our commitment to innovation ensures that we continue to provide the best possible services to our clients.</li>
                            </ul>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Contact Us</h3>
                            <p>
                                We are here to help you recover your lost cryptocurrencies and secure your digital assets. If you have any questions or need assistance, please do not hesitate to contact us:
                            </p>
                            <p>
                                <strong>{{ settings.company_name || 'Our Company' }}</strong><br>
                                <span v-if="settings.company_address">{{ settings.company_address }}</span>
                            </p>
                            <p v-if="settings.company_number || settings.company_phone">
                                <strong>Phone:</strong> {{ settings.company_number || settings.company_phone }}<br>
                            </p>
                            <p v-if="settings.company_email">
                                <strong>Email:</strong> <a :href="`mailto:${settings.company_email}`">{{ settings.company_email }}</a><br>
                            </p>
                            <p v-if="settings.company_website">
                                Visit our website at <a :href="settings.company_website" target="_blank">{{ settings.company_website }}</a> for more information about our services and to schedule a free consultation.
                            </p>
                        </div>
                        
                        <div class="text mb-30">
                            <h3>Join Us</h3>
                            <p>
                                If you are passionate about blockchain technology and cybersecurity, we invite you to join our team. We are always looking for talented individuals who share our vision and values. Check out our career opportunities on our website and become a part of {{ settings.company_name || 'our company' }}'s mission to make the cryptocurrency world a safer place.
                            </p>
                        </div>
                    </div>                    
                </div>
                <div class="col-xl-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="service-sidebar">
                        <div class="sidebar-widget mb-50">
                            
                        </div>
                        <div class="sidebar-widget mb-50">
                            <div class="sidebar-contact-us" style="background-image: url(/landing/img/thumb/thumb-36.png); color: black; border: 3px solid #2563eb; padding: 10px;">
                                <h3 style="color: black;">Contact Us</h3>
                                <p style="color: black;">
                                    Collaboratively engineer prospective imperatives with transparent technology.
                                </p>
                                <form action="#">
                                    <div class="input-wrap" style="margin-bottom: 10px;">
                                        <input type="text" placeholder="Enter Name" style="color: black; border: 1px solid rgb(0, 0, 0); background-color: rgba(128, 128, 128, 0.5); width: 100%; padding: 5px;">
                                    </div>
                                    <div class="input-wrap" style="margin-bottom: 10px;">
                                        <input type="text" placeholder="Email" style="color: black; border: 1px solid black; background-color: rgba(128, 128, 128, 0.5); width: 100%; padding: 5px;">
                                    </div>
                                    <div class="input-wrap" style="margin-bottom: 10px;">
                                        <textarea placeholder="Write Message" style="color: black; border: 1px solid black; background-color: rgba(128, 128, 128, 0.5); width: 100%; padding: 5px;"></textarea>
                                    </div>
                                    <div class="input-submit" style="margin-bottom: 10px;">
                                        <input type="submit" value="Contact Now" style="color: black; border: 3px solid #2563eb; background-color: rgba(128, 128, 128, 0.5); padding: 5px 10px;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service-details end -->
    
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
  name: 'About',
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
