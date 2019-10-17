<?php


namespace App\Helpers;


class HansbusPdf extends \TCPDF
{
    public function Headers() {
       /* // Logo
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');*/
    }

    // Page footer
    public function Footers() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
       /* $this->SetFont('helvetica', 'I', 8);*/
        // Page number

        $html   = '
  <table  align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;color: #333;font-size: 8px;">
    <tr>
        <td class="left">
            <table style="position: fixed;left: 0;bottom: 0;width: 100%;padding: 50px 0 0;" width="100%">
                <tr>
                    <td>
                        <table style="padding: 10px 0 0;border-top: 1px solid #ccc;" width="100%">
                            <tr>
                                <td class="left" width="35%">Hansa Bustouristik e.K. <br>Hoisbütteler Dorfstr. 1 <br>D 22949 - Ammersbek <br><strong>Zweigstelle , kfz Werkstatt + Waschhalle</strong><br>Georgswerder Bogen 4<br><strong>D 21109 :</strong>  Hamburg<br></td>
                                <td class="left" width="33%"><strong>Tel :</strong>   (+49)   040 / 521 580 81<br><strong>Fax :</strong>  (+49)   040 / 521 580 82<br><strong>Mobil  :</strong>  (+49)  0173 / 94 80 246<br>www. hansebus.com<br><strong>Email:</strong>info@ hansebus.com</td>
                                <td class="left" width="32%"><strong>Gerichtsstand :</strong>  Lübeck<br><strong>GF :</strong>  Timor Alizada<br><strong>HRA  :</strong>  9206<br><strong>St.-Nr :</strong>  30/001/06020<br><strong>USt.-ID:</strong> DE256517113</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';
        $html   =   '<img  src="'.url('images/footer.png').'"/>  ';

        $this->writeHTML($html, false, true, false, true);
    }
}