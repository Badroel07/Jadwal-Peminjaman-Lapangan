<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use Google\Service\Sheets\ValueRange;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = collect();

        try {
            $rows = Sheets::spreadsheet(config('google.post_spreadsheet_id'))
                ->sheet(config('google.post_sheet_name'))
                ->get();

            $today = now()->startOfDay();

            // Filter out empty rows, header row, and past dates
            $rows = $rows->filter(function ($row) use ($today) {
                if (empty(array_filter($row)))
                    return false;

                $firstVal = strtolower($row[0] ?? '');
                if (in_array($firstVal, ['timestamp', 'hari/tanggal', 'tanggal', 'hari']))
                    return false;

                $dateStr = $row[1] ?? null;
                if (!$dateStr)
                    return false;

                try {
                    // Force dd/mm/yyyy parsing for slash-separated dates
                    $bookingDate = str_contains($dateStr, '/')
                        ?\Illuminate\Support\Carbon::createFromFormat('d/m/Y', explode(' ', $dateStr)[0])->startOfDay()
                        : \Illuminate\Support\Carbon::parse($dateStr)->startOfDay();

                    return $bookingDate->greaterThanOrEqualTo($today);
                }
                catch (\Exception $e) {
                    return false;
                }
            })
                ->sortBy(function ($row) {
                try {
                    $dateStr = $row[1] ?? '';
                    $timeStr = $row[4] ?? '00:00';
                    $dt = str_contains($dateStr, '/')
                        ?\Illuminate\Support\Carbon::createFromFormat('d/m/Y', explode(' ', $dateStr)[0])
                        : \Illuminate\Support\Carbon::parse($dateStr);
                    return $dt->format('Y-m-d') . ' ' . $timeStr;
                }
                catch (\Exception $e) {
                    return $row[1] ?? '';
                }
            })
                ->map(function ($row) {
                if (isset($row[1])) {
                    try {
                        $dt = str_contains($row[1], '/')
                            ?\Illuminate\Support\Carbon::createFromFormat('d/m/Y', explode(' ', $row[1])[0])
                            : \Illuminate\Support\Carbon::parse($row[1]);
                        $row[1] = $dt->format('d/m/Y');
                    }
                    catch (\Exception $e) {
                    // keep original if parsing fails
                    }
                }
                return $row;
            });
        }
        catch (\Exception $e) {
        // Silently fail or log
        }

        return view('schedule.index', [
            'schedules' => $rows
        ]);
    }

    public function create()
    {
        return view('schedule.create');
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_berakhir' => 'required|after:waktu_mulai',
        ]);

        // Check for conflicts
        try {
            $existingBookings = Sheets::spreadsheet(config('google.post_spreadsheet_id'))
                ->sheet(config('google.post_sheet_name'))
                ->get();

            // Remove header
            if ($existingBookings->count() > 0) {
                $existingBookings->shift();
            }

            foreach ($existingBookings as $booking) {
                // Ensure row has enough columns
                if (count($booking) < 6)
                    continue;

                $existingDate = $booking[1]; // Column B
                $existingStart = $booking[4]; // Column E
                $existingEnd = $booking[5]; // Column F

                // Check date match
                if ($existingDate == $validated['tanggal']) {
                    // Check time overlap
                    // Rule: (StartA < EndB) and (EndA > StartB)
                    if ($validated['waktu_mulai'] < $existingEnd && $validated['waktu_berakhir'] > $existingStart) {
                        return back()->withErrors(['waktu_mulai' => 'Jadwal bentrok dengan peminjaman lain (' . $existingStart . ' - ' . $existingEnd . ')'])->withInput();
                    }
                }
            }

        }
        catch (\Exception $e) {
            // If we can't check, maybe proceed or warn? 
            // For safety, let's allow but maybe log. Ideally we should block if we can't verify.
            // But to avoid blocking valid usage on API error, we might skip check or return error. 
            // Let's return error to be safe.
            return back()->with('error', 'Gagal memverifikasi jadwal (API Error): ' . $e->getMessage())->withInput();
        }

        return view('schedule.confirm', ['data' => $validated]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_berakhir' => 'required|after:waktu_mulai',
        ]);

        try {
            // Append to Google Sheet
            // Order: Timestamp, Hari/Tanggal, Nama Peminjam, Nama Kegiatan, Waktu Mulai, Waktu Berakhir
            Sheets::spreadsheet(config('google.post_spreadsheet_id'))
                ->sheet(config('google.post_sheet_name'))
                ->append([
                [
                    now()->toDateTimeString(), // Timestamp (Column A)
                    $validated['tanggal'], // Hari/Tanggal (Column B)
                    $validated['nama_peminjam'], // Nama Peminjam (Column C)
                    $validated['nama_kegiatan'], // Nama Kegiatan (Column D)
                    $validated['waktu_mulai'], // Waktu Mulai (Column E)
                    $validated['waktu_berakhir'] // Waktu Berakhir (Column F)
                ]
            ]);

            return redirect()->route('schedule.index')->with('success', 'Booking berhasil dibuat!');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data ke Google Sheets: ' . $e->getMessage())->withInput();
        }
    }
}
