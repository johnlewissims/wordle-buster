<template>
    <div>
        <div
            v-for="(guess, guessIndex) in guesses"
            :key="guessIndex"
            class="guess-row flex justify-center"
            :class="`guess-row-${guessIndex}`"
        >
            <guess-letter
                v-for="(letter, letterIndex) in guess"
                :key="letterIndex"
                :letter="letter"
                :guess-index="guessIndex"
                :letter-index="letterIndex"
                :ref="`letter-${guessIndex}-${letterIndex}`"
                @value-change="(value) => updateLetterValue(guessIndex, letterIndex, value)"
                @result-change="(result) => updateLetterResult(guessIndex, letterIndex, result)"
                @navigate="handleNavigation"
            />
        </div>
    </div>
</template>

<script>
import GuessLetter from './GuessLetter.vue';

export default {
    name: 'GuessGrid',

    components: {
        GuessLetter
    },

    props: {
        guesses: {
            type: Array,
            required: true
        }
    },

    methods: {
        updateLetterValue(guessIndex, letterIndex, value) {
            this.$emit('letter-updated', { guessIndex, letterIndex, value });
        },

        updateLetterResult(guessIndex, letterIndex, result) {
            this.$emit('result-updated', { guessIndex, letterIndex, result });
        },

        handleNavigation({ direction, guessIndex, letterIndex }) {
            let nextLetterIndex;

            if (direction === 'next' && letterIndex < 4) {
                nextLetterIndex = letterIndex + 1;
            } else if (direction === 'prev' && letterIndex > 0) {
                nextLetterIndex = letterIndex - 1;
            } else {
                return;
            }

            const refName = `letter-${guessIndex}-${nextLetterIndex}`;
            const letterComponent = this.$refs[refName]?.[0];

            if (letterComponent) {
                letterComponent.$refs.letterInput.focus();
            }
        }
    }
};
</script>

<style scoped>
.guess-row {
    margin-top: 40px;
}

.guess-row-0 {
    margin-top: 0;
}
</style>
