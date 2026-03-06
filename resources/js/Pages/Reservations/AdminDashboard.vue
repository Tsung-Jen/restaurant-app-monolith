<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Restaurant Reservation Management</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-sm font-semibold text-gray-600 uppercase">Total Reservations</h3>
              <p class="text-3xl font-bold text-blue-600 mt-2">{{ totalReservations }}</p>
            </div>
          </div>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-sm font-semibold text-gray-600 uppercase">Pending</h3>
              <p class="text-3xl font-bold text-yellow-600 mt-2">{{ pendingCount }}</p>
            </div>
          </div>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-sm font-semibold text-gray-600 uppercase">Confirmed</h3>
              <p class="text-3xl font-bold text-green-600 mt-2">{{ confirmedCount }}</p>
            </div>
          </div>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-sm font-semibold text-gray-600 uppercase">Capacity Today</h3>
              <p class="text-3xl font-bold text-purple-600 mt-2">{{ todayCapacity }}%</p>
            </div>
          </div>
        </div>

        <!-- Controls -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
          <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Reservation Calendar</h3>
                <p class="text-gray-500 mt-1">{{ monthYear }}</p>
              </div>
              <div class="flex gap-2">
                <button @click="previousMonth" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium">← Previous</button>
                <button @click="goToToday" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">Today</button>
                <button @click="nextMonth" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium">Next →</button>
              </div>
            </div>
          </div>

          <!-- Calendar Grid -->
          <div class="p-6">
            <div class="overflow-x-auto">
              <table class="w-full border-collapse">
                <thead>
                  <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-3 text-left text-sm font-semibold">Sun</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Mon</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tue</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Wed</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Thu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Fri</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Sat</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(week, idx) in calendarDays" :key="idx">
                    <td v-for="(day, dayIdx) in week" :key="dayIdx" class="border border-gray-200 p-2 h-40 align-start bg-gray-50 hover:bg-blue-50 cursor-pointer transition"
                      @click="day.date !== null && selectDate(day.date)">
                      <div v-if="day.date !== null" class="h-full flex flex-col">
                        <div class="text-lg font-bold mb-2" :class="{ 'text-gray-400': !day.isCurrentMonth }">
                          {{ day.day }}
                        </div>
                        <div v-if="day.isCurrentMonth" class="text-xs space-y-1 flex-1">
                          <!-- Lunch Session -->
                          <div :class="[
                            'px-2 py-1 rounded',
                            day.lunchTotal >= 55 ? 'bg-red-200 text-red-800 font-semibold' : 'bg-green-100 text-green-800'
                          ]">
                            Lunch: {{ day.lunchTotal }}/55
                          </div>
                          <!-- Dinner Session -->
                          <div :class="[
                            'px-2 py-1 rounded',
                            day.dinnerTotal >= 55 ? 'bg-red-200 text-red-800 font-semibold' : 'bg-green-100 text-green-800'
                          ]">
                            Dinner: {{ day.dinnerTotal }}/55
                          </div>
                          <!-- Reservation count -->
                          <div v-if="day.reservationCount > 0" class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                            {{ day.reservationCount }} reservation(s)
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Reservations List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">All Reservations</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-100 border-b">
                <tr>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Guest</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Phone</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Time</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Session</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Guests</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="res in sortedReservations" :key="res.id" class="border-b hover:bg-gray-50">
                  <td class="px-6 py-4 font-medium">{{ res.surname }}</td>
                  <td class="px-6 py-4">{{ res.phone_number }}</td>
                  <td class="px-6 py-4">{{ formatDate(res.reservation_date) }}</td>
                  <td class="px-6 py-4">{{ res.reservation_time }}</td>
                  <td class="px-6 py-4 capitalize">{{ res.session }}</td>
                  <td class="px-6 py-4">{{ res.number_of_guests }}</td>
                  <td class="px-6 py-4">
                    <span :class="[
                      'px-3 py-1 rounded-full text-xs font-semibold',
                      res.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                      res.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                      'bg-red-100 text-red-800'
                    ]">
                      {{ res.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 space-x-2">
                    <button @click="confirmReservation(res)" v-if="res.status !== 'confirmed'" class="text-green-600 hover:text-green-800 font-semibold text-sm">Confirm</button>
                    <button @click="viewDetails(res)" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">View</button>
                    <button @click="deleteReservation(res)" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Details Modal -->
    <Teleport to="body" v-if="selectedReservation">
      <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Reservation Details</h2>
            <button @click="selectedReservation = null" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
          </div>

          <div class="space-y-4 mb-6">
            <div class="border-b pb-4">
              <p class="text-gray-600 text-sm">Guest Name</p>
              <p class="text-lg font-semibold">{{ selectedReservation.surname }}</p>
            </div>
            <div class="border-b pb-4">
              <p class="text-gray-600 text-sm">Phone</p>
              <p class="text-lg">{{ selectedReservation.phone_number }}</p>
            </div>
            <div v-if="selectedReservation.email" class="border-b pb-4">
              <p class="text-gray-600 text-sm">Email</p>
              <p class="text-lg">{{ selectedReservation.email }}</p>
            </div>
            <div class="border-b pb-4">
              <p class="text-gray-600 text-sm">Date & Time</p>
              <p class="text-lg">{{ formatDate(selectedReservation.reservation_date) }} at {{ selectedReservation.reservation_time }}</p>
            </div>
            <div class="border-b pb-4">
              <p class="text-gray-600 text-sm">Session</p>
              <p class="text-lg capitalize">{{ selectedReservation.session }}</p>
            </div>
            <div class="border-b pb-4">
              <p class="text-gray-600 text-sm">Number of Guests</p>
              <p class="text-lg">{{ selectedReservation.number_of_guests }}</p>
            </div>
            <div v-if="selectedReservation.notes" class="border-b pb-4">
              <p class="text-gray-600 text-sm">Special Requests</p>
              <p class="text-lg">{{ selectedReservation.notes }}</p>
            </div>
            <div>
              <p class="text-gray-600 text-sm">Status</p>
              <p :class="[
                'text-lg font-semibold capitalize',
                selectedReservation.status === 'confirmed' ? 'text-green-600' :
                selectedReservation.status === 'pending' ? 'text-yellow-600' :
                'text-red-600'
              ]">{{ selectedReservation.status }}</p>
            </div>
          </div>

          <div class="flex gap-3">
            <button v-if="selectedReservation.status !== 'confirmed'" @click="confirmReservation(selectedReservation)" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg">
              Confirm
            </button>
            <button @click="deleteReservation(selectedReservation)" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg">
              Delete
            </button>
            <button @click="selectedReservation = null" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 rounded-lg">
              Close
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  reservations: {
    type: Array,
    required: true
  }
})

let currentMonth = ref(new Date().getMonth() + 1)
let currentYear = ref(new Date().getFullYear())
let reservationsList = ref(props.reservations)
let selectedReservation = ref(null)

const monthYear = computed(() => {
  const date = new Date(currentYear.value, currentMonth.value - 1)
  return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
})

const totalReservations = computed(() => reservationsList.value.length)
const pendingCount = computed(() => reservationsList.value.filter(r => r.status === 'pending').length)
const confirmedCount = computed(() => reservationsList.value.filter(r => r.status === 'confirmed').length)

const todayCapacity = computed(() => {
  const today = new Date().toISOString().split('T')[0]
  const todayRes = reservationsList.value.filter(r => r.reservation_date === today && r.status !== 'cancelled')
  const total = todayRes.reduce((sum, r) => sum + r.number_of_guests, 0)
  return Math.round((total / 110) * 100)
})

const sortedReservations = computed(() => {
  return [...reservationsList.value].sort((a, b) => {
    const dateA = new Date(a.reservation_date + ' ' + a.reservation_time)
    const dateB = new Date(b.reservation_date + ' ' + b.reservation_time)
    return dateB - dateA
  })
})

const calendarDays = computed(() => {
  const firstDay = new Date(currentYear.value, currentMonth.value - 1, 1)
  const lastDay = new Date(currentYear.value, currentMonth.value, 0)
  const startDate = new Date(firstDay)
  startDate.setDate(startDate.getDate() - firstDay.getDay())

  const weeks = []
  let currentDate = new Date(startDate)

  while (weeks.length < 6) {
    const week = []
    for (let i = 0; i < 7; i++) {
      const dateStr = currentDate.toISOString().split('T')[0]
      const isCurrentMonth = currentDate.getMonth() === firstDay.getMonth()

      const dayReservations = reservationsList.value.filter(r => r.reservation_date === dateStr && r.status !== 'cancelled')
      const lunchTotal = dayReservations
        .filter(r => r.session === 'lunch')
        .reduce((sum, r) => sum + r.number_of_guests, 0)
      const dinnerTotal = dayReservations
        .filter(r => r.session === 'dinner')
        .reduce((sum, r) => sum + r.number_of_guests, 0)

      week.push({
        date: dateStr,
        day: currentDate.getDate(),
        isCurrentMonth,
        lunchTotal,
        dinnerTotal,
        reservationCount: dayReservations.length
      })

      currentDate.setDate(currentDate.getDate() + 1)
    }
    weeks.push(week)
  }

  return weeks
})

const formatDate = (dateStr) => {
  return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}

const previousMonth = () => {
  if (currentMonth.value === 1) {
    currentMonth.value = 12
    currentYear.value--
  } else {
    currentMonth.value--
  }
}

const nextMonth = () => {
  if (currentMonth.value === 12) {
    currentMonth.value = 1
    currentYear.value++
  } else {
    currentMonth.value++
  }
}

const goToToday = () => {
  const today = new Date()
  currentMonth.value = today.getMonth() + 1
  currentYear.value = today.getFullYear()
}

const selectDate = (date) => {
  const dayReservations = reservationsList.value.filter(r => r.reservation_date === date && r.status !== 'cancelled')
  if (dayReservations.length > 0) {
    selectedReservation.value = dayReservations[0]
  }
}

const viewDetails = (reservation) => {
  selectedReservation.value = reservation
}

const confirmReservation = async (reservation) => {
  try {
    const response = await fetch(`/reservations/${reservation.id}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
      },
      body: JSON.stringify({ status: 'confirmed' })
    })

    if (response.ok) {
      const index = reservationsList.value.findIndex(r => r.id === reservation.id)
      if (index !== -1) {
        reservationsList.value[index].status = 'confirmed'
        selectedReservation.value = null
      }
      alert('Reservation confirmed successfully!')
    } else {
      alert('Error confirming reservation')
    }
  } catch (error) {
    alert('Error: ' + error.message)
  }
}

const deleteReservation = async (reservation) => {
  if (!confirm('Are you sure you want to delete this reservation?')) return

  try {
    const response = await fetch(`/reservations/${reservation.id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
      }
    })

    if (response.ok) {
      reservationsList.value = reservationsList.value.filter(r => r.id !== reservation.id)
      selectedReservation.value = null
      alert('Reservation deleted successfully!')
    } else {
      alert('Error deleting reservation')
    }
  } catch (error) {
    alert('Error: ' + error.message)
  }
}
</script>
