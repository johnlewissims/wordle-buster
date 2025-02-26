<template>
    <div class="letter">
        <input
            ref="letterInput"
            class="h-16 w-16 border mx-2 rounded-lg flex items-center text-center font-bold text-3xl uppercase"
            :class="getResultClass(letter.result)"
            :value="letter.value"
            @input="handleInput($event)"
            maxlength="1"
            @keyup="handleKeyUp($event)"
        >
        <letter-result-buttons
            :selected="letter.result"
            @select="handleResultSelect"
        />
        <alert-indicator v-if="letter.alert" />
    </div>
</template>

<script>
import LetterResultButtons from './LetterResultButtons.vue';
import AlertIndicator from './AlertIndicator.vue';

export default {
    name: 'GuessLetter',

    components: {
        LetterResultButtons,
        AlertIndicator
    },

    props: {
        letter: {
            type: Object,
            required: true
        },
        guessIndex: {
            type: Number,
            required: true
        },
        letterIndex: {
            type: Number,
            required: true
        }
    },

    methods: {
        getResultClass(result) {
            if (!result) return '';
            return `result${result}`;
        },

        handleInput(event) {
            this.$emit('value-change', event.target.value);
        },

        handleResultSelect(result) {
            this.$emit('result-change', result);
        },

        handleKeyUp(event) {
            const key = event.key;

            if (key === 'Backspace' && this.letter.value === '') {
                this.$emit('navigate', {
                    direction: 'prev',
                    guessIndex: this.guessIndex,
                    letterIndex: this.letterIndex
                });
            } else if (key.match(/[a-zA-Z]/) && key.length === 1) {
                this.$emit('navigate', {
                    direction: 'next',
                    guessIndex: this.guessIndex,
                    letterIndex: this.letterIndex
                });
            }
        }
    }
};
</script>

<style scoped>
.letter {
    position: relative;
}

.result1 {
    background: green;
    color: #fff;
}

.result2 {
    background: grey;
    color: #fff;
}

.result3 {
    background: #c9b458;
    color: #fff;
}

@media only screen and (max-width: 1200px) {
    .w-16 {
        width: 3rem;
    }
}
</style>
