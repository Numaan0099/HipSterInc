<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive, watch } from 'vue'

const props = defineProps<{
    products: any
    filters: {
        search?: string
        category?: string
        stock?: string
    }
}>()

const filters = reactive({
    search: props.filters.search || '',
    category: props.filters.category || '',
    stock: props.filters.stock || '',
})

watch(filters, () => {
    setTimeout(() => {
        router.get('/admin/products', filters, {
            preserveState: true,
            replace: true,
        })
    }, 500)

})

const destroy = (id: number) => {
    if (confirm('Are you sure?')) {
        router.delete(`/admin/products/${id}`)
    }
}

const getImage = (image: string | null) => {
    return image && image.trim() !== '' ? image : '/default.png'
}
</script>


<template>

    <Head title="Products" />

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Products</h3>
            <Link href="/admin/imports" class="btn btn-outline-primary">
                View Imports
            </Link>
            <Link href="/admin/products/import" class="btn btn-outline-primary">
                Import Products
            </Link>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row g-2">

                            <!-- Search -->
                            <div class="col-md-4">
                                <input v-model="filters.search" type="text" class="form-control"
                                    placeholder="Search by product name..." />
                            </div>

                            <!-- Category -->
                            <div class="col-md-3">
                                <select v-model="filters.category" class="form-select">
                                    <option value="">All Categories</option>
                                    <option>Mobiles</option>
                                    <option>Laptops</option>
                                    <option>Accessories</option>
                                    <option>Electronics</option>
                                </select>
                            </div>

                            <!-- Stock -->
                            <div class="col-md-3">
                                <select v-model="filters.stock" class="form-select">
                                    <option value="">All Stock</option>
                                    <option value="in">In Stock</option>
                                    <option value="out">Out of Stock</option>
                                </select>
                            </div>

                            <!-- Reset -->
                            <div class="col-md-2">
                                <button class="btn btn-outline-secondary w-100" @click="() => {
                                    filters.search = ''
                                    filters.category = ''
                                    filters.stock = ''
                                }">
                                    Reset
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="product in products.data" :key="product.id">
                            <td>
                                <img :src="getImage(product.product_image)" alt="Product" width="50" height="50"
                                    class="rounded border"
                                    @error="($event.target as HTMLImageElement).src = '/default.png'" />
                            </td>
                            <td>{{ product.product_name }}</td>
                            <td>{{ product.product_category }}</td>
                            <td>₹ {{ product.product_price }}</td>
                            <td>
                                <span class="badge" :class="product.product_stock > 0
                                    ? 'bg-success'
                                    : 'bg-danger'">
                                    {{ product.product_stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </td>
                            <td>
                                <Link :href="`/admin/products/${product.product_id}/edit`"
                                    class="btn btn-sm btn-warning me-2">
                                    Edit
                                </Link>

                                <button class="btn btn-sm btn-danger" @click="destroy(product.product_id)">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="products.data.length === 0">
                            <td colspan="6" class="text-center py-4">
                                No products found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <li v-for="link in products.links" :key="link.label" class="page-item"
                        :class="{ active: link.active, disabled: !link.url }">
                        <Link class="page-link" v-html="link.label" :href="link.url || '#'" />
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
