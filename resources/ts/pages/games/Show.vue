<template>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">{{ game.title }}</h1>

        <img
            :src="game.thumbnail"
            :alt="game.title"
            class="w-full max-h-96 rounded object-cover mb-6"
        />

        <div class="text-gray-700 text-sm mb-4">
            <strong>Genre:</strong> {{ game.genre }}<br>
            <strong>Platform:</strong> {{ game.platform }}<br>
            <strong>Release:</strong> {{ game.release_date }}
        </div>

        <div class="prose max-w-none" v-html="game.description"></div>

        <h2 class="text-xl font-semibold mt-8 mb-3">Screenshots</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <img
                v-for="(shot, index) in game.screenshots"
                :key="index"
                :src="shot"
                class="rounded shadow object-cover"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Game } from '@/types/game';

defineProps<{
    game: Game;
}>();
</script>
