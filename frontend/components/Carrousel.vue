<template>
  <section class="flex h-full w-full items-center justify-center overflow-hidden px-6 py-8">
    <p
      v-if="pending"
      class="font-mulish text-base text-black"
    >
      Chargement des titres...
    </p>

    <p
      v-else-if="error"
      class="font-mulish text-base text-black"
    >
      {{ errorMessage }}
    </p>

    <p
      v-else-if="tracks.length === 0"
      class="font-mulish text-base text-black"
    >
      Aucun titre a afficher.
    </p>

    <div
      v-else
      class="carrousel-shell w-full max-w-[1800px]"
    >
      <div class="row-mask">
        <div
          class="row-track"
          :style="{ transform: `translateX(-${firstRowOffset}px)` }"
        >
          <CarrouselCard
            v-for="(track, index) in firstRowLoop"
            :key="`first-${track.track_id}-${index}`"
            :track="track"
          />
        </div>
      </div>

      <div class="row-mask mt-6">
        <div
          class="row-track"
          :style="{ transform: `translateX(-${secondRowTranslate}px)` }"
        >
          <CarrouselCard
            v-for="(track, index) in secondRowLoop"
            :key="`second-${track.track_id}-${index}`"
            :track="track"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

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
const apiUrl = `${config.public.apiBase}/api/tracks/all`

const { data, pending, error } = await useFetch<{ tracks?: Track[] }>(apiUrl, {
  server: false
})
const tracks = computed(() => data.value?.tracks ?? [])
const isFastScrolling = ref(false)
const firstRowOffset = ref(0)
const secondRowOffset = ref(0)
const firstRowTracks = computed(() => tracks.value.filter((_, index) => index % 2 === 0))
const secondRowTracks = computed(() => tracks.value.filter((_, index) => index % 2 === 1))
const firstRowLoop = computed(() => [...firstRowTracks.value, ...firstRowTracks.value])
const secondRowLoop = computed(() => [...secondRowTracks.value, ...secondRowTracks.value])
const cardWidth = 576
const rowGap = 24
const firstRowWidth = computed(() => {
  if (firstRowTracks.value.length === 0) {
    return 0
  }

  return (firstRowTracks.value.length * cardWidth) + ((firstRowTracks.value.length - 1) * rowGap)
})
const secondRowWidth = computed(() => {
  if (secondRowTracks.value.length === 0) {
    return 0
  }

  return (secondRowTracks.value.length * cardWidth) + ((secondRowTracks.value.length - 1) * rowGap)
})
const firstRowSpeed = computed(() => (isFastScrolling.value ? 500 : 100))
const secondRowSpeed = computed(() => (isFastScrolling.value ? 500 : 100))
const secondRowTranslate = computed(() => {
  if (secondRowWidth.value === 0) {
    return 0
  }

  return secondRowWidth.value - secondRowOffset.value
})

let animationFrameId: number | null = null
let lastFrameTime = 0

const errorMessage = computed(() => {
  if (!error.value) {
    return ''
  }

  const backendMessage = error.value.data?.message

  if (typeof backendMessage === 'string' && backendMessage !== '') {
    return backendMessage
  }

  return error.value.statusMessage || 'Impossible de charger les titres.'
})

function animateRows(timestamp: number) {
  if (!lastFrameTime) {
    lastFrameTime = timestamp
  }

  const delta = (timestamp - lastFrameTime) / 1000
  lastFrameTime = timestamp

  if (firstRowWidth.value > 0) {
    firstRowOffset.value = (firstRowOffset.value + (firstRowSpeed.value * delta)) % firstRowWidth.value
  }

  if (secondRowWidth.value > 0) {
    secondRowOffset.value = (secondRowOffset.value + (secondRowSpeed.value * delta)) % secondRowWidth.value
  }

  animationFrameId = window.requestAnimationFrame(animateRows)
}

function handleKeyDown(event: KeyboardEvent) {
  if (event.key.toUpperCase() === 'T') {
    isFastScrolling.value = true
  }
}

function handleKeyUp(event: KeyboardEvent) {
  if (event.key.toUpperCase() === 'T') {
    isFastScrolling.value = false
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown)
  window.addEventListener('keyup', handleKeyUp)
  animationFrameId = window.requestAnimationFrame(animateRows)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown)
  window.removeEventListener('keyup', handleKeyUp)

  if (animationFrameId !== null) {
    window.cancelAnimationFrame(animationFrameId)
  }
})
</script>

<style scoped>
.carrousel-shell {
  overflow: hidden;
}

.row-mask {
  overflow: hidden;
}

.row-track {
  display: flex;
  width: max-content;
  gap: 24px;
  will-change: transform;
}
</style>
