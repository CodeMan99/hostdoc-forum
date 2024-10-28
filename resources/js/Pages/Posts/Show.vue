<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import Pagination from '@/Components/Pagination.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import UserAvatar from '@/Components/UserAvatar.vue';

dayjs.extend(relativeTime);

const { post } = defineProps([
    'comments',
    'post',
]);
const commentForm = useForm({
    body: '',
});
const addComment = () => {
    const endpoint = route('posts.comments.store', post);

    commentForm.post(endpoint, {
        preserveScroll: true,
        onSuccess: () => commentForm.reset(),
    });
};
</script>

<template lang="pug">
    AppLayout(:title="post.title")
        Container
            article.grid.gap-6.bg-white.px-8.py-4.rounded-2xl(class="grid-cols-[auto_1fr_1fr]")
                UserAvatar.place-self-center.row-span-2(:user="post.user", size="20")
                .self-end
                    h1.text-xl {{ post.title }}
                    h3
                        span.text-gray-500 Posted by
                        | &#x20;
                        span.text-gray-700 {{ post.user.name }}
                .text-sm.place-self-end.text-gray-500 {{ dayjs(post.createdAt).fromNow() }}
                p.col-span-2.break-all {{ post.body }}

            .bg-white.mx-8.mt-4.px-8.py-4.rounded-2xl(v-if="$page.props.auth.user")
                form.flex.gap-4.justify-between(@submit.prevent="addComment")
                    UserAvatar.place-self-center(:user="$page.props.auth.user", size="16")
                    .w-full
                        InputLabel.sr-only(for="hostdoc-comment-body") Comment
                        TextArea.resize-none#hostdoc-comment-body(v-model="commentForm.body", rows="3", placeholder="Weigh in with your thoughts")
                    PrimaryButton.text-nowrap(type="submit", :disabled="commentForm.processing") Add Comment
                InputError.mt-2(:message="commentForm.errors.body")

            article.grid.gap-4.bg-gray-50.mt-4.mx-8.px-8.py-4.rounded-2xl(v-for="comment in comments.data", :id="comment.id", class="grid-cols-[auto_1fr_1fr]")
                UserAvatar.place-self-center.row-span-2(:user="comment.user", size="16")
                h4
                    span.text-gray-500 Comment by
                    | &#x20;
                    span.text-gray-700 {{ comment.user.name }}
                .text-sm.place-self-end.text-gray-500 {{ dayjs(comment.createdAt).fromNow() }}
                p.col-span-2.break-all {{ comment.body }}

            Pagination.mx-12.mt-4(:meta="comments.meta", :only="['comments']")
</template>
