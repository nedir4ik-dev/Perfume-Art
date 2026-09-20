<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Symfony\Component\Console\Output\BufferedOutput;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk('local');

        // Ähli bukjalardaky faýllary süzüp alýarys
        $allFiles = $disk->allFiles();

        $backups = [];
        foreach ($allFiles as $file) {
            // Diňe zip faýllaryny we proýekt nusgalaryny saýlaýarys
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $backups[] = [
                    'file_name' => basename($file),
                    'full_path' => $file,
                    'file_size' => round($disk->size($file) / 1024 / 1024, 2) . ' MB',
                    'last_modified' => Carbon::createFromTimestamp($disk->lastModified($file))->format('d.m.Y H:i:s'),
                ];
            }
        }

        // Senesine görä iň täzesini ýokarda görkezmek
        usort($backups, function ($a, $b) {
            return strtotime($b['last_modified']) - strtotime($a['last_modified']);
        });

        return view('admin.backup.index', compact('backups'));
    }

    public function create(Request $request)
    {
        // Howpsuzlyk kody barlagy
        if ($request->security_code !== 'nedir4ik') {
            return back()->with('error', 'Invalid security code!');
        }

        $outputLog = new BufferedOutput;

        try {
            // PARAMETR ÜÝTGEDI: '--only-db' => true aýryldy, indi doly proýekti alar
            $exitCode = Artisan::call('backup:run', [], $outputLog);

            // Eger Artisan komandasy hata bilen tamamlanan bolsa
            if ($exitCode !== 0) {
                return back()->with('error', 'Backup failed. Terminal output: ' . $outputLog->fetch());
            }

            return back()->with('success', 'Full backup created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'System error: ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        // Faýlyň adyny däl, doly ýoluny query-den alýarys
        $path = $request->query('file');
        $disk = Storage::disk('local');

        if ($path && $disk->exists($path)) {
            return $disk->download($path);
        }

        return back()->with('error', 'File not found!');
    }

    public function clean()
    {
        $disk = Storage::disk('local');
        $allFiles = $disk->allFiles();
        $deletedCount = 0;

        foreach ($allFiles as $file) {
            // Diňe zip faýllary barlaýarys
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $lastModified = Carbon::createFromTimestamp($disk->lastModified($file));

                // Eger faýl 7 günden köne bolsa, ony poz
                if ($lastModified->diffInDays(Carbon::now()) > 7) {
                    $disk->delete($file);
                    $deletedCount++;
                }
            }
        }

        return $deletedCount;
    }
}
