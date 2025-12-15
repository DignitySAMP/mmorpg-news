<script setup lang="ts"/>

<template>
    <div class="z-0 top-0 absolute w-screen h-screen overflow-hidden">
        <div class="relative h-300">

            <img src="hero_2.webp" class="w-screen h-full object-cover object-center blur-xs"/>
            <div class="absolute -bottom-1 bg-linear-to-t from-black to-transparent h-96 w-screen"/>
        </div>
    </div>

    <div class="flex flex-col gap-8">
        <header class="z-10 mt-4 relative border-y-4 bg-stone-900 border-stone-700 shadow-md" >
            <div class="relative mx-auto max-w-7xl px-4 py-2">
                <div class="flex items-center justify-between">
                    <div class="size-8 bg-stone-800 rounded-full p-5 flex justify-center items-center">
                        <span class="text-stone-100">L</span>
                    </div>

                    <nav class="hidden items-center gap-6 md:flex">
                        <ul class="flex gap-8">
                            <li class="bg-stone-800 hover:bg-stone-700 px-6 py-1 hover:scale-105 hover:rotate-0 transition duration-300 text-stone-100 shadow-md hover:shadow-none cursor-pointer"  v-for="x, y in 5" :key="y">
                                Link
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="z-10 min-h-lg text-stone-300 bg-stone-800 border-y-4 border-stone-700 border-x container mx-auto max-w-9xl p-6">
            <p>
                <span class="px-2 py-1 text-center text-lg bg-stone-700 border border-stone-600">
                    L
                </span>
                orem ipsum, dolor sit amet consectetur adipisicing elit. Quae nihil exercitationem incidunt ipsa asperiores commodi, culpa id reprehenderit pariatur atque, voluptates aliquid, sapiente eius iure debitis harum non quis quisquam illum quibusdam minima quidem enim ipsum nam? Animi esse ducimus, officia, itaque doloremque cupiditate error laboriosam quidem unde vitae eligendi.
            </p>
        </main>
    </div>
    

</template>