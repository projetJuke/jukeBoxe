<script setup lang="ts">
withDefaults(defineProps<{
  href?: string
  variant?: 'primary' | 'secondary'
  type?: 'button' | 'submit' | 'reset'
}>(), {
  href: undefined,
  variant: 'primary',
  type: 'button'
})
</script>

<template>
  <NuxtLink
    v-if="href"
    :to="href"
    :class="[
      'inline-flex items-center justify-center rounded-full px-5 py-3 text-sm font-semibold transition',
      variant === 'primary'
        ? 'bg-slate-950 text-white hover:bg-slate-800'
        : 'border border-slate-300 bg-white text-slate-900 hover:border-slate-400 hover:bg-slate-50'
    ]"
  >
    <slot />
  </NuxtLink>
  <button
    v-else
    :class="[
      'inline-flex items-center justify-center rounded-full px-5 py-3 text-sm font-semibold transition',
      variant === 'primary'
        ? 'bg-slate-950 text-white hover:bg-slate-800'
        : 'border border-slate-300 bg-white text-slate-900 hover:border-slate-400 hover:bg-slate-50'
    ]"
    :type="type"
  >
    <slot />
  </button>
</template>
