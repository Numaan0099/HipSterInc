<script setup lang="ts">
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import axios from 'axios'

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const errors = ref<Record<string, string>>({})
const loading = ref(false)

const submit = async () => {
    loading.value = true
    errors.value = {}

    try {
        await axios.post('/customer/register', form.value)
        router.visit('/customer/login')
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        }
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <Head title="Customer Register" />

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-sm" style="max-width: 420px; width:100%">
            <div class="card-body p-4">
                <h4 class="text-center mb-4">Customer Registration</h4>

                <form @submit.prevent="submit">
                    <input class="form-control mb-3" v-model="form.name" placeholder="Name" />
                    <div class="text-danger">{{ errors.name }}</div>

                    <input class="form-control mb-3" v-model="form.email" placeholder="Email" />
                    <div class="text-danger">{{ errors.email }}</div>

                    <input class="form-control mb-3" type="password" v-model="form.password" placeholder="Password" />
                    <div class="text-danger">{{ errors.password }}</div>

                    <input class="form-control mb-3" type="password" v-model="form.password_confirmation" placeholder="Confirm Password" />

                    <button class="btn btn-success w-100" :disabled="loading">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
