<template>
    <AppTempLayout>
        <div class="flex flex-col gap-1">
            <span class="font-bold"> Personal Information </span>

            <div class="flex">
                <span class="text-sm opacity-50">
                    Hint: all of these are optional and you do not need to
                    choose any of these. Simply press 'reset' to hide them from
                    your profile.
                </span>
            </div>
            <div class="flex flex-col">
                <span>Location:</span>
                <AppCountrySelector v-model="form.country" />
                <span
                    class="cursor-pointer text-sm text-red-500 underline"
                    @click="form.country = ''"
                    >Reset country</span
                >
            </div>

            <div class="flex flex-col gap-1">
                <span>Choose your gender:</span>
                <select class="border" v-model="form.gender">
                    <option value="male" v-html="'Male'" />
                    <option value="female" v-html="'Female'" />
                    <option value="other" v-html="'Other'" />
                    <option value="hidden" v-html="'Hidden'" />
                </select>
                <span
                    class="cursor-pointer text-sm text-red-500 underline"
                    @click="form.gender = 'hidden'"
                    >Reset gender</span
                >
            </div>

            <div class="flex flex-col gap-1">
                <span>Date of Birth:</span>
                <input v-model="form.dob" type="date" class="border" />
                <span
                    class="cursor-pointer text-sm text-red-500 underline"
                    @click="form.dob = null"
                    >Reset date of birth</span
                >
            </div>

            <span class="font-bold"> Privacy Settings </span>

            <div class="flex gap-1">
                <input type="checkbox" v-model="form.privacy.show_profile" />
                <span class="text-sm"> Show Profile </span>
            </div>

            <div class="flex gap-1">
                <input type="checkbox" v-model="form.privacy.online_status" />
                <span class="text-sm"> Show Online Status </span>
            </div>

            <div class="flex gap-1">
                <input type="checkbox" v-model="form.privacy.show_comments" />
                <span class="text-sm"> Show Comment Contributions </span>
            </div>

            <button @click="updateProfile" type="submit" class="border">
                Update Profile
            </button>
        </div>
    </AppTempLayout>
</template>
<script setup lang="ts">
import AppCountrySelector from '@/components/AppCountrySelector.vue';
import AppTempLayout from '@/layouts/AppTempLayout.vue';
import { User } from '@/types/user';
import { edit } from '@/wayfinder/routes/profile';
import { useForm } from '@inertiajs/vue3';

interface InertiaProps {
    user: User;
}
const props = defineProps<InertiaProps>();

// TODO: convert to <Form>? can utilise recentlySuccessful, ...
const form = useForm({
    country: props.user?.profile?.location ?? '',
    gender: props.user?.profile?.gender,
    dob: props.user?.profile?.date_of_birth?.toString().slice(0, 10) ?? null,
    privacy: {
        show_profile: props.user?.profile?.show_profile ?? true,
        online_status: props.user?.profile?.show_online_status ?? true,
        show_comments: props.user?.profile?.show_comments ?? true,
    },
});

const updateProfile = () => {
    form.submit(edit());
};
</script>
