<template>
    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 alert" role="alert">
        <p class="font-bold">Almost!</p>
        <p>Make sure you have a letter in each field.</p>
    </div>
</template>

<script>
export default {
    name: 'ErrorAlert'
};
</script>

<style scoped>
    .alert {
        position: absolute;
        bottom: -90px;
        left: 0;
        width: 100%;
        transition: all 0.2s ease;
    }
</style>
