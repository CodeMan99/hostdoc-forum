<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps(['posts']);
</script>

<template lang="pug">
    AppLayout
        Container
            ul.divide-y
                li.px-2.py-4(v-for="post in posts" :key="post.id")
                    span.font-bold.text-lg {{ post.title }}
</template>
