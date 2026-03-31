<script setup lang="ts">
const config = useRuntimeConfig()
</script>

<template>
  <footer class="border-t border-slate-200 bg-slate-950 py-10 text-slate-300">
    <AppContainer>
      <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        <div>
          <p class="text-base font-semibold text-white">
            {{ config.public.siteName }}
          </p>
          <p class="mt-2 text-sm text-slate-400">
            Contact : {{ config.public.contactEmail }}
          </p>
        </div>
        <div class="flex flex-wrap gap-4 text-sm">
          <NuxtLink to="/" class="transition hover:text-white">
            Accueil
          </NuxtLink>
          <NuxtLink to="/mentions-legales" class="transition hover:text-white">
            Mentions legales
          </NuxtLink>
        </div>
      </div>
    </AppContainer>
  </footer>
</template>
