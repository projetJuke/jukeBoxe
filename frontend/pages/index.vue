<template>
  <div class="relative h-dvh w-full overflow-hidden">
    <div class="mx-auto flex h-dvh w-full max-w-[1800px] flex-col items-center justify-center gap-4 px-4 py-4 xl:grid xl:grid-cols-[400px_minmax(260px,1fr)_400px] xl:justify-center xl:gap-[clamp(24px,4vw,72px)] xl:px-6 xl:py-6">
      <PlaylistList />
      <Vinyl />
      <Tag />
    </div>
    <ChoixMusique
      v-if="showChoixMusique"
      :selected-letter="selectedLetter"
      :selected-number="selectedNumber"
    />
  </div>
</template>
<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

const showChoixMusique = ref(false)
const selectedLetter = ref('')
const selectedNumber = ref('')
const pauseRequest = useState('player-pause-request', () => 0)
const trackRequestCode = useState('player-track-request-code', () => '')
const trackRequestId = useState('player-track-request-id', () => 0)

function handleKey(event: KeyboardEvent) {
  const key = event.key.toUpperCase()

  if (key === 'M') {
    showChoixMusique.value = !showChoixMusique.value
    pauseRequest.value += 1
    if (!showChoixMusique.value) {
      selectedLetter.value = ''
      selectedNumber.value = ''
    }
    return
  }

  if (!showChoixMusique.value) {
    return
  }

  if (!selectedLetter.value && /^[A-I]$/.test(key)) {
    selectedLetter.value = key
    selectedNumber.value = ''
    return
  }

  if (selectedLetter.value && /^[1-9]$/.test(key)) {
    selectedNumber.value = key
    trackRequestCode.value = `${selectedLetter.value}${key}`
    trackRequestId.value += 1
    window.setTimeout(() => {
      showChoixMusique.value = false
      selectedLetter.value = ''
      selectedNumber.value = ''
    }, 180)
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKey)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKey)
})
</script>
