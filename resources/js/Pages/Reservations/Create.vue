<template>
  <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
        <h1 class="text-3xl font-bold text-white text-center">Make a Reservation</h1>
        <p class="text-blue-100 text-center mt-2">Book your table at our restaurant</p>
      </div>

      <form @submit.prevent="submitReservation" class="px-6 py-8">
        <!-- Surname Field -->
        <div class="mb-6">
          <label for="surname" class="block text-gray-700 font-semibold mb-2">
            Surname <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.surname"
            type="text"
            id="surname"
            placeholder="Enter your surname"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            @blur="validateField('surname')"
          />
          <p v-if="errors.surname" class="text-red-500 text-sm mt-1">{{ errors.surname }}</p>
        </div>

        <!-- Phone Number Field -->
        <div class="mb-6">
          <label for="phone_number" class="block text-gray-700 font-semibold mb-2">
            Phone Number <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.phone_number"
            type="tel"
            id="phone_number"
            placeholder="e.g., +1 (555) 123-4567"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            @blur="validateField('phone_number')"
          />
          <p v-if="errors.phone_number" class="text-red-500 text-sm mt-1">{{ errors.phone_number }}</p>
        </div>

        <!-- Email Field -->
        <div class="mb-6">
          <label for="email" class="block text-gray-700 font-semibold mb-2">
            Email <span class="text-gray-500">(Optional)</span>
          </label>
          <input
            v-model="form.email"
            type="email"
            id="email"
            placeholder="your@email.com"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            @blur="validateField('email')"
          />
          <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
          <p class="text-gray-500 text-xs mt-1">We'll send a confirmation to this email</p>
        </div>

        <!-- Reservation Date -->
        <div class="mb-6">
          <label for="reservation_date" class="block text-gray-700 font-semibold mb-2">
            Reservation Date <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.reservation_date"
            type="date"
            id="reservation_date"
            :min="minDate"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            @change="validateField('reservation_date')"
          />
          <p v-if="errors.reservation_date" class="text-red-500 text-sm mt-1">{{ errors.reservation_date }}</p>
        </div>

        <!-- Session Selection -->
        <div class="mb-6">
          <label for="session" class="block text-gray-700 font-semibold mb-2">
            Session <span class="text-red-500">*</span>
          </label>
          <select
            v-model="form.session"
            id="session"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            @change="validateField('session')"
          >
            <option value="">-- Select a session --</option>
            <option value="lunch">Lunch (12:00 PM - 3:00 PM)</option>
            <option value="dinner">Dinner (6:00 PM - 11:00 PM)</option>
          </select>
          <p v-if="errors.session" class="text-red-500 text-sm mt-1">{{ errors.session }}</p>
        </div>

        <!-- Reservation Time -->
        <div class="mb-6">
          <label for="reservation_time" class="block text-gray-700 font-semibold mb-2">
            Reservation Time <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.reservation_time"
            type="time"
            id="reservation_time"
            :min="minTime"
            :max="maxTime"
            :disabled="!form.session"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 disabled:bg-gray-100"
            @change="validateField('reservation_time')"
          />
          <p v-if="errors.reservation_time" class="text-red-500 text-sm mt-1">{{ errors.reservation_time }}</p>
          <p v-if="!form.session" class="text-gray-500 text-xs mt-1">Please select a session first</p>
          <p v-else class="text-gray-500 text-xs mt-1">
            <span v-if="form.session === 'lunch'">Available: 11:00 AM - 2:00 PM</span>
            <span v-else-if="form.session === 'dinner'">Available: 6:00 PM - 11:00 PM</span>
          </p>
        </div>

        <!-- Number of Guests -->
        <div class="mb-6">
          <label for="number_of_guests" class="block text-gray-700 font-semibold mb-2">
            Number of Guests <span class="text-red-500">*</span>
          </label>
          <input
            v-model.number="form.number_of_guests"
            type="number"
            id="number_of_guests"
            min="1"
            max="55"
            placeholder="1"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            @blur="validateField('number_of_guests')"
          />
          <p v-if="errors.number_of_guests" class="text-red-500 text-sm mt-1">{{ errors.number_of_guests }}</p>
          <p class="text-gray-500 text-xs mt-1">Maximum 55 guests per reservation</p>
        </div>

        <!-- Notes Field -->
        <div class="mb-6">
          <label for="notes" class="block text-gray-700 font-semibold mb-2">
            Special Requests <span class="text-gray-500">(Optional)</span>
          </label>
          <textarea
            v-model="form.notes"
            id="notes"
            placeholder="e.g., vegetarian menu, high chair needed, etc."
            rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 resize-none"
            @blur="validateField('notes')"
          ></textarea>
          <p v-if="errors.notes" class="text-red-500 text-sm mt-1">{{ errors.notes }}</p>
        </div>

        <!-- Server Error -->
        <div v-if="serverError" class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
          {{ serverError }}
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="form.processing"
          class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold py-3 rounded-lg transition duration-200"
        >
          <span v-if="!form.processing">Complete Reservation</span>
          <span v-else>Processing...</span>
        </button>

        <!-- Required Fields Note -->
        <p class="text-gray-500 text-xs mt-4 text-center">
          <span class="text-red-500">*</span> indicates required fields
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

// ✅ useForm handles CSRF automatically
const form = useForm({
  surname: '',
  phone_number: '',
  email: '',
  reservation_date: '',
  session: '',
  reservation_time: '',
  number_of_guests: 1,
  notes: ''
})

const errors = ref({})
const showSuccessModal = ref(false)
const serverError = ref('')

const minDate = computed(() => {
  const today = new Date()
  return today.toISOString().split('T')[0]
})

const minTime = computed(() => {
  // Lunch: 11:00 AM
  if (form.session === 'lunch') return '11:00'
  // Dinner: 6:00 PM (18:00)
  if (form.session === 'dinner') return '18:00'
  return ''
})

const maxTime = computed(() => {
  // Lunch: 2:00 PM (14:00)
  if (form.session === 'lunch') return '14:00'
  // Dinner: 11:00 PM (23:00)
  if (form.session === 'dinner') return '23:00'
  return ''
})

// ---- All your existing validation logic, unchanged ----

const validateField = (field) => {
  const value = form[field]   // ⚠️ form is now a useForm object, not a ref — access directly

  switch (field) {
    case 'surname':
      if (!value.trim()) {
        errors.value[field] = 'Please enter your surname'
      } else if (value.trim().length < 2) {
        errors.value[field] = 'Surname must be at least 2 characters'
      } else {
        delete errors.value[field]
      }
      break

    case 'phone_number':
      if (!value.trim()) {
        errors.value[field] = 'Please enter your phone number'
      } else if (!/^[\d\s\-\+\(\)]+$/.test(value)) {
        errors.value[field] = 'Please enter a valid phone number'
      } else if (value.replace(/\D/g, '').length < 10) {
        errors.value[field] = 'Phone number must have at least 10 digits'
      } else {
        delete errors.value[field]
      }
      break

    case 'email':
      if (value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
        errors.value[field] = 'Please enter a valid email address'
      } else {
        delete errors.value[field]
      }
      break

    case 'reservation_date':
      if (!value) {
        errors.value[field] = 'Please select a reservation date'
      } else {
        delete errors.value[field]
      }
      break

    case 'session':
      if (!value) {
        errors.value[field] = 'Please select a session (lunch or dinner)'
      } else {
        delete errors.value[field]
      }
      break

    case 'reservation_time':
      if (!value) {
        errors.value[field] = 'Please select a reservation time'
      } else {
        delete errors.value[field]
      }
      break

    case 'number_of_guests':
      if (!value) {
        errors.value[field] = 'Please enter the number of guests'
      } else if (value < 1) {
        errors.value[field] = 'Number of guests must be at least 1'
      } else if (value > 55) {
        errors.value[field] = 'Maximum 55 guests per reservation'
      } else {
        delete errors.value[field]
      }
      break

    case 'notes':
      if (value && value.length > 500) {
        errors.value[field] = 'Notes must not exceed 500 characters'
      } else {
        delete errors.value[field]
      }
      break
  }
}

const validateForm = () => {
  const fields = ['surname', 'phone_number', 'email', 'reservation_date', 'session', 'reservation_time', 'number_of_guests', 'notes']
  fields.forEach(field => validateField(field))
  return Object.keys(errors.value).length === 0
}

const submitReservation = () => {
  serverError.value = ''

  if (!validateForm()) return

  form.post('/reservations', {
    onError: (backendErrors) => {
      // Handle the fully booked error specifically
      if (backendErrors.number_of_guests) {
        serverError.value = backendErrors.number_of_guests
        errors.value.number_of_guests = backendErrors.number_of_guests
      } else {
        Object.assign(errors.value, backendErrors)
        serverError.value = 'An error occurred. Please try again.'
      }
    }
  })
}

const goHome = () => {
  window.location.href = '/'
}
</script>
