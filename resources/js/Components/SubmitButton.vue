<template>
    <div class="font-thin px-2 text-md pb-4 submit-label">
        <span>Add Row</span>
        <button @click="$emit('submit')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</template>

<script>
export default {
    name: 'SubmitButton'
};
</script>

<style scoped>
.submit-label {
    position: relative;
    text-align: right;
    padding-right: 0;
    padding-top: 3px;
    font-style: italic;
    margin-top: 35px;
}

.submit-label span {
    position: absolute;
    right: 25px;
    top: 5px;
}

.submit-label button {
    margin-top: 3px;
    cursor: pointer;
}
</style>
