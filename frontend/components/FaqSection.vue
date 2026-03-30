<script setup lang="ts">
defineProps<{
  items: Array<{
    question: string
    answer: string
  }>
}>()
</script>

<template>
  <SectionBlock
    id="faq"
    eyebrow="FAQ"
    title="Questions frequentes"
    description="Une section prete a reutiliser pour traiter les objections et rassurer les visiteurs."
  >
    <div class="space-y-4">
      <details
        v-for="item in items"
        :key="item.question"
        class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
      >
        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-semibold text-slate-900">
          {{ item.question }}
          <span class="text-cyan-700 transition group-open:rotate-45">+</span>
        </summary>
        <p class="mt-4 text-slate-600">
          {{ item.answer }}
        </p>
      </details>
    </div>
  </SectionBlock>
</template>
