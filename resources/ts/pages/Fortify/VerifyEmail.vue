<script setup lang="ts">
import { logout } from '@/wayfinder/routes';
import { send } from '@/wayfinder/routes/verification';
import { Form, Link } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <div class="flex flex-col gap-1">
        <span>
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </span>

        <span v-if="status == 'verification-link-sent'">
            A new verification link has been sent to the email address you
            provided during registration.
        </span>

        <Form
            class="flex flex-col gap-1"
            :action="send()"
            #default="{ processing }"
        >
            <button class="border" type="submit" :disabled="processing">
                Resend Verification Email
            </button>

            <Link class="border" :href="logout().url" method="post" as="button">
                Logout
            </Link>
        </Form>
    </div>
</template>
