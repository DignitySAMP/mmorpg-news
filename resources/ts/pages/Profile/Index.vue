<template>
    <div>
        {{ usePage().props.user }}
        {{ usePage().props.comments }}
        {{ usePage().props.articles }}
    </div>
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

</script>