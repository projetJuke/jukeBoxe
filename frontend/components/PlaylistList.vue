<template>
  <section class="card-juke w-full max-w-[400px] rounded-[20px] px-4 py-5 shadow-[0_10px_24px_rgba(120,85,57,0.18)] xl:justify-self-end xl:h-[min(750px,calc(100dvh-4rem))]">
    <h1 class="font-arima text-[34px] font-extrabold leading-none text-black sm:text-[38px]">
      Playlist
    </h1>
    <div class="mt-5 xl:h-[calc(100%-4rem)]">
      <p
        v-if="pending"
        class="rounded-[14px] bg-[#c49e7c] px-3 py-3 font-mulish text-[14px] text-black"
      >
        Chargement de la playlist...
      </p>
      <p
        v-else-if="error"
        class="rounded-[14px] bg-[#c49e7c] px-3 py-3 font-mulish text-[14px] text-black"
      >
        {{ errorMessage }}
      </p>
      <p
        v-else-if="tracks.length === 0"
        class="rounded-[14px] bg-[#c49e7c] px-3 py-3 font-mulish text-[14px] text-black"
      >
        Aucune track disponible.
      </p>
      <div
        v-else
        class="flex h-full flex-col justify-between"
      >
        <Titre
          v-for="track in tracks"
          :key="track.track_id"
          :track="track"
        />
      </div>
    </div>
  </section>
</template>
<script setup lang="ts">
type Track = {
  track_id: number | string
  album: string
  length: string
  id_cover: number | string
  id_music: number | string
  track_code: string
  name: string
}

const config = useRuntimeConfig()
const apiUrl = `${config.public.apiBase}/api/tracks`
const playlistTracks = useState<Track[]>('playlist-tracks', () => [])

const { data, pending, error } = await useFetch<{ tracks?: Track[] }>(apiUrl, {
  server: false
})
const tracks = computed(() => data.value?.tracks ?? [])

watchEffect(() => {
  playlistTracks.value = tracks.value
})

const errorMessage = computed(() => {
  if (!error.value) {
    return ''
  }

  const backendMessage = error.value.data?.message

  if (typeof backendMessage === 'string' && backendMessage !== '') {
    return backendMessage
  }

  return error.value.statusMessage || 'Impossible de charger la playlist.'
})
</script>
<style scoped>
.card-juke {
  background-color: rgb(176 137 104 / 46%);
}

</style>
