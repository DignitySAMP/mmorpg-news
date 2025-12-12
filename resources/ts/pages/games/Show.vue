<template>
    <div class="mx-auto max-w-4xl p-6">
        <h1 class="mb-4 text-3xl font-bold">{{ game.title }}</h1>

        <img
            :src="game.thumbnail"
            :alt="game.title"
            class="mb-6 max-h-96 w-full rounded object-cover"
        />

        <div class="mb-4 text-sm text-gray-700">
            <strong>Genre:</strong> {{ game.genre }}<br />
            <strong>Platform:</strong> {{ game.platform }}<br />
            <strong>Release:</strong> {{ game.release_date }}
        </div>

        <div class="prose max-w-none" v-html="game.description"></div>

        <h2 class="mt-8 mb-3 text-xl font-semibold">Screenshots</h2>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
            <img
                v-for="(shot, index) in game.screenshots"
                :key="index"
                :src="shot"
                class="rounded object-cover shadow"
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
