<template>
    <div class="flex gap-4">
        <Link :href="info().url" as="button" class="w-full border">
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

        <span>
            Registered on
            {{ new Date(props.user.created_at).toLocaleDateString() }}
        </span>

        <div class="flex gap-1">
            <span class="font-bold"> Location: </span>
            <span>
                {{ props.user.profile_location }}
            </span>
        </div>

        <div class="flex gap-1">
            <span class="font-bold"> Gender: </span>
            <span>
                {{ props.user.profile_gender }}
            </span>
        </div>

        <div class="flex gap-1">
            <span class="font-bold"> Date of Birth: </span>
            <span>
                {{ new Date(props.user.profile_dob).toLocaleDateString() }}
            </span>
            <span v-if="props.user.age !== null" class="text-xs">
                ({{ props.user.age }} years old)
            </span>
        </div>

        <div class="flex flex-col" v-if="props.comments.data.length > 0">
            <span class="font-bold">Your Comments</span>
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
import { account, info, password } from '@/wayfinder/routes/profile';
import { Link } from '@inertiajs/vue3';
// TODO: Add links to 'edit your account details', 'edit your password', 'edit your profile'
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
