<template>
    <div class="answers-box bg-white rounded-lg shadow p-4">
        <div class="font-thin px-2 pb-4 text-lg">
            <h4 class="font-bold">Most likely answers...</h4>
            <p>
                <span v-for="(option, index) in options" :key="index">{{ option.word }}</span>
            </p>
            <hr class="my-4">
            <h4 class="font-bold">Best answers for narrowing down options...</h4>
            <p>
                <span v-for="(guess, index) in bestGuess" :key="index">{{ guess.word }}</span>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ResultsDisplay',

    props: {
        options: {
            type: Array,
            required: true
        },
        bestGuess: {
            type: Array,
            required: true
        }
    }
};
</script>

<style scoped>
    .answers-box {
        position: absolute;
        right: -100%;
        top: 0;
        width: 95%;
    }

    .answers-box span {
        padding-right: 5px;
        display: inline-block;
    }

    @media only screen and (max-width: 1200px) {
        .answers-box {
            position: relative;
            right: 0;
            width: 100%;
        }
    }
</style>
