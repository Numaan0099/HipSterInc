<script setup lang="ts">
import { Head, Link  } from '@inertiajs/vue3'

defineProps<{
    imports: {
        data: any[]
        links: any[]
    }
}>()

const statusClass = (status: string) => {
    switch (status) {
        case 'completed':
            return 'bg-success'
        case 'processing':
            return 'bg-warning'
        case 'failed':
            return 'bg-danger'
        default:
            return 'bg-secondary'
    }
}
</script>

<template>

    <Head title="Imports" />

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Import History</h3>

            <Link href="/admin/products" class="btn btn-outline-primary">
            View Products
            </Link>
        </div>


        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Processed</th>
                            <th>Failed</th>
                            <th>Started At</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="imp in imports.data" :key="imp.import_id">
                            <td>{{ imp.import_id }}</td>
                            <td class="text-capitalize">{{ imp.type }}</td>
                            <td>
                                <span class="badge" :class="statusClass(imp.status)">
                                    {{ imp.status }}
                                </span>
                            </td>
                            <td>{{ imp.processed_rows }}</td>
                            <td>
                                <span v-if="imp.failed_rows > 0" class="text-danger fw-bold">
                                    {{ imp.failed_rows }}
                                </span>
                                <span v-else>0</span>
                            </td>
                            <td>{{ new Date(imp.created_at).toLocaleString() }}</td>
                        </tr>

                        <tr v-if="imports.data.length === 0">
                            <td colspan="6" class="text-center py-4">
                                No imports found
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
                    <li v-for="link in imports.links" :key="link.label" class="page-item"
                        :class="{ active: link.active, disabled: !link.url }">
                        <a class="page-link" v-html="link.label" :href="link.url || '#'" />
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
