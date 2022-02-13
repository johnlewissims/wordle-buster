<template> 
    <div>
        <div class="fixed inset-0 w-full h-full flex bg-blue-100 items-center justify-center">
            <div class="bg-white rounded-lg shadow p-4 guess-wrapper" x-data="app()">
                <div class="font-thin px-2 pb-4 text-lg guess-label">
                    Enter your guess here
                    <button @click="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="flex">
                    <div class="letter" v-for="(letter, index) in letters" :key="index">
                        <input 
                            class="h-16 w-16 border mx-2 rounded-lg flex items-center text-center font-bold text-3xl uppercase"
                            :class="'result' + letter.result"
                            v-model="letter.value"
                        >
                        <div class="button-wrapper">
                            <button @click="letter.result = 1" :class="(letter.result === 1) ? 'button-active' : 'button-inactive'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button @click="letter.result = 2" :class="(letter.result === 2) ? 'button-active' : 'button-inactive'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </button>
                            <button @click="letter.result = 3" :class="(letter.result === 3) ? 'button-active' : 'button-inactive'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                        <span class="flex h-3 w-3 ping-alert" v-if="letter.alert">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                    </div>
                </div>

                <div v-if="error" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 alert" role="alert">
                    <p class="font-bold">Almost!</p>
                    <p>Make sure you have a letter and a result in each field.</p>
                </div>

            </div>

        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                'letters': [
                    {'value': '', 'result': '', 'alert': false},
                    {'value': '', 'result': '', 'alert': false},
                    {'value': '', 'result': '', 'alert': false},
                    {'value': '', 'result': '', 'alert': false},
                    {'value': '', 'result': '', 'alert': false}
                ],
                "error": false
            };
        },
        methods: {
            submit() {
                this.error = false;
                this.letters.forEach(letter => {
                    letter.alert = false;
                    if(letter.value == '' || letter.result == '') {
                        this.error = true;
                        letter.alert = true;
                    }
                });
            }
        }
    };
</script>

<style scoped>

.guess-wrapper {
    padding-bottom: 41px;
    position: relative;
}

.letter {
    position: relative;   
}

.letter .button-wrapper {
    position: absolute;
    bottom: -35px;
    left: 4px;    
}

.button-wrapper button {
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

.guess-label button {
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
    bottom: -120px;
    left: 0px;
    width: 100%;
    transition: all .2s ease;
}

.ping-alert {
    position: absolute;
    top: -4px;
    right: 2px;
}

</style>