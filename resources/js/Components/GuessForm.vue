<template>
    <div class="fixed inset-0 w-full h-full flex bg-blue-100 items-center justify-center wordle-buster-wrapper">
        <div class="bg-white rounded-lg shadow p-4 guess-wrapper" x-data="app()">
            <h2 class="font-thin px-2 pb-4 text-lg guess-label">
                Enter your guess here
            </h2>

            <guess-grid
                :guesses="guesses"
                @letter-updated="handleLetterUpdate"
                @result-updated="handleResultUpdate"
            />

            <submit-button @submit="submitGuesses" />

            <word-counter :count="count" />

            <error-alert v-if="error" />

            <results-display
                v-if="options"
                :options="options"
                :best-guess="bestGuess"
            />
        </div>
    </div>
</template>

<script>
import GuessGrid from './GuessGrid.vue';
import SubmitButton from './SubmitButton.vue';
import WordCounter from './WordCounter.vue';
import ErrorAlert from './ErrorAlert.vue';
import ResultsDisplay from './ResultsDisplay.vue';

export default {
    name: 'WordleBuster',

    components: {
        GuessGrid,
        SubmitButton,
        WordCounter,
        ErrorAlert,
        ResultsDisplay
    },

    data() {
        return {
            guesses: [this.createEmptyGuessRow()],
            error: false,
            count: 6016,
            bestGuess: null,
            options: null
        };
    },

    methods: {
        createEmptyGuessRow() {
            return Array(5).fill().map(() => ({
                value: '',
                result: '',
                alert: false
            }));
        },

        handleLetterUpdate({ guessIndex, letterIndex, value }) {
            this.guesses[guessIndex][letterIndex].value = value;
            this.guesses[guessIndex][letterIndex].alert = false;
        },

        handleResultUpdate({ guessIndex, letterIndex, result }) {
            this.guesses[guessIndex][letterIndex].result = result;
            this.guesses[guessIndex][letterIndex].alert = false;
        },

        submitGuesses() {
            if (this.validateGuesses()) {
                axios.post('/guess', { guess: this.guesses })
                    .then(response => {
                        this.processGuessResponse(response.data);
                    })
                    .catch(error => {
                        console.error('Error submitting guess:', error);
                    });
            }
        },

        processGuessResponse(data) {
            if (this.guesses.length < 6) {
                this.guesses.push(this.createEmptyGuessRow());
            }

            this.count = data.count;
            this.bestGuess = data.best_guess;
            this.options = data.options;
        },

        validateGuesses() {
            this.error = false;
            this.clearAllAlerts();

            this.guesses.forEach(guess => {
                guess.forEach(letter => {
                    if (letter.value === '' || letter.result === '') {
                        this.error = true;
                        letter.alert = true;
                    }
                });
            });

            return !this.error;
        },

        clearAllAlerts() {
            this.guesses.forEach(guess => {
                guess.forEach(letter => {
                    letter.alert = false;
                });
            });
        }
    }
};
</script>

<style>
.guess-wrapper {
    padding-bottom: 0;
    position: relative;
}

.guess-label {
    position: relative;
}

.guess-label span {
    position: absolute;
    right: 10px;
    top: 5px;
}

@media only screen and (max-width: 1200px) {
    .fixed {
        min-height: 100vh;
        position: relative;
    }

    .wordle-buster-wrapper {
        padding: 15px;
    }

    .guess-wrapper {
        padding-bottom: 15px;
        position: relative;
    }
}
</style>
