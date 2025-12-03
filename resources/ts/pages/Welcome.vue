<template>
    <main>
        <select v-model="sortOption">
            <option v-for="options in sort_options" :value="options.value" v-html="options.label"/>
        </select>
        <div class="grid grid-cols-4 gap-4">
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
    </main>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { type Article } from '@/types/article'


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
        };
        sort_options: {
            value: string;
            label: string;
        }[];
    }

    const props = defineProps<WelcomePageProps>();
    const sortOption = ref<string>(props.sort_options[0].value);

</script>
