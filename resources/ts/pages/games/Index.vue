<template>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Games</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
            <Link
                v-for="game in games"
                :key="game.id"
                :href="show(game.id).url"
                class="block bg-white border rounded shadow-sm hover:shadow-md transition p-3"
            >
                <img :src="game.thumbnail" class="w-full h-40 object-cover rounded" />

                <h2 class="text-lg font-semibold mt-3">{{ game.title }}</h2>

                <p class="text-sm text-gray-500 mt-1">
                    {{ game.short_description }}
                </p>
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Game } from '@/types/game';
import { show } from '@/wayfinder/routes/game';

defineProps<{
    games: Game[];
}>();
</script>