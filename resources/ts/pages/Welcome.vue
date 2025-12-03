<template>
    <AppTempLayout>
        <div class="flex gap-4 justify-evenly p-4">
            <select class="bg-white px-4 py-2 rounded shadow w-full" v-model="sortBy">
                <option v-for="options in sort_options" :value="options.value" v-html="options.label"/>
            </select>
            <input class="bg-white px-4 py-2 rounded shadow w-full" type="text" v-model="search" placeholder="Enter title or description here"/>
            
            <div class="flex flex-col w-full">
                <div class="w-full flex gap-2 items-center">
                    <span class="text-sm">5</span>
                    <input class="w-full" type="range" min="5" :max="articles.total" v-model="perPage"/>
                    <span class="text-sm">{{ articles.total }}</span>
                </div>
                <span class="text-center">
                    {{ perPage }} articles shown
                </span>
            </div>
        </div>
        <div class="p-4 grid grid-cols-3 gap-4">
            <div v-for="article in articles.data">
                <img v-if="article.banner" :src="article.banner"/>
                <span class="font-bold">{{ article.title }}</span>
                <p v-html="article.content" class="truncate"/>
                <span>
                    {{ article.read_time }} minutes of reading time
                </span>
                <span v-if="article.comments_count">
                    {{ article.comments_count }} comment(s)
                </span>
            </div>

        </div>
    </AppTempLayout>
</template>

<script setup lang="ts">
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { debounce } from 'lodash';
    import { index } from '@/wayfinder/routes/article';
    import { type Article } from '@/types/article'
    import AppTempLayout from '@/layouts/AppTempLayout.vue';


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
        router.get(index(), {
            search: search.value,
            sort_by: sortBy.value,
            per_page: perPage.value,
        }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }
    watch([sortBy, perPage], () => onFilterArticles()); // sortby and perpage should be instanteneous for good user UX
    const debouncedSearch = debounce(() => onFilterArticles(), 300); //  create a debounce instance for input strings
    watch(search, () => debouncedSearch()); // debounce all input strings by 300-500ms for performance



</script>
