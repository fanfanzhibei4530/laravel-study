<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Helper;
use Illuminate\Support\Facades\Mail;
use App\Mail\Verify;
use App\Jobs\ProcessEmail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(){
        $preg='/^N\d{7}[a-zA-Z]{1}$/';
        $str='N1234567A';
        if(preg_match($preg, $str, $match)){
            echo 1;
        }else{
            echo 2;
        }
        exit;
    }

    public function upload(){
        return view('test.upload');
    }

    public function uploadHandle(Request $request){
        try{
            if (!$request->isMethod('post')) {
                throw new \Exception('非法请求');
            }
            $res=Helper::uploadImgs($request, 'file');
            print_r($res);
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function export_csv(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        try{
            $range=Helper::createExcelRange();
            $title=[
                ['id','标题','创建时间'],
            ];
            $time=time();
            for ($i=0; $i < 400000; $i++) { 
                $data[]=[
                    'id'=>$i+1,
                    'title'=>'标题'.($i+1),
                    'create_time'=>"{$time}",
                ];
            }
            $arrData=array_merge($title, $data);
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $spreadsheet->getActiveSheet()->fromArray($arrData);
            //执行冻结到A2  即第一行
            $spreadsheet->getActiveSheet()->freezePane('A2');
            //第一行 设置高度30
            $spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);

            $filename='测试.csv';
            $filename = iconv("utf-8", 'gbk', $filename);
            ob_end_clean();//清楚缓存区，解决乱码问题
            // header('Content-Description: File Transfer');
            // header('Expires: 0');
            // header('Cache-Control: must-revalidate');
            // header('Pragma: public');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename='.$filename);
            // header('Cache-Control: max-age=0');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->save('./abc.csv');
            exit;
        } catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function export_excel_array(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        try{
            $range=Helper::createExcelRange();
            $title=[
                ['id','标题','创建时间'],
            ];
            for ($i=0; $i < 60000; $i++) { 
                $data[]=[
                    'id'=>$i+1,
                    'title'=>'标题'.($i+1),
                    'create_time'=>time(),
                ];
            }
            $arrData=array_merge($title, $data);
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $spreadsheet->getActiveSheet()->fromArray($arrData);
            //执行冻结到A2  即第一行
            $spreadsheet->getActiveSheet()->freezePane('A2');
            //第一行 设置高度30
            $spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(30);

            $filename='测试.xls';
            $filename = iconv("utf-8", 'gbk', $filename);
            ob_end_clean();//清楚缓存区，解决乱码问题
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出07Excel文件
            // header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename);
            header('Cache-Control: max-age=0');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function export_excel(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        try{
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);//设置当前工作区
            $spreadsheet->getActiveSheet()->setTitle('Sheet1');
            $range=Helper::createExcelRange();
            $defaultCell=[
                ['id', '订单编号'],
                ['title', '标题'],
                ['create_time', '创建时间'],
                ['update_time', '最后更新时间'],
                ['delete_time', '删除时间'],
            ];
            $allCell=$defaultCell;
            for ($i=0; $i < count($allCell); $i++) { 
                $spreadsheet->getActiveSheet()
                    ->setCellValue($range[$i].'1', $allCell[$i][1])
                ;
                $len = strlen(iconv('utf-8','gb2312',$allCell[$i][1]));
                $len=$len>=14?$len:14;
                $spreadsheet->getActiveSheet()->getColumnDimension($range[$i])->setWidth($len+4);
            }

            $list=DB::table('test')->get()->toArray();
            foreach ($list as $k => $v) {
                $v=(array)$v;
                $v['create_time']=date('Y-m-d H:i', $v['create_time']);
                $v['update_time']=date('Y-m-d H:i', $v['update_time']);
                $v['delete_time']=$v['delete_time']>0?date('Y-m-d H:i', $v['delete_time']):'未删除';

                $num=$k+2;
                for ($i=0; $i < count($allCell) ; $i++) {
                    if(isset($v[$allCell[$i][0]])){
                        $spreadsheet->getActiveSheet()->setCellValue($range[$i].$num, $v[$allCell[$i][0]]);
                    } 
                }
            }
            //执行冻结到A2  即第一行
            $spreadsheet->getActiveSheet()->freezePane('A2');
            //第一行 设置高度30
            $spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
            //第一行水平居中
            $spreadsheet->getActiveSheet()->getStyle('A1:'.$range[count($allCell)-1].'1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            //第一行水平居中
            $spreadsheet->getActiveSheet()->getStyle('A1:'.$range[count($allCell)-1].'1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            //其他行水平居坐
            $spreadsheet->getActiveSheet()->getStyle('A2:'.$range[count($allCell)-1].(count($list)+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            //其他行自动换行
            $spreadsheet->getActiveSheet()->getStyle('A2:'.$range[count($allCell)-1].(count($list)+1))->getAlignment()->setWrapText(true);

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50);

            $filename='测试.xls';
            $filename = iconv("utf-8", 'gbk', $filename);
            ob_end_clean();//清楚缓存区，解决乱码问题
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename);
            header('Cache-Control: max-age=0');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch(\Exception $e){
            echo $e->getMessage();
        }

    }

    public function import_excel(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        try{
            $filePath='./test.xlsx';
            if(!file_exists($filePath)){
                throw new \Exception('文件不存在');
            }
            $file_suffix=pathinfo($filePath)['extension'];
            if($file_suffix == 'xlsx'){
                $readerType = 'Xlsx';
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }elseif ($file_suffix == 'xls') {
                $readerType = 'Xls';
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }elseif ($file_suffix == 'csv') {
                $readerType = 'Csv';
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            }
            // $reader        = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($readerType);
            $reader->setReadDataOnly(true);

            $spreadsheet   = $reader->load($filePath);
            $sheet         = $spreadsheet->getSheet(0);
            $highestRow    = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数

            $title_list = $spreadsheet->getActiveSheet()->rangeToArray('A1:'.$highestColumn.'1')[0];
            $data_list = $spreadsheet->getActiveSheet()->rangeToArray('A2:'.$highestColumn.$highestRow);

            print_r($data_list);

            $spreadsheet->disconnectWorksheets();

            unset($title_list);
            unset($data_list);
            unset($sheet);
            unset($spreadsheet);
        } catch(\Exception $e){
            $spreadsheet->disconnectWorksheets();
            echo $e->getMessage();
        }
        
    }

    public function mail_send(){
        try{
            $mailData=['code'=>1234];
            $send=Mail::to('362723473@qq.com')->queue((new Verify($mailData))->onQueue('emails'));
            exit;
            // $data=[
            //     'code'=>1234,
            //     'email'=>'362723473@qq.com',
            // ];
            // ProcessEmail::dispatch($data);
        } catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function sendMail($data){
        try{
            $mailData=['code'=>$data['code']];
            $send=Mail::to($data['email'])->send(new Verify($mailData));
            echo 'ok';
        } catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}
