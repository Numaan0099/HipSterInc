<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()
const admin = page.props.auth?.admin

const logout = () => {
    router.post('/admin/logout')
}
</script>

<template>
    <div>
        <!-- Navbar -->
        <nav class="navbar navbar-light bg-white border-bottom px-4">
            <span class="navbar-brand mb-0 h6">
                Admin Area
            </span>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="fw-semibold">{{ admin?.name }}</div>
                    <small class="text-muted">{{ admin?.email }}</small>
                </div>

                <button
                    @click="logout"
                    class="btn btn-outline-danger btn-sm"
                >
                    Logout
                </button>
            </div>
        </nav>

        <!-- Page -->
        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
