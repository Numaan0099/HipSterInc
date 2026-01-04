<script setup>
import { Head, router } from '@inertiajs/vue3'

const logout = () => {
    router.post('/admin/logout')
}
</script>

<template>
    <Head title="Admin Dashboard" />
    <h1>Admin Dashboard</h1>
    <button @click="logout">Logout</button>
</template>
