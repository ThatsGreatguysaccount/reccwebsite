import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Use relative URLs in production, or VITE_API_URL if set
window.axios.defaults.baseURL = import.meta.env.VITE_API_URL || '';

// Add auth token to requests if available
window.axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Handle 401 Unauthorized responses - auto logout
window.axios.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response && error.response.status === 401) {
      // Token is invalid or expired, clear auth and redirect to login
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      
      // Only redirect if not already on sign-in page
      if (window.location.pathname !== '/sign-in' && window.location.pathname !== '/sign-up') {
        window.location.href = '/sign-in';
      }
    }
    return Promise.reject(error);
  }
);

