<template>
    <!-- Card 1 -->
    <div
        class=" bg-white/20 p-6 rounded-md shadow-sm cursor-pointer border-2 border-gray-50 hover:border-black hover:border-2 transition-colors duration-300">
        <h2 class="text-xl font-semibold mb-4">{{note.judul}}</h2>
        <p class="text-gray-700">{{note.catatan}}</p>
    </div>
    <!-- Card1 -->
</template>
<script>
export default {
  props: {
    note: Object, // Menerima data note dari parent
  },
};
</script>