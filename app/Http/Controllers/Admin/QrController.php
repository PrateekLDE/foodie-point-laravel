<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * QrController
 */
class QrController extends Controller
{
    public function show()
    {
        $menuUrl = route('menu.today');

        $qr = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H') // High redundancy for better scan reliability on printed materials
            ->generate($menuUrl);

        return view('admin.qr', [
            'qr'      => $qr,
            'menuUrl' => $menuUrl,
        ]);
    }

    /**
     * Download raw SVG for printing.
     */
    public function download()
    {
        $menuUrl = route('menu.today');

        $qr = QrCode::format('svg')
            ->size(500)
            ->errorCorrection('H')
            ->generate($menuUrl);

        return response($qr)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="restaurant-menu-qr.svg"');
    }
}
