<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { register } from '@/wayfinder/routes';
import { store } from '@/wayfinder/routes/login';
import { request } from '@/wayfinder/routes/password';

defineProps<{
    status?: string;
}>();
</script>

<template>
	<div>
		<span v-if="status">
			{{ status }}
		</span>

		<Form :action="store()" #default="{
			errors,
			hasErrors,
			processing,
		}">
			<div class="flex flex-col gap-1">
				<label for="email">Email</label>
				<input class="border" type="email" name="email" autocomplete="email"/>
				<span v-if="hasErrors && errors.email" v-html="errors.email"/>
			</div>
			<div class="flex flex-col gap-1">
				<label for="password">Password</label>
				<input class="border" type="password" name="password" autocomplete="current-password"/>
				<span v-if="hasErrors && errors.password" v-html="errors.password"/>
			</div>
			<div class="flex gap-1">
				<input type="checkbox" name="remember">
				<label for="remember">Remember me</label>
			</div>

			<div class="flex flex-col gap-1">
				<button class="border" type="submit" :disabled="processing">
					Login
				</button>

				<a class="underline" :href="register().url">
					Register account
				</a>
				<a class="underline" :href="request().url">
					Forgot your password?
				</a>
			</div>
		</Form>
  	</div>
</template>