<template>
  <span class="flex h-3 w-3 ping-alert">
    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
  </span>
</template>

<script>
    export default {
        name: 'AlertIndicator'
    };
</script>

<style scoped>
    .ping-alert {
        position: absolute;
        top: -4px;
        right: 2px;
    }
</style>
