<?php

namespace App\Exports;

use App\Models\User;
use App\Models\xmlAssModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    /**

    * @return \Illuminate\Support\Collection

    */

    public function collection()

    {

        return xmlAssModel::select("id", "name", "lastname", "phone")->get();

    }

  

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array

    {

        return ["ID", "Name", "Lastname","Phone"];

    }
}
