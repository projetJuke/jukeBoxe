<script setup lang="ts">
defineProps<{
  items: Array<{
    quote: string
    name: string
    role: string
  }>
}>()
</script>

<template>
  <SectionBlock
    id="temoignages"
    eyebrow="Temoignages"
    title="Des retours clients faciles a mettre en avant"
    description="Utilisez cette section pour renforcer la confiance avec quelques avis courts et credibles."
    variant="muted"
  >
    <ContentGrid :columns="2">
      <article
        v-for="item in items"
        :key="`${item.name}-${item.role}`"
        class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm"
      >
        <p class="text-lg leading-8 text-slate-700">
          "{{ item.quote }}"
        </p>
        <p class="mt-6 font-semibold text-slate-900">
          {{ item.name }}
        </p>
        <p class="text-sm text-slate-500">
          {{ item.role }}
        </p>
      </article>
    </ContentGrid>
  </SectionBlock>
</template>
