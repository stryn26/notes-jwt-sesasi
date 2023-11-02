<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';
import cardComponent from '../../components/cardComponent.vue';

const notes = ref([]);

const fetchDataPosts = async () => {
  try {
    const token = localStorage.getItem('token');
    const config = {
      headers: {
        'Authorization': `Bearer ${token}`,
      },
    };

    // Fetch data
    const response = await api.get('/notes/', config);
    notes.value = response.data.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
}

onMounted(() => {
  fetchDataPosts();
});
</script>

<template>
  <div class="bg-gray-100 flex items-center justify-center lg:h-screen py-16">
    <div class="w-11/12 sm:w-11/12 md:w-8/12 lg:w-6/12 bg-white p-6 rounded-lg shadow-sm">
      <div class="w-full flex justify-between items-center p-3">
        <h2 class="text-xl font-semibold">My Notes</h2>
      </div>
      <div class="w-full flex justify-center p-1 mb-4">
        <div class="relative w-full">
          <input type="text"
            class="w-full bg-white py-2 pl-10 pr-4 rounded-lg focus:outline-none border-2 border-gray-100 focus:border-black transition-colors duration-300"
            placeholder="Search...">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">
        <div v-if="notes.length > 0">
          <div v-for="note in notes" :key="note.id">
            <cardComponent :note="note" />
          </div>
        </div>
        <div v-else>
          <div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
            <svg class="w-5 h-5 inline mr-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
            </svg>
            <div>
              <span class="font-medium">Data Tidak Ditemukan!</span>.
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</template>
