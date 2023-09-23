<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        $selectedColumns = collect($this->users)->map(function ($user) {
            $user['technologies'] = str_replace('<br />', ",", $user['technologies']);

            return collect($user)->only([
                'name', 'scnumber', 'email', 'mobile', 'gpa', 'special', 'credits', 'company', 'c_address',
                'hr_number', 's_date', 'e_date', 'supervisor', 's_email','s_mobile', 'technologies'
            ])->toArray();
        });

        $users = $selectedColumns->toArray();
        return collect($users);
    }

    public function headings(): array
    {
        return [
            'Name',
            'SC Number',
            'Email',
            'Mobile',
            'GPA',
            'Expecting Special',
            'Completed Credits',
            'Company',
            'Company Address',
            'HR Number',
            'Started Date',
            'Expected Ending Date',
            'Supervisor',
            'Supervisor Email',
            'Supervisor Mobile',
            'technologies Using'
            // Add more field names as needed
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
