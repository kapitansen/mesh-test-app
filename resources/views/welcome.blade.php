<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="//unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="flex justify-center mt-8">
                <div class="max-w-2xl rounded-lg bg-gray-50">
                    <div class="flex flex-col m-4 min-h-32">
                        @if ($upload == 'success')
                            <label class="inline-block mb-2 text-gray-500">Upload OK. </label>
                            <div class="text-bold text-sm">Path: {{ $path }}</div>
                            <div class="progress-container flex flex-col">
                                <div class="import-progress text-xs text-gray-600 mt-2">Import has started. See console for an echo example.</div>
                                <div id="dots" class="import-progress text-gray-400 text-xs w-64 break-all" style="overflow-wrap: anywhere; line-height: 0.3;margin: 0.55rem auto;"></div>
                                <a href="/index" class="text-center w-full px-4 mt-2 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded shadow-xl">Go to rows list</a>
                            </div>
                            <script>
                                Echo.channel('{{ $filename }}')
                                    .listen('CreateRow', (e) => {
                                        console.log('new row created: ' + e.row.name + ', ' + e.row.date);
                                        document.getElementById('dots').innerHTML += '.';
                                    });
                            </script>
                        @endif
                        @if ($upload == 'none')
                            <form action="/" method="post" enctype="multipart/form-data">
                                @csrf
                                <label class="inline-block mb-2 text-gray-500">
                                    @error('file')
                                    Error
                                    @else
                                        File Upload
                                        @enderror
                                </label>
                                @error('file')<p class="text-sm text-red-400 mb-2">{{ $message }} Try again.</p>@enderror
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        x-data="{ files: [] }"
                                        class="flex flex-col w-full border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300">
                                        <div class="flex flex-col items-center justify-center pt-7">
                                            <svg x-show="files.length === 0" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600" x-text="files.length === 0 ? 'Attach a file' : files.map(file => file.name).join(', ')"></p>
                                        </div>
                                        <input type="file" name="file" x-on:change="files = Object.values($event.target.files)" class="opacity-0" />
                                    </label>
                                </div>
                                <div class="flex justify-center mt-4">
                                    <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded shadow-xl">Upload</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
