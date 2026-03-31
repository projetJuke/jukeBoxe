const siteName = process.env.NUXT_PUBLIC_SITE_NAME || 'Template Studio'
const siteUrl = process.env.NUXT_PUBLIC_SITE_URL || 'https://example.com'
const defaultDescription = process.env.NUXT_PUBLIC_SITE_DESCRIPTION || 'Base Nuxt pour site vitrine avec sections reutilisables et configuration SEO.'

export default defineNuxtConfig({
  devtools: { enabled: true },

  ssr: true,

  nitro: {
    preset: 'static'
  },

  runtimeConfig: {
    public: {
      siteName,
      siteUrl,
      contactEmail: process.env.NUXT_PUBLIC_CONTACT_EMAIL || 'contact@example.com',
      defaultDescription
    }
  },

  app: {
    head: {
      htmlAttrs: {
        lang: 'fr'
      },
      titleTemplate: `%s | ${siteName}`,
      meta: [
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'description', content: defaultDescription }
      ]
    }
  },

  modules: [
    '@nuxtjs/tailwindcss',
    '@nuxt/icon'
  ]
})
