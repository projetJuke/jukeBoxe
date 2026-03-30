<script setup lang="ts">
const config = useRuntimeConfig()

const navigation = [
  { label: 'Accueil', to: '/' },
  { label: 'Services', to: '/#services' },
  { label: 'Presentation', to: '/#about' },
  { label: 'Contact', to: '/#contact' },
  { label: 'Mentions legales', to: '/mentions-legales' }
]
</script>

<template>
  <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur">
    <AppContainer>
      <div class="flex min-h-20 items-center justify-between gap-6">
        <NuxtLink to="/" class="text-lg font-semibold tracking-tight text-slate-950">
          {{ config.public.siteName }}
        </NuxtLink>
        <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
          <NuxtLink
            v-for="item in navigation"
            :key="item.to"
            :to="item.to"
            class="transition hover:text-slate-950"
          >
            {{ item.label }}
          </NuxtLink>
        </nav>
      </div>
    </AppContainer>
  </header>
</template>
