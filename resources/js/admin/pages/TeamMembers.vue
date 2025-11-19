<template>
  <div class="customer-dashboard">
    <Header @toggle-sidebar="toggleMobileSidebar" />
    
    <!-- Mobile Sidebar Overlay -->
    <div v-if="showMobileSidebar" class="sidebar-overlay" @click="closeMobileSidebar"></div>
    
    <!-- Add/Edit Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h4>{{ editingMember ? 'Edit Team Member' : 'Add Team Member' }}</h4>
          <button class="modal-close" @click="closeModal">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
        <form @submit.prevent="saveMember" class="modal-body">
          <div class="form-group">
            <label>Name *</label>
            <input v-model="form.name" type="text" required placeholder="Enter full name" />
          </div>
          <div class="form-group">
            <label>Designation *</label>
            <input v-model="form.designation" type="text" required placeholder="e.g., CEO, Head of Department" />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input v-model="form.email" type="email" placeholder="email@example.com" />
          </div>
          <div class="form-group">
            <label>Photo</label>
            <input type="file" @change="handlePhotoChange" accept="image/*" />
            <small>Max 2MB, JPG/PNG/GIF. Image will be automatically resized to 350x450px (portrait format)</small>
            <div v-if="form.photoPreview" class="photo-preview">
              <img :src="form.photoPreview" alt="Preview" />
            </div>
            <div v-else-if="editingMember && editingMember.photo" class="photo-preview">
              <img :src="editingMember.photo" alt="Current" />
            </div>
          </div>
          <div class="form-group">
            <label>Order</label>
            <input v-model.number="form.order" type="number" min="0" placeholder="Display order" />
          </div>
          <div class="form-group">
            <label class="checkbox-label">
              <input v-model="form.is_active" type="checkbox" />
              <span>Active (visible on website)</span>
            </label>
          </div>
          <div class="form-actions">
            <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
            <button type="submit" class="btn-save" :disabled="saving">
              {{ saving ? 'Saving...' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
    
    <div class="dashboard-wrapper">
      <Sidebar :class="{ 'mobile-open': showMobileSidebar }" @sidebar-toggle="handleSidebarToggle" @close-mobile="closeMobileSidebar" />
      
      <div class="dashboard-content" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <div class="container-fluid">
          <!-- Page Header -->
          <div class="page-header">
            <h4>Team Members</h4>
            <button class="btn-add" @click="openAddModal">
              <i class="fa-solid fa-plus"></i>
              Add Team Member
            </button>
          </div>

          <!-- Team Members List -->
          <div class="team-members-section">
            <div v-if="message" :class="['message', messageType]">
              {{ message }}
            </div>
            
            <div v-if="loading" class="loading-state">
              <div class="loading-spinner"></div>
              <p>Loading team members...</p>
            </div>
            
            <div v-else-if="teamMembers.length === 0" class="empty-state">
              <i class="fa-solid fa-user-group"></i>
              <p>No team members found</p>
              <button class="btn-add" @click="openAddModal">Add Your First Team Member</button>
            </div>
            
            <div v-else class="team-members-grid">
              <div v-for="member in teamMembers" :key="member.id" class="team-member-card">
                <div class="member-photo">
                  <img :src="member.photo || '/customer/images/user.png'" :alt="member.name" />
                  <div class="member-status" :class="{ active: member.is_active, inactive: !member.is_active }">
                    {{ member.is_active ? 'Active' : 'Inactive' }}
                  </div>
                </div>
                <div class="member-info">
                  <h5>{{ member.name }}</h5>
                  <p class="designation">{{ member.designation }}</p>
                  <p v-if="member.email" class="email">
                    <a :href="`mailto:${member.email}`">{{ member.email }}</a>
                  </p>
                  <div class="member-order">Order: {{ member.order }}</div>
                </div>
                <div class="member-actions">
                  <button class="btn-edit" @click="editMember(member)">
                    <i class="fa-solid fa-edit"></i>
                    Edit
                  </button>
                  <button class="btn-delete" @click="deleteMember(member.id)">
                    <i class="fa-solid fa-trash"></i>
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Header from '../components/layouts/Header.vue'
import Sidebar from '../components/layouts/Sidebar.vue'

export default {
  name: 'AdminTeamMembers',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      teamMembers: [],
      loading: false,
      saving: false,
      showModal: false,
      editingMember: null,
      message: null,
      messageType: 'success',
      showMobileSidebar: false,
      sidebarCollapsed: false,
      form: {
        name: '',
        designation: '',
        email: '',
        photo: null,
        photoPreview: null,
        order: 0,
        is_active: true
      }
    }
  },
  mounted() {
    this.fetchTeamMembers()
    const savedState = localStorage.getItem('adminSidebarCollapsed')
    if (savedState === 'true') {
      this.sidebarCollapsed = true
    }
  },
  methods: {
    async fetchTeamMembers() {
      this.loading = true
      try {
        const response = await axios.get('/api/v1/admin/team-members', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
        })
        if (response.data.success) {
          this.teamMembers = response.data.data.team_members
        }
      } catch (error) {
        this.showMessage('Failed to load team members', 'error')
        console.error(error)
      } finally {
        this.loading = false
      }
    },
    openAddModal() {
      this.editingMember = null
      this.resetForm()
      this.showModal = true
    },
    editMember(member) {
      this.editingMember = member
      this.form = {
        name: member.name,
        designation: member.designation,
        email: member.email || '',
        photo: null,
        photoPreview: null,
        order: member.order,
        is_active: member.is_active
      }
      this.showModal = true
    },
    closeModal() {
      this.showModal = false
      this.editingMember = null
      this.resetForm()
    },
    resetForm() {
      this.form = {
        name: '',
        designation: '',
        email: '',
        photo: null,
        photoPreview: null,
        order: 0,
        is_active: true
      }
    },
    handlePhotoChange(event) {
      const file = event.target.files[0]
      if (file) {
        if (file.size > 2048 * 1024) {
          this.showMessage('Photo size must be less than 2MB', 'error')
          return
        }
        this.form.photo = file
        const reader = new FileReader()
        reader.onload = (e) => {
          this.form.photoPreview = e.target.result
        }
        reader.readAsDataURL(file)
      }
    },
    async saveMember() {
      this.saving = true
      try {
        const formData = new FormData()
        formData.append('name', this.form.name)
        formData.append('designation', this.form.designation)
        formData.append('email', this.form.email || '')
        formData.append('order', this.form.order)
        formData.append('is_active', this.form.is_active ? '1' : '0')
        if (this.form.photo) {
          formData.append('photo', this.form.photo)
        }

        const url = this.editingMember
          ? `/api/v1/admin/team-members/${this.editingMember.id}`
          : '/api/v1/admin/team-members'
        
        const method = this.editingMember ? 'put' : 'post'
        
        const response = await axios[method](url, formData, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Content-Type': 'multipart/form-data'
          }
        })

        if (response.data.success) {
          this.showMessage(
            this.editingMember ? 'Team member updated successfully' : 'Team member added successfully',
            'success'
          )
          this.closeModal()
          this.fetchTeamMembers()
        }
      } catch (error) {
        const errorMsg = error.response?.data?.message || 'Failed to save team member'
        this.showMessage(errorMsg, 'error')
        console.error(error)
      } finally {
        this.saving = false
      }
    },
    async deleteMember(id) {
      if (!confirm('Are you sure you want to delete this team member?')) {
        return
      }
      
      try {
        const response = await axios.delete(`/api/v1/admin/team-members/${id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
        })
        
        if (response.data.success) {
          this.showMessage('Team member deleted successfully', 'success')
          this.fetchTeamMembers()
        }
      } catch (error) {
        this.showMessage('Failed to delete team member', 'error')
        console.error(error)
      }
    },
    showMessage(text, type = 'success') {
      this.message = text
      this.messageType = type
      setTimeout(() => {
        this.message = null
      }, 5000)
    },
    toggleMobileSidebar() {
      this.showMobileSidebar = !this.showMobileSidebar
    },
    closeMobileSidebar() {
      this.showMobileSidebar = false
    },
    handleSidebarToggle(collapsed) {
      this.sidebarCollapsed = collapsed
    }
  }
}
</script>

<style scoped>
/* Inherit customer dashboard styles */
.customer-dashboard {
  min-height: 100vh;
  background: #f9fafb;
  display: flex;
  flex-direction: column;
}

[data-mode="dark"] .customer-dashboard {
  background: #111827;
}

.dashboard-wrapper {
  display: flex;
  margin-top: 73px;
  min-height: calc(100vh - 73px);
}

.dashboard-content {
  flex: 1;
  margin-left: 260px;
  padding: 24px;
  transition: margin-left 0.3s ease;
  width: calc(100% - 260px);
  overflow-x: hidden;
  position: relative;
  z-index: 1;
}

.dashboard-content.sidebar-collapsed {
  margin-left: 80px;
  width: calc(100% - 80px);
}

.container-fluid {
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
  padding: 0;
}

@media (max-width: 1024px) {
  .dashboard-content {
    margin-left: 0 !important;
    width: 100% !important;
    padding: 16px;
  }
  
  .dashboard-content.sidebar-collapsed {
    margin-left: 0 !important;
    width: 100% !important;
  }
  
  .dashboard-wrapper {
    margin-top: 60px;
  }
  
  .customer-dashboard {
    overflow-x: hidden;
  }
  
  .container-fluid {
    padding: 0;
  }
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.btn-add {
  padding: 10px 20px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s;
}

.btn-add:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 99;
  display: none;
}

@media (max-width: 1024px) {
  .sidebar-overlay {
    display: block;
  }
}

.team-members-section {
  background: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  min-height: 400px;
  position: relative;
}

[data-mode="dark"] .team-members-section {
  background: #1f2937;
}

.loading-state, .empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #6b7280;
}

.empty-state i {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.5;
}

.team-members-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 24px;
}

@media (max-width: 768px) {
  .team-members-grid {
    grid-template-columns: 1fr;
  }
}

.team-member-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 20px;
  border: 1px solid #e5e7eb;
  transition: all 0.2s;
}

.team-member-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.member-photo {
  position: relative;
  margin-bottom: 16px;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
}

.member-photo img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  background: #f3f4f6;
}

.member-status {
  position: absolute;
  bottom: 8px;
  right: calc(50% - 50px);
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  white-space: nowrap;
}

.member-status.active {
  background: #10b981;
  color: white;
}

.member-status.inactive {
  background: #ef4444;
  color: white;
}

.member-info {
  text-align: center;
  margin-bottom: 16px;
}

.member-info h5 {
  margin: 0 0 8px 0;
  font-size: 18px;
  font-weight: 600;
  color: #111827;
}

.designation {
  margin: 0 0 8px 0;
  color: #6b7280;
  font-size: 14px;
}

.email {
  margin: 8px 0;
  font-size: 13px;
}

.email a {
  color: #2563eb;
  text-decoration: none;
}

.member-order {
  font-size: 12px;
  color: #9ca3af;
  margin-top: 8px;
}

.member-actions {
  display: flex;
  gap: 8px;
}

.btn-edit, .btn-delete {
  flex: 1;
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

.btn-edit {
  background: #2563eb;
  color: white;
}

.btn-edit:hover {
  background: #1e40af;
}

.btn-delete {
  background: #ef4444;
  color: white;
}

.btn-delete:hover {
  background: #dc2626;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  padding: 20px;
}

.modal-content {
  background: white;
  border-radius: 12px;
  width: 100%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e5e7eb;
}

.modal-header h4 {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
}

.modal-close {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #6b7280;
  padding: 4px;
}

.modal-body {
  padding: 24px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #374151;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="number"],
.form-group input[type="file"] {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  box-sizing: border-box;
  transition: border-color 0.2s;
}

.form-group input[type="text"]:focus,
.form-group input[type="email"]:focus,
.form-group input[type="number"]:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-group input[type="file"] {
  padding: 8px;
  cursor: pointer;
}

.form-group small {
  display: block;
  margin-top: 4px;
  color: #6b7280;
  font-size: 12px;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
  width: auto;
}

.photo-preview {
  margin-top: 12px;
}

.photo-preview img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e5e7eb;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 24px;
  padding-top: 20px;
  border-top: 1px solid #e5e7eb;
}

.btn-cancel {
  padding: 10px 20px;
  background: #f3f4f6;
  color: #374151;
  border: none;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
}

.btn-save {
  padding: 10px 20px;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: white;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
}

.btn-save:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.message {
  padding: 12px 16px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 14px;
}

.message.success {
  background: #d1fae5;
  color: #059669;
  border: 1px solid #a7f3d0;
}

.message.error {
  background: #fee2e2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

[data-mode="dark"] .team-members-section,
[data-mode="dark"] .team-member-card,
[data-mode="dark"] .modal-content {
  background: #1f2937;
  color: #f9fafb;
}

[data-mode="dark"] .team-member-card {
  border-color: #374151;
  background: #111827;
}

[data-mode="dark"] .member-info h5 {
  color: #f9fafb;
}

[data-mode="dark"] .member-info .designation {
  color: #9ca3af;
}

[data-mode="dark"] .form-group input {
  background: #374151;
  border-color: #4b5563;
  color: #f9fafb;
}

[data-mode="dark"] .form-group label {
  color: #e5e7eb;
}

[data-mode="dark"] .modal-header {
  border-color: #374151;
}

[data-mode="dark"] .form-actions {
  border-color: #374151;
}

[data-mode="dark"] .btn-cancel {
  background: #374151;
  color: #e5e7eb;
}

[data-mode="dark"] .btn-cancel:hover {
  background: #4b5563;
}

[data-mode="dark"] .member-photo img {
  border-color: #374151;
  background: #374151;
}
</style>

