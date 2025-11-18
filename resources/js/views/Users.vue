<template>
  <div class="users">
    <div class="header">
      <h1>Users</h1>
      <button @click="showForm = !showForm" class="btn btn-primary">
        {{ showForm ? 'Cancel' : 'Add User' }}
      </button>
    </div>

    <div v-if="showForm" class="user-form">
      <h2>Create New User</h2>
      <form @submit.prevent="createUser">
        <div class="form-group">
          <label>Name</label>
          <input v-model="form.name" type="text" required class="form-control" />
        </div>
        <div class="form-group">
          <label>Email</label>
          <input v-model="form.email" type="email" required class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          {{ loading ? 'Creating...' : 'Create User' }}
        </button>
      </form>
    </div>

    <div v-if="loading && !users.length" class="loading">Loading users...</div>
    <div v-if="error" class="error">{{ error }}</div>

    <div v-if="users.length" class="users-grid">
      <div v-for="user in users" :key="user.id" class="user-card">
        <h3>{{ user.name }}</h3>
        <p>{{ user.email }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Users',
  data() {
    return {
      users: [],
      loading: false,
      error: null,
      showForm: false,
      form: {
        name: '',
        email: ''
      }
    }
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get('/api/v1/users');
        this.users = response.data.data;
      } catch (err) {
        this.error = 'Failed to load users';
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
    async createUser() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.post('/api/v1/users', this.form);
        this.users.push(response.data.data);
        this.form = { name: '', email: '' };
        this.showForm = false;
      } catch (err) {
        this.error = err.response?.data?.message || 'Failed to create user';
        console.error(err);
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>
.users {
  padding: 2rem 0;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.header h1 {
  font-size: 2rem;
  color: #1a1a1a;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-primary {
  background: #6366f1;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #4f46e5;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.user-form {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  margin-bottom: 2rem;
}

.user-form h2 {
  margin-bottom: 1.5rem;
  color: #1a1a1a;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #333;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 1rem;
  transition: border-color 0.3s;
}

.form-control:focus {
  outline: none;
  border-color: #6366f1;
}

.loading, .error {
  text-align: center;
  padding: 2rem;
  color: #666;
}

.error {
  color: #ef4444;
  background: #fee2e2;
  border-radius: 6px;
  margin-bottom: 1rem;
}

.users-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.user-card {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.user-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.user-card h3 {
  margin-bottom: 0.5rem;
  color: #1a1a1a;
}

.user-card p {
  color: #666;
}
</style>

