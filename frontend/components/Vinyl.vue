<template>
  <div class="flex w-full items-center justify-center">
    <div
      :class="['relative h-[clamp(220px,39.06vw,750px)] w-[clamp(220px,39.06vw,750px)] shrink-0 disk-shell', diskStage]"
    >
      <div
        class="relative h-full w-full"
        :style="{ transform: `rotate(${vinylRotation}deg)` }"
      >
        <img
          src="/images/vinyl.png"
          alt="Vinyle"
          class="block h-full w-full object-contain"
        >
        <img
          :src="currentTrack.cover"
          alt="Pochette album"
          class="absolute left-1/2 top-1/2 h-[38%] w-[38%] -translate-x-1/2 -translate-y-1/2 rounded-full object-cover"
        >
      </div>
    </div>
    <img
        src="/images/barre.png"
        alt="Barre"
        :class="['block h-[clamp(160px,28.33vw,544px)] w-[clamp(15px,2.6vw,50px)] shrink-0 object-contain arm', { play: isPlaying, lift: isChangingTrack }]"
    >
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue'

const isPlaying = ref(false)
const vinylRotation = ref(0)
const audio = ref<HTMLAudioElement | null>(null)
const currentTime = useState('player-current-time', () => 0)
const duration = useState('player-duration', () => 0)
const waveform = useState('player-waveform', () => Array.from({ length: 24 }, () => 6))
const pauseRequest = useState('player-pause-request', () => 0)
const trackRequestCode = useState('player-track-request-code', () => '')
const trackRequestId = useState('player-track-request-id', () => 0)

const maxSpeed = 45
const transitionDuration = 1300
const waveformMinHeight = 8
const waveformMaxHeight = 42
const diskSwapDuration = 550

const fallbackTrack = {
  code: 'A1',
  src: '/audio/1.mp3',
  cover: '/images/1.jpg'
}

const trackMap: Record<string, typeof fallbackTrack> = {
  A1: fallbackTrack
}

let animationFrameId: number | null = null
let lastFrameTime = 0
let currentSpeed = 0
let targetSpeed = 0
let audioContext: AudioContext | null = null
let analyser: AnalyserNode | null = null
let sourceNode: MediaElementAudioSourceNode | null = null
let frequencyData: Uint8Array | null = null
const currentTrack = ref(fallbackTrack)
const diskStage = ref<'idle' | 'out' | 'in'>('idle')
const isChangingTrack = ref(false)

function wait(ms: number) {
  return new Promise((resolve) => {
    window.setTimeout(resolve, ms)
  })
}

function resetWaveform() {
  waveform.value = Array.from({ length: 24 }, () => 6)
}

function ensureAudioAnalyser() {
  if (!audio.value || analyser) {
    return
  }

  const AudioContextClass = window.AudioContext || (window as typeof window & { webkitAudioContext?: typeof AudioContext }).webkitAudioContext

  if (!AudioContextClass) {
    return
  }

  audioContext = new AudioContextClass()
  analyser = audioContext.createAnalyser()
  analyser.fftSize = 128
  analyser.smoothingTimeConstant = 0.82
  frequencyData = new Uint8Array(analyser.frequencyBinCount)

  sourceNode = audioContext.createMediaElementSource(audio.value)
  sourceNode.connect(analyser)
  analyser.connect(audioContext.destination)
}

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
  resetWaveform()
}

function handleKey(e: KeyboardEvent) {
  if (e.key.toLowerCase() === 'p') {
    togglePlayback()
  }
}

async function togglePlayback() {
  if (!audio.value || isChangingTrack.value) {
    return
  }

  if (isPlaying.value) {
    pausePlayback()
    return
  }

  try {
    ensureAudioAnalyser()

    if (audioContext?.state === 'suspended') {
      await audioContext.resume()
    }

    await audio.value.play()
    isPlaying.value = true
    targetSpeed = maxSpeed
  } catch (error) {
    console.error('Lecture audio impossible', error)
  }
}

function pausePlayback() {
  if (!audio.value) {
    return
  }

  audio.value.pause()
  isPlaying.value = false
  targetSpeed = 0
  resetWaveform()
}

function loadTrack(trackCode: string) {
  if (!audio.value) {
    return
  }

  const nextTrack = trackMap[trackCode] ?? {
    code: trackCode,
    src: fallbackTrack.src,
    cover: fallbackTrack.cover
  }

  currentTrack.value = nextTrack
  audio.value.src = nextTrack.src
  audio.value.load()
  currentTime.value = 0
  duration.value = 0
  resetWaveform()
}

async function runTrackChange(trackCode: string) {
  if (!audio.value || isChangingTrack.value) {
    return
  }

  isChangingTrack.value = true
  pausePlayback()
  await wait(transitionDuration)

  diskStage.value = 'out'
  await wait(diskSwapDuration)

  loadTrack(trackCode)
  diskStage.value = 'in'
  await wait(40)
  diskStage.value = 'idle'
  await wait(diskSwapDuration)

  isChangingTrack.value = false
  await wait(transitionDuration)
  await togglePlayback()
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

  if (isPlaying.value && analyser && frequencyData) {
    analyser.getByteFrequencyData(frequencyData)

    waveform.value = waveform.value.map((_, index) => {
      const dataIndex = Math.min(index * 2, frequencyData!.length - 1)
      const amplitude = frequencyData![dataIndex] / 255
      const boostedAmplitude = Math.min(Math.pow(amplitude, 0.7) * 1.45, 1)

      return waveformMinHeight + Math.round(boostedAmplitude * (waveformMaxHeight - waveformMinHeight))
    })
  }

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

watch(pauseRequest, () => {
  pausePlayback()
})

watch(trackRequestId, () => {
  if (!trackRequestCode.value) {
    return
  }

  runTrackChange(trackRequestCode.value)
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

  if (audioContext) {
    audioContext.close()
    audioContext = null
  }

  analyser = null
  sourceNode = null
  frequencyData = null
  resetWaveform()

  if (animationFrameId !== null) {
    window.cancelAnimationFrame(animationFrameId)
  }
})
</script>

<style scoped>
.disk-shell {
  transition:
    transform 950ms ease,
    opacity 950ms ease,
    filter 950ms ease;
}

.disk-shell.out {
  transform: translateY(-185%) scale(0.92);
  opacity: 0;
  filter: blur(3px);
}

.disk-shell.in {
  transform: translateY(185%) scale(0.m2);
  opacity: 0;
  filter: blur(3px);
}

.arm {
  transform-origin: top center;
  transform: rotate(0deg);
  transition: transform 1.3s ease;
}

.arm.lift {
  transform: rotate(-28deg);
}

.arm.play {
  transform: rotate(85deg);
}
</style>
