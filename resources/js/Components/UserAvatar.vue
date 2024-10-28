<script setup>
import { computed } from "vue";

const { size, user } = defineProps(['size', 'user']);

// Generated routes do not make use of the UserResouce class
const imageURL = computed(() => user.avatar || user.profile_photo_url);
const altText = computed(() => `Profile photo for ${user.name}`);
const className = computed(() => [`h-${size}`, `w-${size}`]);
</script>

<template lang="pug">
    img.rounded-full.object-cover(:src="imageURL", :alt="altText", :class="className")
</template>
