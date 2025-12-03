<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { login } from '@/wayfinder/routes';
import { email } from '@/wayfinder/routes/password';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <span>
      Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </span>

    <Form :action="email()" #default="{
		errors,
		hasErrors,
		processing,
	}">
        <span v-if="status" v-html="status" />
		
        <div class="flex flex-col gap-1">
          	<label for="email">Email</label>
          	<input class="border" type="email" name="email" autocomplete="email"/>
          	<span v-if="hasErrors && errors.email" v-html="errors.email"/>
        </div>

		<div class="flex flex-col gap-1">
			<button class="border" type="submit" :disabled="processing">
				Email Password Reset Link
			</button>

			<a class="underline" :href="login().url">
				Remember your password?
			</a>
		</div>
    </Form>
</template>