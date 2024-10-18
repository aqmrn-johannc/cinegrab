<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;

class ReservationExportController extends Controller
{
    public function export()
    {

        $reservations = Reservation::where('user_id', Auth::id())->with('movie')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Order ID');
        $sheet->setCellValue('B1', 'Movie Title');
        $sheet->setCellValue('C1', 'Seat Number');
        $sheet->setCellValue('D1', 'Time Slot');
        $sheet->setCellValue('E1', 'Price');

        $row = 2; 
        foreach ($reservations as $reservation) {
            $sheet->setCellValue('A' . $row, $reservation->order_number);
            $sheet->setCellValue('B' . $row, $reservation->movie->title);
            $sheet->setCellValue('C' . $row, $reservation->seat_number);
            $sheet->setCellValue('D' . $row, $reservation->time_slot);
            $sheet->setCellValue('E' . $row, $reservation->movie->price);
            $row++;
        }

        $filename = 'reservations_' . date('Y-m-d_H-i-s') . '.xlsx';

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit; 
    }
}
