<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function index()
    {
        $client = $this->getClient();
        $service = new Drive($client);
        $folderId = $this->getFolderId();

        // Daftar semua file di dalam folder
        $optParams = [
            'q' =>  " '" . $folderId . "' in parents",
            'pageSize' => 10, // Jumlah file yang ditampilkan per halaman
            'fields' => 'nextPageToken, files(id, name)' // Kolom yang ingin diambil
        ];

        try {
            // Mengambil file dan folder dari folder menggunakan Google API Client
            $results = $service->files->listFiles($optParams);
            $items = $results->getFiles(); // Ambil daftar item (folder dan file)

            if (count($items) == 0) {
                return response()->json(['message' => 'Tidak ada file atau folder ditemukan']);
            } else {
                return view('google_drive', ['items' => $items]); // Kirim data ke view
            }
        } catch (\Exception $e) {
            // Penanganan kesalahan
            return response()->json(['error' => $e->getMessage()], 500); // Kembalikan pesan kesalahan
        }
    }


    public function downloadFile($fileId)
    {
        $client = $this->getClient();
        $service = new Drive($client);

        try {
            // Mengambil file dari Google Drive
            $response = $service->files->get($fileId, ['alt' => 'media']);
            $content = $response->getBody()->getContents();

            // Mendapatkan nama file dari response
            $fileName = $this->getFileName($fileId, $service);

            // Mengembalikan response untuk download
            return response($content, 200)
                ->header('Content-Type', $this->getMimeType($fileName))
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Fungsi untuk mendapatkan nama file
    private function getFileName($fileId, $service)
    {
        try {
            $file = $service->files->get($fileId);
            return $file->getName();
        } catch (\Exception $e) {
            return 'downloaded_file'; // Jika gagal, gunakan nama default
        }
    }

    // Fungsi untuk mendapatkan MIME Type berdasarkan ekstensi file
    private function getMimeType($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'apk' => 'application/vnd.android.package-archive',
            // Tambahkan tipe MIME lainnya jika diperlukan
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream'; // Default MIME type
    }
    private function getClient()
    {
        // Konfigurasi Google Drive API tanpa autentikasi
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setDeveloperKey(config('services.google.api_key'));

        $client->setScopes(['https://www.googleapis.com/auth/drive.readonly']);
        // $client->addScope(Drive::DRIVE_READONLY);
        return $client;
    }

    private function getFolderId()
    {
        return config('services.google.folder_id');
    }
}