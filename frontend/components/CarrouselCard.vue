<template>
  <article class="card-juke flex h-[277px] w-[576px] items-center rounded-[12px] p-[12px] shadow-md">
    <img
        :src="coverSrc"
        :alt="track.album || 'Pochette'"
        class="h-[253px] w-[253px] rounded-[12px] object-cover shadow"
    >

    <div class="ml-[20px] flex min-w-0 flex-1 flex-col justify-center">
      <p class="artist-text font-mulish text-lg leading-none text-black">
        {{ track.name || 'Artiste inconnu' }}
      </p>

      <h2 class="title-text mt-[6px] font-arima text-3xl font-black leading-none text-black">
        {{ track.album || 'Titre inconnu' }}
      </h2>

      <span class="mt-[20px] font-mulish text-[72px] font-black leading-none text-black">
        {{ track.track_code }}
      </span>
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

.artist-text {
  display: -webkit-box;
  overflow: hidden;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 1;
}

.title-text {
  display: -webkit-box;
  overflow: hidden;
  line-height: 1.05;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
}
</style>
