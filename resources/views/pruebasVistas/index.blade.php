
<x-app-layout>
<h1 style="color:white; text-align: center; font-weight: bold;">Esto es una prueba de del index para ver si funciona</h1>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST">
                        @csrf
                        <textarea name="mensaje" style="background-color: white; width: 100%; border-radius: 8px; box-shadow: 2px 2px 5px 0px rgba(1,0,69,1);"
                        placeholder="¿Qué estás pensando?"></textarea>
                        <x-primary-button class="">Home Alabama</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>