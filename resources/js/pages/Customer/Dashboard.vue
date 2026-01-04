<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'

const logout = () => {
    router.post('/customer/logout')
}
</script>

<template>
    <Head title="Customer Dashboard" />
    <h1>Customer Dashboard</h1>
    <button @click="logout">Logout</button>
</template>
