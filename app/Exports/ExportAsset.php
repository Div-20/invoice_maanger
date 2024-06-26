<?php
namespace App\Exports;

use App\Models\Asset;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Auth;

class ExportAsset implements FromCollection, WithHeadings,WithCustomStartCell, WithEvents
{
    //use SerializesModels, InteractsWithQueue, Queueable;

    public $search;
    public $data;
    public $columns;
    public $status;
    public function __construct($data = "",$status = "",$columns = "",$search =array()){

        $this->search = $search;
        $this->data = $data;
        $this->columns = $columns;
        $this->status = $status;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collect = $value=[];
        $data = $this->data;
        foreach($data as $key => $row){
            $asset_details = json_decode($row->asset_json, true);
            if(array_key_exists("custom_report", $this->search) && $this->search['custom_report'] == 1){
                $custom_report[$key][] = [$key+1];
                if(!empty($this->search['excel_fields'])){
                    foreach($this->search['excel_fields'] as $excel_key){
                        if(in_array($excel_key,array_keys($asset_details))){
                            array_push($custom_report[$key][0],$asset_details[$excel_key]);
                        }elseif(isset($row->$excel_key)){
                            array_push($custom_report[$key][0],$row->$excel_key);
                        }else{
                            array_push($custom_report[$key][0],'');
                        }
                    }
                }

            }else{
                $value[$key][] = [
                    $key+1,
                    isset($asset_details['building'])?$asset_details['building']:'',
                    isset($asset_details['department'])?$asset_details['department']:'',
                    $row->asset_type ? $row->asset_type->name : '',
                    $row->unique_id,
                    ''
                ];
            }
        }
        if(array_key_exists("custom_report", $this->search) && $this->search['custom_report'] == 1) {
            $collect = $custom_report;
        }else{
            $collect = $value;
        }

        //dd(DB::getQuerylog());
        return collect($collect);
    }
    public function headings(): array
    {
        if(array_key_exists("custom_report", $this->search) && $this->search['custom_report'] == 1) {
            $arr = [
                "Sr.No."
            ];
            if(!empty($this->search['excel_fields'])){
                foreach($this->search['excel_fields'] as $excel_key){
                    array_push($arr,str_replace('_', ' ',ucfirst($excel_key)));
                }
            }
        }else{

            $arr = [
                "Sr. No.",
                "Building",
                "Department",
                "Asset Type",
                "Asset Unique Code",
                "Created by"
            ];
        }

        return $arr;
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Patrick');
            },
            AfterSheet::class  => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:AT1')->getFont(15)->setBold(true);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(35);
                for($char = 'A'; $char !== 'AT'; $char++){
                  $event->sheet->getDelegate()->getColumnDimension($char)->setAutoSize(true);
                }

            },
        ];
    }
    public function startCell(): string
    {
        return 'A1';
    }
    public function drawings()
    {
        $drawing = new Drawing();
        //$drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        //$drawing->setPath(public_path('/img/logo.jpg'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');
        return $drawing;
    }
}
