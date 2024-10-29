<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import IconAddComment from '@/Components/IconAddComment.vue';
import IconEdit from '@/Components/IconEdit.vue';
import IconMenu from '@/Components/IconMenu.vue';
import IconTrashCan from '@/Components/IconTrashCan.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import UserAvatar from '@/Components/UserAvatar.vue';

dayjs.extend(relativeTime);

const { comments, post } = defineProps([
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
const commentCreatedBy = (user) => usePage().props.auth.user?.id === user.id;
const deleteComment = (commentId) => {
    const adjustPage = comments.meta.current_page > 1 && comments.meta.from === comments.meta.total ? -1 : 0;
    const page = comments.meta.current_page + adjustPage;
    const endpoint = route('comments.destroy', {
        comment: commentId,
        page,
    });

    router.delete(endpoint, {
        preserveScroll: true,
    });
};
</script>

<template lang="pug">
    AppLayout(:title="post.title")
        Container
            article.grid.gap-6.bg-white.px-8.py-4.rounded-2xl(class="grid-cols-[auto_1fr_auto]")
                UserAvatar.size-20.place-self-center.row-span-2(:user="post.user")
                .self-end
                    h1.text-xl {{ post.title }}
                    h3
                        span.text-gray-500 Posted by
                        | &#x20;
                        span.text-gray-700 {{ post.user.name }}
                .text-sm.self-end.text-gray-500 {{ dayjs(post.createdAt).fromNow() }}
                p.col-span-2.break-words {{ post.body }}

            .bg-white.mx-8.mt-4.px-8.py-4.rounded-2xl(v-if="$page.props.auth.user && comments.meta.current_page === 1")
                form.flex.gap-4.justify-between(@submit.prevent="addComment")
                    UserAvatar.size-16.place-self-center(:user="$page.props.auth.user")
                    .w-full
                        InputLabel.sr-only(for="hostdoc-comment-body") Comment
                        TextArea.resize-none#hostdoc-comment-body(v-model="commentForm.body", rows="3", placeholder="Weigh in with your thoughts")
                    PrimaryButton.text-nowrap(type="submit", :disabled="commentForm.processing")
                        IconAddComment.size-5
                        | &nbsp;Add Comment
                InputError.mt-2(:message="commentForm.errors.body")

            article.grid.gap-4.bg-gray-50.mt-4.mx-8.px-8.py-4.rounded-2xl(v-for="comment in comments.data", :id="comment.id", class="grid-cols-[auto_1fr_auto_auto]")
                UserAvatar.size-16.place-self-center.row-span-2(:user="comment.user")
                h4
                    span.text-gray-500 Comment by
                    | &#x20;
                    span.text-gray-700 {{ comment.user.name }}
                .text-sm.text-gray-500 {{ dayjs(comment.createdAt).fromNow() }}
                .relative
                    Dropdown(v-if="commentCreatedBy(comment.user)")
                        template(#trigger)
                            button.text-gray-500(type="button")
                                .sr-only Manage Comment
                                IconMenu.size-5
                        template(#content)
                            .block.px-4.py-2.text-xs.text-gray-400.select-none Manage Comment
                            DropdownLink(as="button")
                                .flex.gap-4
                                    IconEdit.size-5
                                    span Edit
                            DropdownLink(as="button", @click="deleteComment(comment.id)", :disabled="comment.can?.destroy !== true")
                                .flex.gap-4
                                    IconTrashCan.size-5
                                    span Delete
                p.col-span-3.break-words {{ comment.body }}

            Pagination.mx-12.mt-4(:meta="comments.meta", :only="['comments']")
        //-
</template>
