<script setup lang="ts">
import { update } from '@/wayfinder/routes/user-password';
import { Form } from '@inertiajs/vue3';

interface UpdatePasswordErrorBag {
    updatePassword?: {
        current_password?: string[];
        password?: string[];
        password_confirmation?: string[];
    };
}
</script>

<template>
    <Form :action="update()" resetOnSuccess>
        <template
            #default="{
                errors,
                hasErrors,
                processing,
                wasSuccessful,
            }: {
                errors: UpdatePasswordErrorBag;
                hasErrors: boolean;
                processing: boolean;
                wasSuccessful: boolean;
            }"
        >
            <span v-if="wasSuccessful">
                You have successfully updated your password.
            </span>
            <div class="flex flex-col gap-1">
                <label for="current_password">Current Password</label>
                <input
                    class="border"
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                />
                <span
                    v-if="hasErrors && errors.updatePassword?.current_password"
                    v-html="errors.updatePassword.current_password"
                />
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
                    v-if="hasErrors && errors.updatePassword?.password"
                    v-html="errors.updatePassword.password"
                />
            </div>

            <div class="flex flex-col gap-1">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    class="border"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                />
                <span
                    v-if="
                        hasErrors &&
                        errors.updatePassword?.password_confirmation
                    "
                    v-html="errors.updatePassword.password_confirmation"
                />
            </div>

            <div>
                <button class="border" type="submit" :disabled="processing">
                    Save
                </button>
            </div>
        </template>
    </Form>
</template>
