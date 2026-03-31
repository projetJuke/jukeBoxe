<script setup lang="ts">
defineProps<{
  title: string
  description: string
}>()
</script>

<template>
  <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700">
      <span class="text-sm font-semibold uppercase tracking-[0.2em]">
        {{ title.slice(0, 2) }}
      </span>
    </div>
    <h3 class="mt-6 text-xl font-semibold text-slate-900">
      {{ title }}
    </h3>
    <p class="mt-3 text-slate-600">
      {{ description }}
    </p>
  </article>
</template>
