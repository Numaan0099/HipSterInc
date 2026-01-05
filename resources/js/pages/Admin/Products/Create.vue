<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = ref({
    product_name: '',
    product_price: '',
    product_category: '',
    product_stock: '',
    product_description: '',
    product_image: '',
})

const submit = () => {
    router.post('/admin/products', form.value)
}
</script>

<template>
    <Head title="Create Product" />

    <div class="container mt-4">
        <h3>Add Product</h3>

        <form @submit.prevent="submit" class="mt-3">
            <input v-model="form.product_name" class="form-control mb-2" placeholder="Name" />
            <input v-model="form.product_category" class="form-control mb-2" placeholder="Category" />
            <input v-model="form.product_price" type="number" class="form-control mb-2" placeholder="Price" />
            <input v-model="form.product_stock" type="number" class="form-control mb-2" placeholder="Stock" />
            <input v-model="form.product_image" class="form-control mb-2" placeholder="Image URL" />
            <textarea v-model="form.product_description" class="form-control mb-3" placeholder="Description"></textarea>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</template>
