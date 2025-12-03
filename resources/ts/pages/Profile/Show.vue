<template>
    <span class="font-bold">
        {{ props.user.name }}
    </span>

    <span>
        Registered on {{ new Date(props.user.created_at).toLocaleDateString() }}
    </span>

    <div class="flex flex-col" v-if="props.articles.data.length > 0">
        <span class="font-bold">Comments</span>
        <div v-for="comment, index in props.comments.data" :key="index" class="truncate">
            {{ new Date(comment.created_at).toLocaleDateString() }}
            {{ comment.text }}
        </div>
    </div>
    <div class="flex flex-col" v-if="props.articles.data.length > 0">

        <span class="font-bold">Articles</span>
    
        <div v-for="article, index in props.articles.data" :key="index">
            {{ new Date(article.created_at).toLocaleDateString() }}
            {{ article.title }}
        </div>
    </div>
    
</template>
<script setup lang="ts">
    import { Article, ArticleComment } from '@/types/article';
    import { User } from '@/types/user';

    interface InertiaProps {
        user: User,
        comments: {
            data: ArticleComment[],
            current_page: number;
            last_page: number;
            per_page: number;
            total: number;
            from: number;
            to: number;
        },
        articles: {
            data: Article[],
            current_page: number;
            last_page: number;
            per_page: number;
            total: number;
            from: number;
            to: number;
        }
    }
    const props = defineProps<InertiaProps>();
</script>