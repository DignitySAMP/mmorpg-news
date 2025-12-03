<script setup lang="ts">
import { login } from '@/wayfinder/routes';
import { store } from '@/wayfinder/routes/register';
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <Form :action="store()" #default="{ errors, hasErrors, processing }">
        <div class="flex flex-col gap-1">
            <label for="name">Username</label>
            <input class="border" type="text" name="name" autocomplete="name" />
            <span v-if="hasErrors && errors.name" v-html="errors.name" />
        </div>
        <div class="flex flex-col gap-1">
            <label for="email">Email</label>
            <input
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
            <label for="password">Password</label>
            <input
                class="border"
                type="password"
                name="password_confirmation"
                autocomplete="password_confirmation"
            />
            <span
                v-if="hasErrors && errors.password_confirmation"
                v-html="errors.password_confirmation"
            />
        </div>
        <div class="flex flex-col gap-1">
            <button class="border" type="submit" :disabled="processing">
                Register
            </button>

            <a class="underline" :href="login().url"> Already registered? </a>
        </div>
    </Form>
</template>
