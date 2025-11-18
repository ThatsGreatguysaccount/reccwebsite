import { ref, onMounted } from 'vue'
import axios from 'axios'

const settings = ref({
  company_name: '',
  company_email: '',
  company_phone: '',
  company_number: '',
  company_address: '',
  company_address_map_url: '',
  company_website: '',
  company_working_hours: '10:00 AM - 10:00 PM',
  company_logo: '',
  company_logo_white: '',
  company_favicon: ''
})

const loading = ref(false)
const loaded = ref(false)

export function useSettings() {
  const fetchSettings = async () => {
    if (loaded.value) return settings.value
    
    loading.value = true
    try {
      const response = await axios.get('/api/v1/public/settings')
      if (response.data.success && response.data.data) {
        settings.value = {
          company_name: response.data.data.company_name || '',
          company_email: response.data.data.company_email || '',
          company_phone: response.data.data.company_phone || '',
          company_number: response.data.data.company_number || response.data.data.company_phone || '',
          company_address: response.data.data.company_address || '',
          company_address_map_url: response.data.data.company_address_map_url || '',
          company_website: response.data.data.company_website || '',
          company_working_hours: response.data.data.company_working_hours || '10:00 AM - 10:00 PM',
          company_logo: response.data.data.company_logo || '',
          company_logo_white: response.data.data.company_logo_white || '',
          company_favicon: response.data.data.company_favicon || ''
        }
        loaded.value = true
      }
    } catch (error) {
      console.error('Error fetching settings:', error)
    } finally {
      loading.value = false
    }
    
    return settings.value
  }

  return {
    settings,
    loading,
    fetchSettings
  }
}

