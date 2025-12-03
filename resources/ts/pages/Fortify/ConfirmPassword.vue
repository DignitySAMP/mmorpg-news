<script setup lang="ts">
import { Form } from '@inertiajs/vue3'

import { request } from '@/wayfinder/routes/password'
import { store } from '@/wayfinder/routes/password/confirm';
</script>

<template>
	<span>
		This is a secure area of the application. Please confirm your password before continuing.
	</span>
	<Form 
		:action="store()" 
		#default="{
			processing, hasErrors, errors
		}" 
		resetOnSuccess
	>
		<div class="flex flex-col gap-1">
			<label for="password">Password</label>
			<input class="border" type="password" name="password" autocomplete="current-password"/>
			<span v-if="hasErrors && errors.password" v-html="errors.password"/>
		</div>

		<button class="border" type="submit" :disabled="processing">
			Login
		</button>
		<a class="underline" :href="request().url">
			Forgot your password?
		</a>
	</Form>
</template>