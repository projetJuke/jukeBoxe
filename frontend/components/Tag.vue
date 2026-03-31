<template>
  <section
      class="card-juke -translate-x-[36px] w-full max-w-[400px] rounded-xl px-5 py-6 shadow-md shadow-black/10 xl:h-[min(750px,calc(100dvh-4rem))]"
  >
    <img
        src="/images/1.jpg"
        alt="Theodora"
        class="mx-auto block aspect-[6/5] w-full max-w-[300px] rounded-xl object-cover shadow-md shadow-black/20"
    >
    <div class="flex flex-col items-center text-center">
      <h1 class="mt-6 font-arima text-4xl font-bold uppercase leading-tight text-black sm:text-5xl">
        Theodora
      </h1>
      <p class="mt-3 font-mulish text-base text-black sm:text-lg">
        Ils me rient tous au nez
      </p>
      <p class="mt-6 font-arima text-4xl font-bold text-black sm:text-5xl">
        A1
      </p>
      <div>
        <div class="bg-black/25 w-[300px] h-[10px] rounded-3xl">
          <div
              class="bg-black h-full rounded-3xl"
              :style="{ width: `${progressPercent}%` }">
          </div>
        </div>
        <div class="flex flex-row items-center justify-between mt-2 w-[300px] text-sm text-black/70">
          <p>
            {{ formatTime(currentTime) }}
          </p>
          <p>
            {{ formatTime(duration) }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup lang="ts">
const currentTime = useState('player-current-time', () => 0)
const duration = useState('player-duration', () => 0)

const progressPercent = computed(() => {
  if (!duration.value) {
    return 0
  }

  return Math.min((currentTime.value / duration.value) * 100, 100)
})

function formatTime(value: number) {
  if (!Number.isFinite(value) || value < 0) {
    return '0:00'
  }

  const minutes = Math.floor(value / 60)
  const seconds = Math.floor(value % 60)

  return `${minutes}:${seconds.toString().padStart(2, '0')}`
}

</script>
<style scoped>
.card-juke {
  background-color: rgb(176 137 104 / 50%);
}
</style>
