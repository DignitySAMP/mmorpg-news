<template>
    <div>
        {{ usePage().props.user }}
        {{ usePage().props.comments }}
    </div>
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
// TODO: Add links to 'edit your account details', 'edit your password', 'edit your profile'
</script>
