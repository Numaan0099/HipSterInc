<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import CustomerLayout from '@/Layouts/CustomerLayout.vue'

defineOptions({
    layout: CustomerLayout,
})
</script>

<template>
    <Head title="Customer Dashboard" />

    <div class="container mt-4">
        <h3>Welcome to Customer Dashboard</h3>
    </div>
</template>
