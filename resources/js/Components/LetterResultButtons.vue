<template>
    <div class="button-wrapper">
    <span
        @click="$emit('select', 1)"
        :class="selected === 1 ? 'button-active' : 'button-inactive'"
        title="Correct position"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </span>
        <span
            @click="$emit('select', 2)"
            :class="selected === 2 ? 'button-active' : 'button-inactive'"
            title="Not in word"
        >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
      </svg>
    </span>
        <span
            @click="$emit('select', 3)"
            :class="selected === 3 ? 'button-active' : 'button-inactive'"
            title="Wrong position"
        >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </span>
    </div>
</template>

<script>
export default {
    name: 'LetterResultButtons',

    props: {
        selected: {
            type: [Number, String],
            default: ''
        }
    }
};
</script>

<style scoped>
    .button-wrapper {
        display: flex;
        position: absolute;
        bottom: -35px;
        left: 4px;
    }

    .button-wrapper span {
        transition: all 0.3s ease;
        opacity: 0.3;
        cursor: pointer;
    }

    .button-inactive {
        opacity: 0.3;
    }

    .button-active {
        opacity: 1;
    }

    @media only screen and (max-width: 1200px) {
        .w-6 {
            width: 1rem;
        }

        .button-wrapper {
            bottom: -30px;
            left: 10px;
        }
    }
</style>
