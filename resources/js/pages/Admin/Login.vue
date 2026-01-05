<script setup lang="ts">
import { ref } from 'vue'
import { Head, router, Link  } from '@inertiajs/vue3'
import axios from 'axios'

const form = ref({
    admin_email: '',
    password: ''
})

const errors = ref<Record<string, string>>({})
const loading = ref(false)

const submit = async () => {
    loading.value = true
    errors.value = {}

    try {
        await axios.post('/admin/login', {
            admin_email: form.value.admin_email,
            password: form.value.password,
        })

        router.visit('/admin/dashboard')

    } catch (error: any) {
        console.error(error);
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        } else if (error.response?.status === 401) {
            errors.value = { admin_email: 'Invalid credentials' }
        }
    } finally {
        loading.value = false
    }
}
</script>

<template>

    <Head title="Admin Login" />

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-sm" style="width: 100%; max-width: 420px;">
            <div class="card-body p-4">

                <h4 class="text-center mb-4">Admin Login</h4>

                <form @submit.prevent="submit">

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input v-model="form.admin_email" type="email" class="form-control"
                            :class="{ 'is-invalid': errors.admin_email }" placeholder="Enter email" />
                        <div class="invalid-feedback">
                            {{ errors.admin_email }}
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input v-model="form.password" type="password" class="form-control"
                            :class="{ 'is-invalid': errors.password }" placeholder="Enter password" />
                        <div class="invalid-feedback">
                            {{ errors.password }}
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" type="submit" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                            Login
                        </button>
                    </div>

                </form>
                <div class="text-center mt-3">
                    <small>
                        Don’t have an account?
                        <Link href="/admin/register" class="text-decoration-none fw-semibold">
                        Register here
                        </Link>
                    </small>
                </div>


            </div>
        </div>
    </div>
</template>
