<template>
  <div v-if="error" class=" mt-2 bg-red-100 border-l-4 border-red-500 text-red-700 p-1 text-xs" role="alert">
      <p>{{ error }}</p>
  </div>
</template>

<script>
  export default {
    props: ["error"]
  }
</script>