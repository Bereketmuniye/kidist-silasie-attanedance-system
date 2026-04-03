<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\ExamAnswer;

class ExamResultsManagement extends Component
{
    use WithPagination;

    public $selectedExamId = null;
    public $search = '';
    public $showDetails = false;
    public $selectedResult = null;
    public $examFilter = 'all'; // all, passed, failed

    public function render()
    {
        $query = ExamResult::with(['exam', 'answers.question'])
            ->when($this->selectedExamId, function ($query) {
                return $query->where('exam_id', $this->selectedExamId);
            })
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('student_name', 'like', '%' . $this->search . '%')
                      ->orWhere('student_phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->examFilter !== 'all', function ($query) {
                if ($this->examFilter === 'passed') {
                    return $query->whereRaw('(correct_answers * 100 / total_questions) >= 60');
                } elseif ($this->examFilter === 'failed') {
                    return $query->whereRaw('(correct_answers * 100 / total_questions) < 60');
                }
            })
            ->orderBy('completed_at', 'desc');

        $results = $query->paginate(15);
        $exams = Exam::orderBy('title')->get();

        return view('livewire.exam-results-management', compact('results', 'exams'));
    }

    public function viewDetails($resultId)
    {
        $this->selectedResult = ExamResult::with(['exam', 'answers.question'])->findOrFail($resultId);
        $this->showDetails = true;
    }

    public function closeDetails()
    {
        $this->showDetails = false;
        $this->selectedResult = null;
    }

    public function deleteResult($resultId)
    {
        $result = ExamResult::findOrFail($resultId);
        $result->delete();
        $this->dispatch('notify', ['message' => 'ውጤት ተሰረዘ!', 'type' => 'success']);
    }

    public function downloadCertificate($resultId)
    {
        $result = ExamResult::with(['exam', 'answers.question'])->findOrFail($resultId);
        
        // Only allow certificate for passed students
        if ($result->percentage < 60) {
            $this->dispatch('error', 'Certificate is only available for passed students');
            return;
        }

        // Generate PDF content
        $pdfContent = $this->generateCertificatePDF($result);
        
        $filename = 'certificate_' . str_replace(' ', '_', $result->student_name) . '_' . str_replace(' ', '_', $result->exam->title) . '.pdf';
        
        return response()->streamDownload(function() use ($pdfContent) {
            echo $pdfContent;
        }, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
    
    private function generateCertificatePDF($result)
    {
        // Create a simple PDF using TCPDF-like structure
        $pdf = "%PDF-1.4\n";
        
        // Add basic PDF structure
        $objId = 1;
        $objects = [];
        
        // Catalog
        $catalog = "<< /Type /Catalog /Pages $objId 0 R >>\nendobj\n";
        $objects[] = $catalog;
        $objId++;
        
        // Pages
        $pages = "<< /Type /Pages /Kids [ $objId 0 R ] /Count 1 >>\nendobj\n";
        $objects[] = $pages;
        $pageId = $objId;
        $objId++;
        
        // Page
        $pageWidth = 842; // A4 landscape width in points
        $pageHeight = 595; // A4 landscape height in points
        $page = "<< /Type /Page /Parent $pageId 0 R /MediaBox [0 0 $pageWidth $pageHeight] /Contents $objId 0 R /Resources << /Font << /F1 $objId 0 R >> >> >>\nendobj\n";
        $objects[] = $page;
        $contentId = $objId;
        $objId++;
        
        // Content stream
        $content = "BT /F1 24 Tf 100 450 TD (Certificate of Achievement) Tj ET\n";
        $content .= "BT /F1 14 Tf 100 420 TD (This is to certify that) Tj ET\n";
        $content .= "BT /F1 20 Tf 100 380 TD (" . $result->student_name . ") Tj ET\n";
        $content .= "BT /F1 14 Tf 100 340 TD (has successfully completed the examination) Tj ET\n";
        $content .= "BT /F1 16 Tf 100 300 TD (" . $result->exam->title . ") Tj ET\n";
        $content .= "BT /F1 14 Tf 100 260 TD (with a score of " . $result->percentage . "%) Tj ET\n";
        $content .= "BT /F1 12 Tf 100 220 TD (Awarded on " . ($result->completed_at ? $result->completed_at->format('F j, Y') : now()->format('F j, Y')) . ") Tj ET\n";
        
        $contentStream = "<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream\nendobj\n";
        $objects[] = $contentStream;
        $fontId = $objId;
        $objId++;
        
        // Font (Helvetica)
        $font = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
        $objects[] = $font;
        
        // Build PDF
        $xrefPos = strlen($pdf) + count($objects) * 20 + 30; // Approximate xref position
        
        foreach ($objects as $i => $obj) {
            $pdf .= ($i + 1) . " 0 obj\n" . $obj;
        }
        
        // Cross-reference table
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";
        $offset = strlen("1 0 obj\n") + 1;
        foreach ($objects as $i => $obj) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
            $offset += strlen(($i + 1) . " 0 obj\n") + strlen($obj) + 1;
        }
        
        // Trailer
        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n$xrefPos\n%%EOF";
        
        return $pdf;
    }

    public function exportResults()
    {
        // Implementation for export functionality
        $this->dispatch('info', 'Export functionality coming soon!');
    }

    public function getStatistics()
    {
        $query = ExamResult::query();
        
        if ($this->selectedExamId) {
            $query->where('exam_id', $this->selectedExamId);
        }

        $total = $query->count();
        $passed = $query->whereRaw('(correct_answers * 100 / total_questions) >= 60')->count();
        $failed = $total - $passed;
        
        // Calculate average manually
        $results = $query->get();
        $average = $results->avg(function ($result) {
            return ($result->correct_answers / $result->total_questions) * 100;
        });

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'average' => round($average, 2)
        ];
    }

    public function getExamStatistics($examId)
    {
        $query = ExamResult::where('exam_id', $examId);
        
        $total = $query->count();
        $passed = $query->whereRaw('(correct_answers * 100 / total_questions) >= 60')->count();
        $failed = $total - $passed;
        
        // Calculate average manually
        $results = $query->get();
        $average = $results->avg(function ($result) {
            return ($result->correct_answers / $result->total_questions) * 100;
        });

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'average' => round($average, 2)
        ];
    }
}
