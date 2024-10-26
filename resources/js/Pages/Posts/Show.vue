<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

defineProps(['post']);
</script>

<template lang="pug">
    AppLayout(:title="post.title")
        Container
            article.bg-white.px-8.py-4.rounded-2xl
                h1.text-xl {{ post.title }}
                .flex.justify-between.items-end.pb-4
                    h3.text-lg
                        span.text-gray-500 Posted by
                        | &#x20;
                        span.text-gray-700 {{ post.user.name }}
                    span.text-sm.text-gray-500 {{ dayjs(post.createdAt).fromNow() }}
                p.indent-8 {{ post.body }}
</template>
