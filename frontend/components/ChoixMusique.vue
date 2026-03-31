<template>
  <div class="fixed inset-0 z-30 flex items-center justify-center bg-black/28 px-4 py-6 backdrop-blur-[15px]">
    <section
        class="card-juke flex h-[min(160px,calc(100dvh-3rem))] w-full max-w-[429px] items-center justify-center rounded-[24px] px-6 py-8 text-center shadow-[0_10px_28px_rgba(120,85,57,0.22)]">
      <div class="w-full">
        <h2 class="font-arima text-[34px] font-extrabold leading-none text-black sm:text-[40px]">
          Choix musique
        </h2>
        <div class="flex flex-row gap-4">
          <div class="mt-4 w-full">
            <p class="mb-2 min-h-[24px] font-mulish text-[22px] font-black leading-none text-black">
              {{ selectedLetter }}
            </p>
            <div class="bg-black h-[1px] w-full" />
          </div>
          <div class="mt-4 w-full">
            <p class="mb-2 min-h-[24px] font-mulish text-[22px] font-black leading-none text-black">
              {{ selectedNumber }}
            </p>
            <div class="bg-black h-[1px] w-full" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  selectedLetter: string
  selectedNumber: string
}>()
</script>

<style scoped>
.card-juke {
  background-color: rgb(176 137 104 / 50%);
}
</style>
