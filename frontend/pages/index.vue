<template>
  <div class="relative h-dvh w-full overflow-hidden">
    <div
      v-show="screenMode === 'carrousel'"
      class="h-full w-full"
    >
      <Carrousel />
    </div>

    <div
      v-show="screenMode === 'player'"
      class="mx-auto flex h-dvh w-full max-w-[1800px] flex-col items-center justify-center gap-4 px-4 py-4 xl:grid xl:grid-cols-[400px_minmax(260px,1fr)_400px] xl:justify-center xl:gap-[clamp(24px,4vw,72px)] xl:px-6 xl:py-6"
    >
      <PlaylistList />
      <Vinyl />
      <Tag />
    </div>

    <ChoixMusique
      v-if="showChoixMusique"
      :selected-letter="selectedLetter"
      :selected-number="selectedNumber"
      :error-message="trackRequestError"
    />
  </div>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref, watch } from 'vue'

const screenMode = ref<'carrousel' | 'player'>('carrousel')
const showChoixMusique = ref(false)
const selectedLetter = ref('')
const selectedNumber = ref('')
const isChoicePopupOpen = useState('player-choice-popup-open', () => false)
const pauseRequest = useState('player-pause-request', () => 0)
const trackRequestCode = useState('player-track-request-code', () => '')
const trackRequestId = useState('player-track-request-id', () => 0)
const trackRequestError = useState('player-track-request-error', () => '')
const trackRequestSuccessId = useState('player-track-request-success-id', () => 0)

function handleKey(event: KeyboardEvent) {
  const key = event.key.toUpperCase()

  if (key === 'Z') {
    screenMode.value = screenMode.value === 'carrousel' ? 'player' : 'carrousel'
    return
  }

  if (key === 'M') {
    showChoixMusique.value = !showChoixMusique.value
    isChoicePopupOpen.value = showChoixMusique.value
    trackRequestError.value = ''
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

  if (key === 'S') {
    trackRequestError.value = ''

    if (selectedNumber.value) {
      selectedNumber.value = ''
      return
    }

    if (selectedLetter.value) {
      selectedLetter.value = ''
    }

    return
  }

  if (key === 'P') {
    if (selectedLetter.value && selectedNumber.value) {
      trackRequestError.value = ''
      trackRequestCode.value = `${selectedLetter.value}${selectedNumber.value}`
      trackRequestId.value += 1
    }

    return
  }

  if (!selectedLetter.value && /^[A-I]$/.test(key)) {
    trackRequestError.value = ''
    selectedLetter.value = key
    selectedNumber.value = ''
    return
  }

  if (selectedLetter.value && /^[1-9]$/.test(key)) {
    trackRequestError.value = ''
    selectedNumber.value = key
  }
}

watch(trackRequestError, (value) => {
  if (!showChoixMusique.value || value === '') {
    return
  }

  selectedLetter.value = ''
  selectedNumber.value = ''
})

watch(trackRequestSuccessId, (value) => {
  if (value === 0) {
    return
  }

  screenMode.value = 'player'
  showChoixMusique.value = false
  isChoicePopupOpen.value = false
  selectedLetter.value = ''
  selectedNumber.value = ''
})

onMounted(() => {
  window.addEventListener('keydown', handleKey)
})

onUnmounted(() => {
  isChoicePopupOpen.value = false
  window.removeEventListener('keydown', handleKey)
})
</script>
