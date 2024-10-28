<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

defineProps(['posts']);
</script>

<template lang="pug">
    AppLayout(title="Posts")
        Container
            ul.divide-y
                li.px-2.py-4(v-for="post in posts.data" :key="post.id")
                    Link.font-bold.text-lg(:href="route('posts.show', post)", class="hover:text-indigo-600") {{ post.title }}
                    .mt-1.text-sm
                        span.text-gray-500 Posted by
                        | &#x20;
                        span.text-gray-700 {{ post.user.name }}
                        | &#x20;
                        span.text-gray-500 &ndash; {{ dayjs(post.createdAt).fromNow() }}
            Pagination(:meta="posts.meta", :only="['posts']")
</template>
