<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3'
import { update } from '@/wayfinder/routes/user-profile-information'
import { ref } from 'vue';

const name = ref(usePage().props.auth?.name);
const email = ref(usePage().props.auth?.email);

interface UpdateProfileErrorBag {
    updateProfileInformation?: {
        name?: string[]
        email?: string[]
    }
}
</script>

<template>
    <Form :action="update()">
        <template
            #default="{
                errors,
                hasErrors,
                processing,
                wasSuccessful
            }: {
                errors: UpdateProfileErrorBag,
                hasErrors: boolean,
                processing: boolean,
                wasSuccessful: boolean
            }"
        >
            <span v-if="wasSuccessful">
                You have successfully updated your profile.
            </span>
            <div class="flex flex-col gap-1">
            <label for="name">Name</label>
            <input 
                class="border" 
                type="text" 
                name="name" 
                v-model="name"
                autocomplete="name"
            />
            <span
                v-if="hasErrors && errors.updateProfileInformation?.name"
                v-html="errors.updateProfileInformation?.name"
            />
            </div>

            <div class="flex flex-col gap-1">
            <label for="email">Email</label>
            <input 
                class="border" 
                type="email" 
                name="email" 
                v-model="email"
                autocomplete="email"
            />
            <span
                v-if="hasErrors && errors.updateProfileInformation?.email"
                v-html="errors.updateProfileInformation?.email"
            />
            </div>

            <div>
            <button class="border" type="submit" :disabled="processing">
                Update Profile
            </button>
            </div>

        </template>
    </Form>
</template>
