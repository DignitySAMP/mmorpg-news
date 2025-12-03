<script setup lang="ts">
import { update } from '@/wayfinder/routes/password';
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <Form
        :action="update()"
        :transform="(data) => ({ ...data, token, email })"
        #default="{ errors, hasErrors, processing }"
    >
        <div class="flex flex-col gap-1">
            <label for="email">Email</label>
            <input
                v-model="inputEmail"
                class="border"
                type="email"
                name="email"
                autocomplete="email"
            />
            <span v-if="hasErrors && errors.email" v-html="errors.email" />
        </div>

        <div class="flex flex-col gap-1">
            <label for="password">Password</label>
            <input
                class="border"
                type="password"
                name="password"
                autocomplete="new-password"
            />
            <span
                v-if="hasErrors && errors.password"
                v-html="errors.password"
            />
        </div>
        <div class="flex flex-col gap-1">
            <label for="password_confirmation">Confirm password</label>
            <input
                class="border"
                type="password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
            />
            <span
                v-if="hasErrors && errors.password_confirmation"
                v-html="errors.password_confirmation"
            />
        </div>
        <button class="border" type="submit" :disabled="processing">
            Reset Password
        </button>
    </Form>
</template>
