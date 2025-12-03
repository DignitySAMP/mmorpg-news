<template>
    <main
        class="container mx-auto min-h-screen max-w-4xl divide-y divide-neutral-300 bg-neutral-100 px-4 py-2 text-neutral-700"
    >
        <div v-if="user !== null && user.email_verified_at === null">
            You have not verified your e-mail yet. The application will be
            locked until you do so.
        </div>

        <slot />
    </main>
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.auth ?? null;
</script>
