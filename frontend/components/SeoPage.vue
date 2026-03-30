<script setup lang="ts">
const props = withDefaults(defineProps<{
  title?: string
  description?: string
  path?: string
  noindex?: boolean
}>(), {
  title: undefined,
  description: undefined,
  path: '/',
  noindex: false
})

const config = useRuntimeConfig()

const pageTitle = computed(() => props.title ?? config.public.siteName)
const pageDescription = computed(() => props.description ?? config.public.defaultDescription)
const robotsContent = computed(() => (props.noindex ? 'noindex, nofollow' : 'index, follow'))
const canonicalUrl = computed(() => {
  const normalizedPath = props.path?.startsWith('/') ? props.path : `/${props.path ?? ''}`
  return new URL(normalizedPath, config.public.siteUrl).toString()
})

useSeoMeta({
  title: pageTitle,
  description: pageDescription,
  ogTitle: pageTitle,
  ogDescription: pageDescription,
  ogSiteName: config.public.siteName,
  ogType: 'website',
  ogUrl: canonicalUrl,
  twitterCard: 'summary_large_image',
  robots: robotsContent
})

useHead({
  link: [
    {
      rel: 'canonical',
      href: canonicalUrl
    }
  ]
})
</script>

<template>
  <span class="hidden" aria-hidden="true" />
</template>
