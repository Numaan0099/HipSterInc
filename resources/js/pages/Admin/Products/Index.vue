<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'

defineProps<{
    products: {
        data: any[]
        links: any[]
    }
}>()

const getImage = (image: string | null) => {
    return image
        ? `${image}`
        : '/default.png'
}
</script>

<template>

    <Head title="Products" />

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Products</h3>

            <Link href="/admin/products/import" class="btn btn-outline-primary">
                Import Products
            </Link>
        </div>

        <!-- Products Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
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
                        </tr>

                        <tr v-if="products.data.length === 0">
                            <td colspan="5" class="text-center py-4">
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
