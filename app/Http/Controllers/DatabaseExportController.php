<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DatabaseExportController extends Controller
{
    public function export()
    {
        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');
        $dumpFile = storage_path("app/{$databaseName}_" . date('Y-m-d_H-i-s') . ".sql");

        // Create the mysqldump command
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($databaseName),
            escapeshellarg($dumpFile)
        );

        // Execute the command
        $process = Process::fromShellCommandline($command);
        $process->run();

        // Check if the process failed
        if (!$process->isSuccessful()) {
      
            throw new ProcessFailedException($process);
        }

        // Download the file
        return response()->download($dumpFile)->deleteFileAfterSend(true);
    }

}
