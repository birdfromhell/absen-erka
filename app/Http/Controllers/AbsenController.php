<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function masuk()
    {
        try {
            $user = Auth::user();
            $currentDate = now()->format('Y-m-d');
            $absen = Absen::where('username', $user->username)
                ->whereDate('created_at', $currentDate)
                ->first();
            $jam = now()->addHours(7);

            if ($absen) {
                if ($jam->hour < 7) {
                    return redirect()->back();
                }

                $absen->masuk = $jam;
                $absen->keluar = null;

                if ($jam->hour <= 9) {
                    $absen->status = "Hadir";
                } elseif ($jam->hour <= 12) {
                    $absen->status = "Terlambat";
                }

                $absen->save();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function keluar(Request $request)
    {
        try {
            $user = Auth::user();
            $currentDate = now()->format('Y-m-d');
            $absen = Absen::where('username', $user->username)
                ->whereDate('created_at', $currentDate)
                ->first();
            $jam = now()->addHours(7);

            if ($absen && in_array($absen->status, ["Hadir", "Terlambat"]) && $jam->hour >= 15) {
                $absen->kegiatan = $request->input('kegiatan');
                $absen->keluar = $jam;
                $absen->save();
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
