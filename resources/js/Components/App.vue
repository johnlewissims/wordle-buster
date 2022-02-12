<template> 
    <div>
        <div class="fixed inset-0 w-full h-full flex bg-blue-100 items-center justify-center">
            <div class="bg-white rounded-lg shadow p-4" x-data="app()">
                <div class="font-thin px-2 pb-4 text-lg">Enter your guess here</div>
                <div class="flex">
                    <input class="h-16 w-12 border mx-2 rounded-lg flex items-center text-center font-thin text-3xl" value="">
                    <input class="h-16 w-12 border mx-2 rounded-lg flex items-center text-center font-thin text-3xl" value="">
                    <input class="h-16 w-12 border mx-2 rounded-lg flex items-center text-center font-thin text-3xl" value="">
                    <input class="h-16 w-12 border mx-2 rounded-lg flex items-center text-center font-thin text-3xl" value="">
                    <input class="h-16 w-12 border mx-2 rounded-lg flex items-center text-center font-thin text-3xl" value="">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {};
</script>