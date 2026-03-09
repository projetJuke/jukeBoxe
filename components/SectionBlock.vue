<script setup lang="ts">
const props = withDefaults(defineProps<{
  id?: string
  eyebrow?: string
  title?: string
  description?: string
  variant?: 'default' | 'muted' | 'hero'
}>(), {
  id: undefined,
  eyebrow: undefined,
  title: undefined,
  description: undefined,
  variant: 'default'
})

const sectionClass = computed(() => {
  if (props.variant === 'muted') {
    return 'bg-slate-50'
  }

  if (props.variant === 'hero') {
    return 'bg-gradient-to-br from-amber-50 via-white to-cyan-50'
  }

  return 'bg-white'
})
</script>

<template>
  <section :id="id" :class="['py-20 sm:py-24', sectionClass]">
    <AppContainer>
      <div class="max-w-3xl">
        <p v-if="eyebrow" class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-700">
          {{ eyebrow }}
        </p>
        <h1 v-if="title" class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">
          {{ title }}
        </h1>
        <p v-if="description" class="mt-5 text-lg leading-8 text-slate-600">
          {{ description }}
        </p>
        <div v-if="$slots.actions" class="mt-8 flex flex-wrap gap-4">
          <slot name="actions" />
        </div>
      </div>

      <div class="mt-12">
        <slot />
      </div>
    </AppContainer>
  </section>
</template>
