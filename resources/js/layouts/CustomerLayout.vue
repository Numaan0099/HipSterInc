<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref } from 'vue'

type OnlineUser = {
    id: number
    name: string
}

const page = usePage()
const user = page.props.auth?.customer

const onlineCustomers = ref<OnlineUser[]>([])

onMounted(() => {
    if (!window.Echo) {
        console.error('Echo not found')
        return
    }

    window.Echo
        .join('presence-customers')
        .here((users: OnlineUser[]) => {
            console.log('HERE users:', users)
            onlineCustomers.value = users ?? []
        })
        .joining((user: OnlineUser) => {
            console.log('JOIN user:', user)
            if (!onlineCustomers.value.some(u => u.id === user.id)) {
                onlineCustomers.value.push(user)
            }
        })
        .leaving((user: OnlineUser) => {
            console.log('LEAVE user:', user)
            onlineCustomers.value =
                onlineCustomers.value.filter(u => u.id !== user.id)
        })
})

onUnmounted(() => {
    window.Echo?.leave('presence-customers')
})

const logout = () => {
    router.post('/customer/logout')
}
</script>


<template>
    <div>
        <!-- Navbar -->
        <nav class="navbar navbar-light bg-white border-bottom px-4">
            <span class="navbar-brand mb-0 h6">
                Customer Area
            </span>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="fw-semibold">{{ user?.name }}</div>
                    <small class="text-muted">{{ user?.email }}</small>
                </div>

                <button
                    @click="logout"
                    class="btn btn-outline-danger btn-sm"
                >
                    Logout
                </button>
            </div>
        </nav>

        <!-- Page -->
        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
