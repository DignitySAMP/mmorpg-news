<template>
    <div class="flex gap-4">
        <Link :href="update().url" as="button" class="w-full border">
            Change Profile
        </Link>
        <Link :href="account().url" as="button" class="w-full border">
            Change Account Details
        </Link>
        <Link :href="password().url" as="button" class="w-full border">
            Change Password
        </Link>
    </div>

    <div class="flex flex-col gap-1">
        <span class="font-bold">
            {{ props.user.name }}
        </span>

        <div class="flex gap-1">
            <span class="font-bold"> Profile Status: </span>
            <span>
                {{ props.user.profile?.show_profile ? 'Public' : 'Private' }}
            </span>
        </div>
        <div class="flex gap-1">
            <span class="font-bold"> Online Status: </span>
            <span>
                {{
                    props.user.profile?.show_online_status
                        ? 'Public'
                        : 'Private'
                }}
            </span>
        </div>

        <span>
            Registered on
            {{ new Date(props.user.created_at).toLocaleDateString() }}
        </span>

        <div class="flex gap-1">
            <span class="font-bold"> Location: </span>
            <span>
                {{ props.user.profile?.location ?? 'No country selected' }}
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
            <span
                v-if="props.user.profile && props.user.profile?.date_of_birth"
            >
                {{ new Date(props.user.profile.date_of_birth).toDateString() }}
            </span>
            <span v-else>No date of birth selected</span>
            <span v-if="props.user.profile?.age !== null" class="text-xs">
                ({{ props.user.profile?.age }} years old)
            </span>
        </div>

        <div class="flex flex-col" v-if="props.comments.data.length > 0">
            <div class="flex gap-1">
                <span class="font-bold">Your Contributions</span>
                <span class="text-xs"
                    >({{
                        props.user.profile?.show_comments
                            ? 'public'
                            : 'private'
                    }})</span
                >
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
    </div>
</template>
<script setup lang="ts">
import { ArticleComment } from '@/types/article';
import { User } from '@/types/user';
import { account, password, update } from '@/wayfinder/routes/profile';
import { Link } from '@inertiajs/vue3';
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
