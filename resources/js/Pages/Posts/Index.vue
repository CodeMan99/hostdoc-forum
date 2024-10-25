<script setup>
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps(['posts']);
</script>

<template lang="pug">
    AppLayout
        Container
            ul.divide-y
                li.px-2.py-4(v-for="post in posts.data" :key="post.id")
                    span.font-bold.text-lg {{ post.title }}
            Pagination(:meta="posts.meta")
</template>
