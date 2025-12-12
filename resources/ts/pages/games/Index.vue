<template>
    <div class="p-6">
        <h1 class="mb-6 text-3xl font-bold">Games</h1>

        <div
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <Link
                v-for="game in games"
                :key="game.id"
                :href="show(game.id).url"
                class="block rounded border bg-white p-3 shadow-sm transition hover:shadow-md"
            >
                <img
                    :src="game.thumbnail"
                    class="h-40 w-full rounded object-cover"
                />

                <h2 class="mt-3 text-lg font-semibold">{{ game.title }}</h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ game.short_description }}
                </p>
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Game } from '@/types/game';
import { show } from '@/wayfinder/routes/game';
import { Link } from '@inertiajs/vue3';

defineProps<{
    games: Game[];
}>();
</script>
