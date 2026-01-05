<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ product: any }>()

const form = ref({ ...props.product })

const submit = () => {
    router.put(`/admin/products/${form.value.product_id}`, form.value)
}
</script>

<template>
    <Head title="Edit Product" />

    <div class="container mt-4">
        <h3>Edit Product</h3>

        <form @submit.prevent="submit" class="mt-3">
            <input v-model="form.product_name" class="form-control mb-2" />
            <input v-model="form.product_category" class="form-control mb-2" />
            <input v-model="form.product_price" type="number" class="form-control mb-2" />
            <input v-model="form.product_stock" type="number" class="form-control mb-2" />
            <input v-model="form.product_image" class="form-control mb-2" />
            <textarea v-model="form.product_description" class="form-control mb-3"></textarea>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</template>
