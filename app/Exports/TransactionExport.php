<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TransactionExport implements
    FromCollection,
    WithMapping,
    WithEvents,
    ShouldAutoSize,
    WithHeadings,
    WithStyles,
    WithDefaultStyles,
    WithColumnWidths
{
    protected $transaction;
    protected $started_line = '5';
    protected $header_line = '4';

    public function __construct(Collection $transaction)
    {
        $this->transaction = $transaction;
    }

    public function Collection()
    {
        return $this->transaction;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Pelanggan',
            'Jumlah Penumpang',
            'Kode Bus',
            'Nama Bus',
            'Tujuan',
            'Tanggal Perjalanan',
            'Pembayaran',
            'Status Transaksi',
            'Harga',
            'Dibayar',
            'Detail Pengeluaran',
            'Total Pengeluaran',
            'Dibuat Oleh',
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        // Or return the styles array
        return [
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_RED],
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A' . $this->header_line . ':N' . $this->transaction->count() + $this->header_line)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ])->getAlignment()->setWrapText(true);
        
        $sheet->getStyle($this->header_line)->getFont()->setBold(true);
        $sheet->getStyle($this->header_line)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($this->header_line)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('C')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('H')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('I')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach ($this->transaction as $key => $value) {
            if ($value->PAYMENT_STATUS == 0) {
                $sheet->getStyle('H' . $key + $this->started_line)->getFont()->getColor()->setRGB('0000FF');
            } else {
                $sheet->getStyle('H' . $key + +$this->started_line)->getFont()->getColor()->setRGB('008000');
            }

            if ($value->TRANSACTION_STATUS == 0) {
                $sheet->getStyle('I' . $key + $this->started_line)->getFont()->getColor()->setRGB('FFA500');
            } else if ($value->TRANSACTION_STATUS == 1) {
                $sheet->getStyle('I' . $key + $this->started_line)->getFont()->getColor()->setRGB('0000FF');
            } else if ($value->TRANSACTION_STATUS == 2) {
                $sheet->getStyle('I' . $key + +$this->started_line)->getFont()->getColor()->setRGB('FF0000');
            } else {
                $sheet->getStyle('I' . $key + +$this->started_line)->getFont()->getColor()->setRGB('008000');
            }
        }
    }

    public function map($transaction): array
    {
        return [
            $transaction->TRANSACTION_ID,
            $transaction->CUSTOMER_NAME,
            $transaction->CUSTOMER_AMOUNT,
            $transaction->TRANSPORT_CODE,
            $transaction->TRANSPORT_NAME,
            $transaction->DESTINATION,
            $transaction->DATE_FROM_TO,
            $transaction->PAYMENT_STATUS_VAL,
            $transaction->STATUS,
            $transaction->AMOUNT,
            $transaction->PAID_PAYMENT,
            $transaction->EXPENSE_DETAIL,
            $transaction->TOTAL_EXPENSE,
            $transaction->CREATED_BY,
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile(storage_path('template/Report_Template.xlsx'));
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $this->populateSheet($sheet);

                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }

    private function populateSheet($sheet)
    {
    }

    public function columnWidths(): array
    {
        return [
            'L' => 50,         
        ];
    }
}
