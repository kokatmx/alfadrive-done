<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href=" {{ secure_asset('/img/favicon.png') }}" type="image/x-icon">
    <title>File Download</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="container mx-auto p-5 flex-grow">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-red-500 mb-2">Download Center</h1>
            <p class="text-lg text-blue-600">Pilih file yang ingin Anda unduh dari daftar di bawah</p>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="table w-full text-center">
                <thead class="bg-red-500 text-white">
                    <tr>
                        <th class="py-3 text-2xl">No</th>
                        <th class="py-3 text-2xl">Nama File</th>
                        <th class="py-3 text-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $file)
                        <tr class="hover:bg-yellow-50 transition-colors duration-200">
                            <td class="py-4 text-gray-800 text-lg">{{ $loop->iteration }}</td>
                            <td class="py-4 text-gray-800 text-lg font-semibold">{{ $file['name'] }}</td>
                            <td class="py-4">
                                <a href="{{ route('download', $file['id']) }}" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class=" md:inline w-5 h-5 mr-1 hidden" viewBox="0 0 20 20" fill="currentColor" >
                                        <path fill-rule="evenodd" d="M3 10a7 7 0 1114 0 7 7 0 01-14 0zm7-5a5 5 0 100 10A5 5 0 0010 5zm2 6a1 1 0 01-.707.293l-2-2a1 1 0 010-1.414l2-2a1 1 0 011.414 1.414L10.414 9H13a1 1 0 010 2h-3.586l1.293 1.293A1 1 0 0112 11z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="md:block sm:inline">
                                        Unduh
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center text-gray-600 py-4 mt-8">
        <p>&copy; {{ date('Y') }} Alfamart File Center</p>
    </footer>
</body>
</html>
