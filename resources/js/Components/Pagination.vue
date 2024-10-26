<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const { meta } = defineProps(["meta"]);
const previous = computed(() => {
    const disabled = meta.current_page === 1;

    return {
        ...meta.links.at(0),
        disabled,
    };
});
const pages = computed(() => meta.links.slice(1, -1));
const next = computed(() => {
    const disabled = meta.current_page === meta.last_page;

    return {
        ...meta.links.at(-1),
        disabled,
    };
});
</script>

<template>
    <div
        class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6"
    >
        <div class="flex flex-1 justify-between sm:hidden">
            <Link
                :href="previous.url"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700"
                :class="{
                    'cursor-not-allowed bg-gray-300': previous.disabled,
                    'hover:bg-gray-50': !previous.disabled,
                }"
                >Previous</Link
            >
            <Link
                :href="next.url"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700"
                :class="{
                    'cursor-not-allowed bg-gray-300': next.disabled,
                    'hover:bg-gray-50': !next.disabled,
                }"
                >Next</Link
            >
        </div>
        <div
            class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ meta.from }}</span>
                    to <span class="font-medium">{{ meta.to }}</span>
                    of <span class="font-medium">{{ meta.total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav
                    class="isolate inline-flex -space-x-px rounded-md bg-white shadow-sm select-none"
                    aria-label="Pagination"
                >
                    <Link
                        :href="previous.url"
                        class="relative inline-flex items-center first-of-type:rounded-l-md last-of-type:rounded-r-md px-4 py-2 text-gray-900 ring-1 ring-inset ring-gray-300"
                        :class="{
                            'cursor-not-allowed bg-gray-300': previous.disabled,
                            'hover:bg-gray-50 focus:outline-offset-0':
                                !previous.disabled,
                        }"
                    >
                        <ChevronLeftIcon
                            class="h-5 w-5"
                            aria-hidden="true"
                        ></ChevronLeftIcon>
                        <span class="sr-only">Previous</span>
                    </Link>
                    <Link
                        v-for="link in pages"
                        :href="link.url"
                        class="relative inline-flex items-center first-of-type:rounded-l-md last-of-type:rounded-r-md px-4 py-2"
                        :class="{
                            'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600':
                                link.active,
                            'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0':
                                !link.active,
                        }"
                    >
                        <span v-html="link.label"></span>
                    </Link>
                    <Link
                        :href="next.url"
                        class="relative inline-flex items-center first-of-type:rounded-l-md last-of-type:rounded-r-md px-4 py-2 text-gray-900 ring-1 ring-inset ring-gray-300"
                        :class="{
                            'cursor-not-allowed bg-gray-300': next.disabled,
                            'hover:bg-gray-50 focus:outline-offset-0':
                                !next.disabled,
                        }"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon
                            class="h-5 w-5"
                            aria-hidden="true"
                        ></ChevronRightIcon>
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>
