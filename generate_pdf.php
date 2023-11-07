<?php
// File untuk men-generate sertifikat berformat pdf
require __DIR__ . '/vendor/autoload.php';


$path = 'csv/response.csv';

$handle = fopen($path, "r"); // open in readonly mode
$css = file_get_contents('./pdfstyle.css');

if ($handle !== FALSE) {
    $counter = 0;
    while (($row = fgetcsv($handle,null,';')) !== false) {
        // ignore 1st row
        if($counter!=0){
            $mpdf = new \Mpdf\Mpdf(['format' => [297, 210]]); // Create new mPDF Document

            $mpdf->WriteHTML($css, 1);
            $name = $row[1];
        
            $bg = "
                <body>
                <div class='cert-name'>$name</div>
                </body>";

            // $html = $bg;
            $mpdf->WriteHTML($bg, 2);
            $content = $mpdf->Output("pdf/$name.pdf", 'F');
            unset($mpdf);
            echo "$name\n";           
            
        }
        $counter++;
    }
    fclose($handle);
}
?>