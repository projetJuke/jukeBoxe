<template>
  <article class="card-juke flex min-h-[56px] w-full items-center rounded-[14px] px-2.5 py-2 shadow-[0_4px_10px_rgba(0,0,0,0.18)]">
    <img
      src="/images/1.jpg"
      alt="Theodora"
      class="block h-[42px] w-[42px] rounded-[10px] object-cover"
    >
    <div class="ml-3 min-w-0 flex-1">
      <h2 class="truncate font-mulish text-[20px] font-black uppercase leading-none text-black">
        Theodora
      </h2>
      <p class="mt-1 truncate font-mulish text-[12px] leading-none text-black/75">
        Ils me rient tous au nez
      </p>
    </div>
    <div class="ml-3 flex flex-col items-end justify-center">
      <span class="font-mulish text-[16px] font-black leading-none text-black">A1</span>
      <span class="mt-2 font-mulish text-[12px] leading-none text-black/70">3:22</span>
    </div>
  </article>
</template>
<script setup lang="ts">

</script>

<style scoped>
.card-juke {
  background-color: #c49e7c;
}
</style>
