<template>
    <div class="count-box font-normal px-2">
        <transition name="slide-fade" mode="out-in" class="count-number">
            <div :key="count" class="font-bold px-2">
                {{ count }}
            </div>
        </transition>
        <span class="font-thin px-2">Possible Answers</span>
    </div>
</template>

<script>
export default {
    name: 'WordCounter',

    props: {
        count: {
            type: Number,
            required: true
        }
    }
};
</script>

<style scoped>
    .count-box {
        text-align: center;
        position: absolute;
        bottom: -55px;
        left: 0;
        padding: 15px;
        right: 0;
        display: flex;
        justify-content: center;
    }

    .slide-fade-enter-active {
        transition: all 0.3s ease;
    }

    .slide-fade-leave-active {
        transition: all 0.4s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-fade-enter, .slide-fade-leave-to {
        opacity: 0;
    }

    .count-number {
        padding-right: 5px;
    }

    @media only screen and (max-width: 1200px) {
        .count-box {
            position: relative;
            bottom: 0;
        }
    }
</style>
