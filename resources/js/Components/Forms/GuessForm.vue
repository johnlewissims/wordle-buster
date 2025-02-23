<template>
    <div>
        <div class="fixed inset-0 w-full h-full flex bg-blue-100 items-center justify-center wordle-buster-wrapper">
            <div class="bg-white rounded-lg shadow p-4 guess-wrapper" x-data="app()">
                <div class="font-thin px-2 pb-4 text-lg guess-label">
                    Enter your guess here
                </div>
                <div class="">
                    <div class="guess-row flex" :class="'guess-row-' + guessIndex" v-for="(guess, guessIndex) in guesses" :key="guessIndex">
                        <div class="letter" v-for="(letter, index) in guess" :key="index">
                            <input
                                :ref="`input-${guessIndex}-${index}`"
                                class="h-16 w-16 border mx-2 rounded-lg flex items-center text-center font-bold text-3xl uppercase"
                                :class="'result' + letter.result"
                                v-model="letter.value"
                                maxlength="1"
                                @keyup="handleKeyUp($event, guessIndex, index)"
                            >
                            <div class="button-wrapper">
                                <span @click="letter.result = 1" :class="(letter.result === 1) ? 'button-active' : 'button-inactive'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <span @click="letter.result = 2" :class="(letter.result === 2) ? 'button-active' : 'button-inactive'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </span>
                                <span @click="letter.result = 3" :class="(letter.result === 3) ? 'button-active' : 'button-inactive'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <span class="flex h-3 w-3 ping-alert" v-if="letter.alert">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="font-thin px-2 text-md pb-4 submit-label">
                    <span>Add Row</span>
                    <button @click="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>


                <div class="count-box font-normal px-2">
                    <transition name="slide-fade" mode="out-in" class="count-number">
                        <div :key="count" class="font-bold px-2">
                            {{ count }}
                        </div>
                    </transition>
                    <span class="font-thin px-2">Possible Answers</span>
                </div>

                <div v-if="error" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 alert" role="alert">
                    <p class="font-bold">Almost!</p>
                    <p>Make sure you have a letter and a result in each field.</p>
                </div>

                <div class="answers-box bg-white rounded-lg shadow p-4" v-if="options">
                    <div class="font-thin px-2 pb-4 text-lg">
                        <h4 class="font-bold">Most likely answers...</h4>
                        <p><span v-for="(option, index) in options" :key="index"> {{option.word}} </span></p>
                        <hr style="margin-bottom: 15px; margin-top: 15px;">
                        <h4 class="font-bold">Best answers for narrowing down options...</h4>
                        <p><span v-for="(guess, index) in bestGuess" :key="index"> {{guess.word}} </span></p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                'guesses': [
                    [
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false}
                    ]
                ],
                'blankGuess': [
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false},
                        {'value': '', 'result': '', 'alert': false}
                ],
                "error": false,
                "count": 6016,
                "bestGuess": null,
                "options": null
            };
        },
        methods: {
            submit() {
                let error = this.verifyGuess();

                if(!error) {
                    axios.post('/guess', {'guess': this.guesses})
                        .then((response) => {
                            if(this.guesses.length < 6) {
                                this.guesses.push(JSON.parse(JSON.stringify(this.blankGuess)));
                            }

                            this.count = response.data.count;
                            this.bestGuess = response.data.best_guess;
                            this.options = response.data.options;
                        })
                }
            },
            verifyGuess() {
                this.error = false;
                this.guesses.forEach(guess => {
                    guess.forEach(letter => {
                        letter.alert = false;
                        if(letter.value == '' || letter.result == '') {
                            this.error = true;
                            letter.alert = true;
                        }
                    })
                });
                return this.error;
            },
            handleKeyUp(event, guessRowIndex, letterIndex) {
                const nextRef = `input-${guessRowIndex}-${letterIndex + 1}`;
                const prevRef = `input-${guessRowIndex}-${letterIndex - 1}`;
                const key = event.key;

                if (key === 'Backspace' && this.guesses[guessRowIndex][letterIndex].value === '') {
                    // Focus on the previous field if it exists
                    if (letterIndex > 0 && this.$refs[prevRef]) {
                        this.$refs[prevRef][0].focus();
                    }
                } else if (key.match(/[a-zA-Z]/) && key.length === 1) {
                    // Focus on the next field if it exists
                    if (letterIndex < this.guesses[guessRowIndex].length - 1 && this.$refs[nextRef]) {
                        this.$refs[nextRef][0].focus();
                    }
                }
            },
        }
    };
</script>

<style>

/*test again */
.guess-wrapper {
    padding-bottom: 0px;
    position: relative;
}

.letter {
    position: relative;
}

.letter .button-wrapper {
    display: flex;
    position: absolute;
    bottom: -35px;
    left: 4px;
}

.button-wrapper span {
    transition: all .3s ease;
    opacity: .3;
}

.button-wrapper .button-inactive {
    opacity: .3;
}

.button-wrapper .button-active {
    opacity: 1;
}

.guess-label {
    position: relative;
}

.guess-label span {
    position: absolute;
    right: 10px;
    top: 5px;
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
    background: #c9b458;;
    color: #fff;
}

.guess-wrapper .alert {
    position: absolute;
    bottom: -90px;
    left: 0px;
    width: 100%;
    transition: all .2s ease;
}

.ping-alert {
    position: absolute;
    top: -4px;
    right: 2px;
}

.guess-row {
    margin-top: 40px;
}

.guess-row-0 {
    margin-top: 0px;
}

.count-box {
    text-align: center;
    position: absolute;
    bottom: -55px;
    left: 0px;
    padding: 15px;
    right: 0px;
    display: flex;
    justify-content: center;
}

.slide-fade-enter-active {
    transition: all .3s ease;
}
.slide-fade-leave-active {
    transition: all .4s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to {
    opacity: 0;
}

.count-number {
    padding-right: 5px;
}

.answers-box {
    position: absolute;
    right: -100%;
    top: 0px;
    width: 95%;
}

.answers-box span {
    padding-right: 5px;
    display: inline-block;
}

.submit-label {
    position: relative;
    text-align: right;
    padding-right: 0px;
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
}

@media only screen and (max-width: 1200px) {
    .answers-box {
        position: relative;
        right: 0px;
        width: 100%;
    }
    .w-16 {
        width: 3rem;
    }
    .w-6 {
        width: 1rem;
    }
    .letter .button-wrapper {
        display: flex;
        position: absolute;
        bottom: -30px;
        left: 10px;
    }
    .fixed {
        min-height: 100vh;
        position: relative;
    }
    .count-box {
        position: relative;
        bottom: 0px;
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
