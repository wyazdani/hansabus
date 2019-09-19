<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class General
{

    public function invoiceNumber($id){
        return str_pad($id, 9, "0", STR_PAD_LEFT);
    }
    /* get random string key */
    public function randomKey() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0C2f) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0x2Aff), mt_rand(0, 0xffD3), mt_rand(0, 0xff4B)
        );
    }
    public function validateMe($request, $rules, $messages){

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            $messages = $validator->messages();
            foreach ($messages->all() as $message)
            {
                toastr()->error($message, 'Failed', ['timeOut' => 10000]);
            }
            return false;
        }
        return true;
    }
    public static function CreatePdf($orientation,$viewHtml,$outputname,$subject){

        $pdf = new \TCPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('HansaBus');
        $pdf->SetTitle('Driver Form');
        $pdf->SetSubject($subject);
        $pdf->SetKeywords('');
        // $pdf->SetHeaderData("", "", "JOLLYBEE RESTAURANT MANAGEMENT SYSTEM", "");


        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);/*PDF_MARGIN_TOP*/
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 10);/*PDF_MARGIN_BOTTOM*/

        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        /*$lg['a_meta_dir'] = 'rtl';*/
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        $pdf->SetFont('dejavusans');
        $pdf->setLanguageArray($lg);
        $pdf->AddPage();
        $views= $viewHtml;
        $pdf->writeHTML($views, true, false, false, false, '');

        return $pdf->Output($subject.'_'.date("Y-m-d h:i:s").'_'.$outputname.".pdf", 'I');
    }
    public static function DownloadPdf($orientation,$viewHtml,$outputname,$subject){

        $pdf = new \TCPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('HansaBus');
        $pdf->SetTitle('Driver Form');
        $pdf->SetSubject($subject);
        $pdf->SetKeywords('');
        // $pdf->SetHeaderData("", "", "JOLLYBEE RESTAURANT MANAGEMENT SYSTEM", "");


        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);/*PDF_MARGIN_TOP*/
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 10);/*PDF_MARGIN_BOTTOM*/

        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        /*$lg['a_meta_dir'] = 'rtl';*/
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        $pdf->SetFont('dejavusans');
        $pdf->setLanguageArray($lg);
        $pdf->AddPage();
        $views= $viewHtml;
        $pdf->writeHTML($views, true, false, false, false, '');

        return $pdf->Output($subject.'_'.date("Y-m-d h:i:s").'_'.$outputname.".pdf", 'D');
    }
}
?>