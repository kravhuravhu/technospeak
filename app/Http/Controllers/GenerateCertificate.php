<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tfpdf\Fpdi;

class GenerateCertificate extends Controller
{
    public static function generate($userFullname = null, $subscriptionId, $courseId, $courseName = null, $courseInstructor = null, $generatedAt, $certificateIDno)
    {
        \Log::info("Starting PDF certificate generation for subscription {$subscriptionId}, course {$courseId}");

        $templateUrl = env('CERTIFICATE_TEMPLATE_URL_WAN');
        $templateContent = file_get_contents($templateUrl);

        if (!$templateContent) {
            \Log::error("Failed to fetch certificate template from {$templateUrl}");
            return null;
        }

        $tmpPath = storage_path('app/tmp_template.pdf');
        file_put_contents($tmpPath, $templateContent);

        $pdf = new Fpdi('L', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->setSourceFile($tmpPath);
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 0, 0);

        $pdf->AddFont('Roboto', '', 'Roboto-Regular.ttf', true);
        $pdf->AddFont('Roboto', 'B', 'Roboto-Bold.ttf', true);
        $pdf->AddFont('Roboto', 'EB', 'Roboto-ExtraBold.ttf', true);

        $pdf->AddFont('GreatVibes', '', 'GreatVibes-Regular.ttf', true);
        $pdf->AddFont('Priestacy', '', 'Priestacy.otf', true);

        $pageWidth = $pdf->GetPageWidth();
        $pageHeight = $pdf->GetPageHeight();

        if ($userFullname) {
            $pdf->SetFont('Roboto', 'EB', 20); 
            $pdf->SetTextColor(6, 38, 68);

            $textWidth = $pdf->GetStringWidth($userFullname);
            $x = ($pageWidth - $textWidth) / 2;
            $y = 95.5;

            $pdf->Text($x, $y, $userFullname);
        }

        if ($courseName) {
            $pdf->SetFont('Roboto', 'EB', 20); 
            $pdf->SetTextColor(6, 38, 68);

            $textWidthCourse = $pdf->GetStringWidth($courseName);
            $xCourse = ($pageWidth - $textWidthCourse) / 2; 
            $yCourse = 130;

            $pdf->Text($xCourse, $yCourse, $courseName);
        }

        if($courseInstructor) {
            $pdf->SetFont('Priestacy', '', 19);
            $pdf->SetTextColor(0, 0, 0);
            
            $textWidth = $pdf->GetStringWidth($courseInstructor);
            $offset = 70;
            $x = ($pageWidth - $textWidth) / 2 - $offset;
            $y = 164;

            $pdf->Text($x, $y, $courseInstructor);
        }

        if($generatedAt) {
            $pdf->SetFont('Roboto', '', 13);
            $pdf->SetTextColor(6, 38, 68);
            
            $textWidth = $pdf->GetStringWidth($generatedAt);
            $offset = 65;
            $x = ($pageWidth - $textWidth) / 2 + $offset;
            $y = 165.5;

            $pdf->Text($x, $y, $generatedAt->format('F j, Y'));
        }

        if($certificateIDno) {
            $pdf->SetFont('Roboto', '', 10);
            $pdf->SetTextColor(136, 136, 136);
            
            $textWidth = $pdf->GetStringWidth($certificateIDno);
            $offset = 46;
            $x = ($pageWidth - $textWidth) / 2 - $offset;
            $y = 192.6;

            $pdf->Text($x, $y, $certificateIDno);
        }

        $fileName = 'Certificate_Of_Completion_' 
            . ($userFullname ? preg_replace('/\s+/', '_', $userFullname) : 'no_name') 
            . '_' 
            . ($courseName ? preg_replace('/\s+/', '_', $courseName) : 'no_course') 
            . '.pdf';

        $path = 'certificates/generated/' . $fileName;

        $fullPath = storage_path('app/public/' . $path);
        $pdf->Output($fullPath, 'F');

        $url = Storage::url($path);

        \Log::info("PDF Certificate successfully generated: {$url}");

        return $url;
    }
}
