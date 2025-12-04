<template>
    <span class="font-bold">
        {{ props.user.name }}
    </span>

    <div v-if="!props.user.profile?.show_profile">
        <span>
            This profile is hidden.
        </span>
    </div>
    <div v-else class="flex flex-col gap-1">

        <div
            class="flex items-center gap-1"
            v-if="props.user.profile?.show_online_status"
        >
            <div
                class="size-4 rounded-full"
                :class="
                    props.user.status == 'Online'
                        ? 'bg-green-500'
                        : props.user.status == 'Away'
                          ? 'bg-amber-500'
                          : 'bg-red-500'
                "
            />
            <span class="text-sm">{{ props.user.status }}</span>
        </div>
        <span v-else> Online status has been hidden. </span>
        <span>
            Registered on
            {{ new Date(props.user.created_at).toLocaleDateString() }}
        </span>

        <div class="flex gap-1">
            <span class="font-bold"> Location: </span>
            <span>
                {{ props.user.profile?.location ?? 'Hidden'}}
            </span>
        </div>

        <div class="flex gap-1">
            <span class="font-bold"> Gender: </span>
            <span>
                {{ props.user.profile?.gender }}
            </span>
        </div>

        <div class="flex gap-1">
            <span class="font-bold"> Date of Birth: </span>
            <span v-if="props.user.profile && props.user.profile?.date_of_birth">
                {{ new Date(props.user.profile.date_of_birth).toDateString() }}
            </span>
            <span v-else>Hidden</span>
            <span v-if="props.user.profile?.age !== null" class="text-xs">
                ({{ props.user.profile?.age }} years old)
            </span>
        </div>
    </div>
    <div v-if="props.user.profile?.show_comments">
        <div class="flex flex-col" v-if="props.comments.data.length > 0">
            <div class="flex gap-1">
                <span class="font-bold">Contributions</span>
            </div>
            <div
                v-for="(comment, index) in props.comments.data"
                :key="index"
                class="truncate"
            >
                {{ new Date(comment.created_at).toLocaleDateString() }}
                {{ comment.text }}
            </div>
        </div>
        <span v-else>
            There are no comments to show.
        </span>
    </div>
    <span v-else>Comments are hidden.</span>
</template>
<script setup lang="ts">
import { ArticleComment } from '@/types/article';
import { User } from '@/types/user';
interface InertiaProps {
    user: User;
    comments: {
        data: ArticleComment[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
}
const props = defineProps<InertiaProps>();
</script>
