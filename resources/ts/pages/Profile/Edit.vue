<template>
    <span> Edit location, dob, gender, privacy, ... </span>

    <div class="w-lg">
        <AppCountrySelector v-model="country" />
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import AppCountrySelector from '@/components/AppCountrySelector.vue';

const country = ref<string>("");
</script>
