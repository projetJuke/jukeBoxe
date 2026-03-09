<script setup lang="ts">
const config = useRuntimeConfig()
</script>

<template>
  <form
    class="grid gap-5 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm md:grid-cols-2"
    @submit.prevent
  >
    <div>
      <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nom</label>
      <input
        id="name"
        type="text"
        placeholder="Votre nom"
        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-600"
      >
    </div>
    <div>
      <label for="company" class="mb-2 block text-sm font-medium text-slate-700">Entreprise</label>
      <input
        id="company"
        type="text"
        placeholder="Nom de l entreprise"
        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-600"
      >
    </div>
    <div>
      <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
      <input
        id="email"
        type="email"
        placeholder="vous@domaine.fr"
        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-600"
      >
    </div>
    <div>
      <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Telephone</label>
      <input
        id="phone"
        type="tel"
        placeholder="06 00 00 00 00"
        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-600"
      >
    </div>
    <div class="md:col-span-2">
      <label for="message" class="mb-2 block text-sm font-medium text-slate-700">Message</label>
      <textarea
        id="message"
        rows="6"
        placeholder="Expliquez votre besoin"
        class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-600"
      ></textarea>
    </div>
    <div class="flex flex-col gap-4 md:col-span-2 md:flex-row md:items-center md:justify-between">
      <p class="text-sm text-slate-500">
        Email de reception suggere : {{ config.public.contactEmail }}
      </p>
      <BaseButton type="submit">
        Envoyer
      </BaseButton>
    </div>
  </form>
</template>
