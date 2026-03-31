<template>
  <div class="flex w-full items-center justify-center">
    <div
      class="relative h-[clamp(220px,39.06vw,750px)] w-[clamp(220px,39.06vw,750px)] shrink-0"
      :style="{ transform: `rotate(${vinylRotation}deg)` }"
    >
      <img
        src="/images/vinyl.png"
        alt="Vinyle"
        class="block h-full w-full object-contain"
      >
      <img
        src="/images/1.jpg"
        alt="Pochette album"
        class="absolute left-1/2 top-1/2 h-[38%] w-[38%] -translate-x-1/2 -translate-y-1/2 rounded-full object-cover"
      >
    </div>
    <img
        src="/images/barre.png"
        alt="Barre"
        :class="['block h-[clamp(160px,28.33vw,544px)] w-[clamp(15px,2.6vw,50px)] shrink-0 object-contain arm', { play: isPlaying }]"
    >
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const isPlaying = ref(false)
const vinylRotation = ref(0)
const audio = ref<HTMLAudioElement | null>(null)
const currentTime = useState('player-current-time', () => 0)
const duration = useState('player-duration', () => 0)

const maxSpeed = 45
const transitionDuration = 1300

let animationFrameId: number | null = null
let lastFrameTime = 0
let currentSpeed = 0
let targetSpeed = 0

function syncAudioState() {
  if (!audio.value) {
    return
  }

  currentTime.value = audio.value.currentTime
  duration.value = Number.isFinite(audio.value.duration) ? audio.value.duration : 0
}

function handleAudioEnded() {
  isPlaying.value = false
  targetSpeed = 0
  syncAudioState()
}

function handleKey(e: KeyboardEvent) {
  if (e.key.toLowerCase() === 'p') {
    togglePlayback()
  }
}

async function togglePlayback() {
  if (!audio.value) {
    return
  }

  if (isPlaying.value) {
    audio.value.pause()
    isPlaying.value = false
    targetSpeed = 0
    return
  }

  try {
    await audio.value.play()
    isPlaying.value = true
    targetSpeed = maxSpeed
  } catch (error) {
    console.error('Lecture audio impossible', error)
  }
}

function animateVinyl(timestamp: number) {
  if (!lastFrameTime) {
    lastFrameTime = timestamp
  }

  const delta = (timestamp - lastFrameTime) / 1000
  lastFrameTime = timestamp

  const speedStep = (maxSpeed / transitionDuration) * (delta * 1000)

  if (currentSpeed < targetSpeed) {
    currentSpeed = Math.min(currentSpeed + speedStep, targetSpeed)
  } else if (currentSpeed > targetSpeed) {
    currentSpeed = Math.max(currentSpeed - speedStep, targetSpeed)
  }

  vinylRotation.value = (vinylRotation.value + currentSpeed * delta) % 360
  animationFrameId = window.requestAnimationFrame(animateVinyl)
}

onMounted(() => {
  audio.value = new Audio('/audio/1.mp3')
  audio.value.addEventListener('timeupdate', syncAudioState)
  audio.value.addEventListener('loadedmetadata', syncAudioState)
  audio.value.addEventListener('durationchange', syncAudioState)
  audio.value.addEventListener('ended', handleAudioEnded)
  window.addEventListener('keydown', handleKey)
  animationFrameId = window.requestAnimationFrame(animateVinyl)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKey)

  if (audio.value) {
    audio.value.removeEventListener('timeupdate', syncAudioState)
    audio.value.removeEventListener('loadedmetadata', syncAudioState)
    audio.value.removeEventListener('durationchange', syncAudioState)
    audio.value.removeEventListener('ended', handleAudioEnded)
    audio.value.pause()
    audio.value = null
  }

  if (animationFrameId !== null) {
    window.cancelAnimationFrame(animationFrameId)
  }
})
</script>

<style scoped>
.arm {
  transform-origin: top center;
  transform: rotate(0deg);
  transition: transform 1.3s ease;
}

.arm.play {
  transform: rotate(85deg);
}
</style>
