<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import Pagination from '@/Components/Pagination.vue';

dayjs.extend(relativeTime);

defineProps([
    'comments',
    'post',
]);
</script>

<template lang="pug">
    AppLayout(:title="post.title")
        Container
            article.grid.gap-6.bg-white.px-8.py-4.rounded-2xl(class="grid-cols-[auto_1fr_1fr]")
                img.place-self-center.row-span-2.h-20.w-20.rounded-full(:src="post.user.avatar")
                .self-end
                    h1.text-xl {{ post.title }}
                    h3
                        span.text-gray-500 Posted by
                        | &#x20;
                        span.text-gray-700 {{ post.user.name }}
                .text-sm.place-self-end.text-gray-500 {{ dayjs(post.createdAt).fromNow() }}
                p.col-span-2 {{ post.body }}

            article.grid.gap-4.bg-gray-50.mt-4.mx-8.px-8.py-4.rounded-2xl(v-for="comment in comments.data", :id="comment.id", class="grid-cols-[auto_1fr_1fr]")
                img.place-self-center.row-span-2.h-16.w-16.rounded-full(:src="comment.user.avatar")
                h4
                    span.text-gray-500 Comment by
                    | &#x20;
                    span.text-gray-700 {{ comment.user.name }}
                .text-sm.place-self-end.text-gray-500 {{ dayjs(comment.createdAt).fromNow() }}
                p.col-span-2 {{ comment.body }}

            Pagination.mx-12.mt-4(:meta="comments.meta", :only="['comments']")
</template>
