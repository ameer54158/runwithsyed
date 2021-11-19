<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class User implements WithColumnFormatting, FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    private $users;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function  __construct($users='')
    {
        if($users) {
            $this->users = $users;
        }

    }

    public function headings(): array
    {
        return [
            '#',
            'Role',
            'First name',
            'Last name',
            'Mobile no',
            'Email',
            'Status',
            'Gender',
            'Zip code',
            'Zip city',
            'Address',
        ];
    }

    public function collection()
    {
        if($this->users) {
            $users = $this->users;

        } else {
            // custom query to find users
        }
        $key = 0;
        $users = $users->map(function ($user, $key)  {
            return [
                '#'                             => ++$key,
                'role'                          => isset($user->roles[0]) ? ucfirst($user->roles[0]->name) : '',
                'first_name'                    => $user->first_name ? $user->first_name : '',
                'last_name'                     => $user->last_name ? $user->last_name : '',
                'mobile_number'                 => $user->mobile_no ? $user->mobile_no : '',
                'email'                         => $user->email,
                'status'                        => $user->status == 1 ? 'Active':'Deactivate',
                'gender'                        => $user->detail && $user->detail->gender  ? ucfirst($user->detail->gender) : '',
                'zip_code'                      => $user->detail && $user->detail->zip_code ? $user->detail->zip_code : '',
                'zip_city'                      => $user->detail && $user->detail->zip_city ? $user->detail->zip_city : '',
                'address'                       => $user->detail && $user->detail->address ? $user->detail->address : '',
            ];
        });
        return $users;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
//                $event->sheet->getDelegate()->getStyle('A1:k1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
