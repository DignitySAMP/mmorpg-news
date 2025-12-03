<template>
    <AppTempLayout>
        <div class="flex justify-evenly gap-4 p-4">
            <select
                class="w-full rounded bg-white px-4 py-2 shadow"
                v-model="sortBy"
            >
                <option
                    v-for="(options, index) in sort_options"
                    :value="options.value"
                    v-html="options.label"
                    :key="index"
                />
            </select>
            <input
                class="w-full rounded bg-white px-4 py-2 shadow"
                type="text"
                v-model="search"
                placeholder="Enter title or description here"
            />

            <div class="flex w-full flex-col">
                <div class="flex w-full items-center gap-2">
                    <span class="text-sm">5</span>
                    <input
                        class="w-full"
                        type="range"
                        min="5"
                        :max="articles.total"
                        v-model="perPage"
                    />
                    <span class="text-sm">{{ articles.total }}</span>
                </div>
                <span class="text-center"> {{ perPage }} articles shown </span>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 p-4">
            <div v-for="(article, index) in articles.data" :key="index">
                <img v-if="article.banner" :src="article.banner" />
                <span class="font-bold">{{ article.title }}</span>
                <p v-html="article.content" class="truncate" />
                <span> {{ article.read_time }} minutes of reading time </span>
                <span v-if="article.comments_count">
                    {{ article.comments_count }} comment(s)
                </span>
            </div>
        </div>
    </AppTempLayout>
</template>

<script setup lang="ts">
import AppTempLayout from '@/layouts/AppTempLayout.vue';
import { type Article } from '@/types/article';
import { index } from '@/wayfinder/routes/article';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';

interface WelcomePageProps {
    articles: {
        data: Article[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
    filters: {
        sort_by: string;
        per_page: number;
        search: string;
    };
    sort_options: {
        value: string;
        label: string;
    }[];
}

const props = defineProps<WelcomePageProps>();

// local models for search filtering
const sortBy = ref(props.filters.sort_by);
const search = ref(props.filters.search);
const perPage = ref(props.filters.per_page);

// fetch results from article.index based on filter parameters
const onFilterArticles = () => {
    router.get(
        index(),
        {
            search: search.value,
            sort_by: sortBy.value,
            per_page: perPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};
watch([sortBy, perPage], () => onFilterArticles()); // sortby and perpage should be instanteneous for good user UX
const debouncedSearch = debounce(() => onFilterArticles(), 300); //  create a debounce instance for input strings
watch(search, () => debouncedSearch()); // debounce all input strings by 300-500ms for performance
</script>
