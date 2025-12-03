<template>
    <div class="flex flex-col gap-1">
        <span class="font-bold">
            {{ props.user.name }}
        </span>
        <div class="flex items-center gap-1" v-if="!props.user.profile_privacy_online_status">
            <div class="size-4 rounded-full" :class="props.user.status == 'Online' ? 'bg-green-500' : props.user.status == 'Away' ? 'bg-amber-500' : 'bg-red-500'"/>
            <span class="text-sm">{{ props.user.status }}</span>
        </div>
        <span v-else>
            Online status has been hidden.
        </span>
        <span>
            Registered on {{ new Date(props.user.created_at).toLocaleDateString() }}
        </span>

        <div class="flex gap-1">
            <span class="font-bold">
                Location:
            </span>
            <span>
                {{ props.user.profile_location }}
            </span>
        </div>

        <div class="flex gap-1">
            <span class="font-bold">
                Gender:
            </span>
            <span>
                {{ props.user.profile_gender }}
            </span>
        </div>

        <div class="flex gap-1">
            <span class="font-bold">
                Date of Birth:
            </span>
            <span>
                {{ props.user.profile_dob }}
            </span>
        </div>
    </div>
    <div class="flex flex-col" v-if="props.articles.data.length > 0 && !props.user.profile_privacy_articles">
        <span class="font-bold">Comments</span>
        <div v-for="comment, index in props.comments.data" :key="index" class="truncate">
            {{ new Date(comment.created_at).toLocaleDateString() }}
            {{ comment.text }}
        </div>
    </div>
    <span v-if="props.user.profile_privacy_articles">
        Articles have been made private by the user.
    </span>
    <div class="flex flex-col" v-if="props.articles.data.length > 0 && !props.user.profile_privacy_comments">

        <span class="font-bold">Articles</span>
    
        <div v-for="article, index in props.articles.data" :key="index">
            {{ new Date(article.created_at).toLocaleDateString() }}
            {{ article.title }}
        </div>
    </div>
    <span v-if="props.user.profile_privacy_comments">
        Comments have been made private by the user.
    </span>
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