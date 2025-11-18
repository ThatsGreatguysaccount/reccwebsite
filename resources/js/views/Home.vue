<template>
  <div class="home">
    <div class="hero">
      <h1>Welcome to Platform</h1>
      <p class="subtitle">A modern Vue.js + Laravel application</p>
      <div class="features">
        <div class="feature-card">
          <h3>🚀 Fast</h3>
          <p>Built with Vue 3 and Laravel 10</p>
        </div>
        <div class="feature-card">
          <h3>⚡ Modern</h3>
          <p>Using Vite for lightning-fast development</p>
        </div>
        <div class="feature-card">
          <h3>🔧 Flexible</h3>
          <p>RESTful API architecture</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Home'
}
</script>

<style scoped>
.home {
  padding: 2rem 0;
}

.hero {
  text-align: center;
  padding: 3rem 0;
}

.hero h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: #1a1a1a;
}

.subtitle {
  font-size: 1.25rem;
  color: #666;
  margin-bottom: 3rem;
}

.features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.feature-card {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.feature-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.feature-card h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
  color: #6366f1;
}

.feature-card p {
  color: #666;
  line-height: 1.6;
}
</style>

