<script setup lang="ts">
import AppTempLayout from '@/layouts/AppTempLayout.vue';
import { ref } from 'vue';
import { MdEditor } from 'md-editor-v3';
import 'md-editor-v3/lib/style.css';

const text = ref('# Hello Editor');


const onSave = (v:string, h: Promise<string>) => {
  console.log(v);

  h.then((html: string) => {
    console.log('html:',html);
  });
};

</script>

<template>
    <AppTempLayout>
        <MdEditor @onSave="onSave" v-model="text" language="en-US" :noKatex="true" :noMermaid="true" :noUploadImg="true" :toolbarsExclude="['mermaid']" />
    </AppTempLayout>
</template>