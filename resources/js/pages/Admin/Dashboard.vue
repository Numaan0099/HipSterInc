<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const onlineAdmins = ref([])
const onlineCustomers = ref([])

let channel = null

onMounted(() => {
    if (!window.Echo) return

    // 👑 Admin presence
    window.Echo.join('presence-admins')
        .here(users => onlineAdmins.value = users)
        .joining(user => {
            if (!onlineAdmins.value.some(u => u.id === user.id))
                onlineAdmins.value.push(user)
        })
        .leaving(user => {
            onlineAdmins.value =
                onlineAdmins.value.filter(u => u.id !== user.id)
        })

    // 👤 Customer presence
    window.Echo.join('presence-customers')
        .here(users => onlineCustomers.value = users)
        .joining(user => {
            if (!onlineCustomers.value.some(u => u.id === user.id))
                onlineCustomers.value.push(user)
        })
        .leaving(user => {
            onlineCustomers.value =
                onlineCustomers.value.filter(u => u.id !== user.id)
        })
})


onBeforeUnmount(() => {
  if (channel) window.Echo.leave('admins-channel')
})
</script>

<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <div class="row g-4">

      <!-- Admins -->
      <div class="col-md-6">
        <div class="bg-white p-4 rounded shadow-sm">
          <h5>Online Admins ({{ onlineAdmins.length }})</h5>
          <ul>
            <li v-for="a in onlineAdmins" :key="a.user_id">
              🔵 {{ a.name }}
            </li>
          </ul>
        </div>
      </div>

      <!-- Customers -->
      <div class="col-md-6">
        <div class="bg-white p-4 rounded shadow-sm">
          <h5>Online Customers ({{ onlineCustomers.length }})</h5>
          <ul>
            <li v-for="c in onlineCustomers" :key="c.user_id">
              🟢 {{ c.name }}
            </li>
          </ul>
        </div>
      </div>

    </div>
  </AdminLayout>
</template>
