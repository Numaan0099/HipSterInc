<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import { Head } from '@inertiajs/vue3'

const file = ref<File | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)
const loading = ref(false)
const message = ref('')
const messageType = ref<'success' | 'error'>('success')

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement
    file.value = target.files && target.files.length > 0 ? target.files[0] : null
}

const submit = async () => {
    if (!file.value) {
        message.value = 'Please select a file'
        messageType.value = 'error'
        return
    }

    loading.value = true
    message.value = ''

    const formData = new FormData()
    formData.append('file', file.value)

    try {
        const res = await axios.post('/admin/products/import', formData)

        message.value = res.data.message || 'Import started successfully'
        messageType.value = 'success'

        file.value = null
        if (fileInput.value) {
            fileInput.value.value = ''
        }

    } catch (error) {
        console.error(error)
        message.value = 'Import failed. Please check file format.'
        messageType.value = 'error'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <Head title="Bulk Product Import" />

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-sm" style="max-width: 450px; width: 100%">
            <div class="card-body">

                <h4 class="mb-3 text-center">Bulk Product Import</h4>

                <input
                    ref="fileInput"
                    type="file"
                    class="form-control mb-3"
                    accept=".csv,.xlsx"
                    @change="handleFileChange"
                />

                <button
                    class="btn btn-primary w-100"
                    @click="submit"
                    :disabled="loading"
                >
                    <span
                        v-if="loading"
                        class="spinner-border spinner-border-sm me-2"
                    ></span>
                    {{ loading ? 'Importing...' : 'Import Products' }}
                </button>

                <div
                    v-if="message"
                    class="alert mt-3"
                    :class="messageType === 'success'
                        ? 'alert-success'
                        : 'alert-danger'"
                >
                    {{ message }}
                </div>

            </div>
        </div>
    </div>
</template>
