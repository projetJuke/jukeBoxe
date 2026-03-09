<script setup lang="ts">
const props = withDefaults(defineProps<{
  columns?: 2 | 3
}>(), {
  columns: 3
})

const gridClass = computed(() => props.columns === 2
  ? 'grid gap-6 lg:grid-cols-2'
  : 'grid gap-6 md:grid-cols-2 xl:grid-cols-3')
</script>

<template>
  <div :class="gridClass">
    <slot />
  </div>
</template>
