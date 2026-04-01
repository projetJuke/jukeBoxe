<template>
  <article class="card-juke flex min-h-[56px] w-full items-center rounded-[14px] px-2.5 py-2 shadow-[0_4px_10px_rgba(0,0,0,0.18)]">
    <img
      :src="coverSrc"
      :alt="track.album || 'Pochette de playlist'"
      class="block h-[42px] w-[42px] rounded-[10px] object-cover"
    >
    <div class="ml-3 min-w-0 flex-1">
      <h2 class="truncate font-mulish text-[20px] font-black uppercase leading-none text-black">
        {{ track.album || `Track ${track.track_id}` }}
      </h2>
      <p class="mt-1 truncate font-mulish text-[12px] leading-none text-black/75">
        {{ track.name || 'Artiste inconnu' }}
      </p>
    </div>
    <div class="ml-3 flex flex-col items-end justify-center">
      <span class="font-mulish text-[16px] font-black leading-none text-black">{{ track.track_code }}</span>
      <span class="mt-2 font-mulish text-[12px] leading-none text-black/70">{{ track.length }}</span>
    </div>
  </article>
</template>
<script setup lang="ts">
const props = defineProps<{
  track: {
    track_id: number | string
    album: string
    length: string
    id_cover: number | string
    id_music: number | string
    track_code: string
    name: string
  }
}>()

const coverSrc = computed(() => {
  if (!props.track.id_cover) {
    return '/images/1.jpg'
  }

  return `/images/${props.track.id_cover}`
})
</script>

<style scoped>
.card-juke {
  background-color: #c49e7c;
}
</style>
