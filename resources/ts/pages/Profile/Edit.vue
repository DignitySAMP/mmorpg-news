<template>
    <AppTempLayout>
        <span class="font-bold">
            Personal Information
        </span>

        <div class="flex">
            <span class="text-sm opacity-50">
                Hint: all of these are optional and you do not need to choose any of these. Simply press 'reset' to hide them from your profile.
            </span>
        </div>
        <div class="flex flex-col">
            <span>Location:</span>
            <AppCountrySelector v-model="form.country" />
        </div>

        <div class="flex flex-col gap-1">
            <span>Choose your gender:</span>
            <select class="border" v-model="form.gender">
                <option value="male" v-html="'Male'"/>
                <option value="female" v-html="'Female'"/>
                <option value="other" v-html="'Other'"/>
                <option value="hidden" v-html="'Hidden'"/>
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <span>Date of Birth:</span>
            <input v-model="form.dob" type="date" class="border"/>
        </div>


        <span class="font-bold">
            Privacy Settings
        </span>

        <!--
            TODO: Add a way to hide country, gender, dob, ...
        -->

        <div class="flex gap-1">
            <input type="checkbox" v-model="form.privacy.online_status"/>
            <span class="text-sm">
                Show Online Status
            </span>
        </div>

        <div class="flex gap-1">
            <input type="checkbox" v-model="form.privacy.show_comments"/>
            <span class="text-sm">
                Show Comment Contributions
            </span>
        </div>

        <button @click="updateProfile" type="submit" class="border">
            Update Profile
        </button>
    </AppTempLayout>

</template>
<script setup lang="ts">
import AppCountrySelector from '@/components/AppCountrySelector.vue';
import AppTempLayout from '@/layouts/AppTempLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { edit } from '@/wayfinder/routes/profile';

// TODO: convert to <Form>? can utilise recentlySuccessful, ...
const form = useForm({
    country: usePage().props.auth?.profile_location,
    gender: usePage().props.auth?.profile_gender,
    dob:  usePage().props.auth?.profile_dob.toString().slice(0, 10) || '', // this returns 2018-01-01T00:00:00.000000Z but must be in format "2000-01-01",
    privacy: {
        online_status: usePage().props.auth?.profile_privacy_online_status,
        show_comments:  usePage().props.auth?.profile_privacy_comments,
    }
})

const updateProfile = () => {
    form.submit(edit());
}
</script>
