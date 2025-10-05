<?php
/*
FPDF minimal library file.
For full features, download from http://www.fpdf.org/
This bundled copy is intended for basic PDF generation only.
*/

class FPDF {
	protected $buffer = '';
	protected $pages = [];
	protected $currentPage = 0;
	protected $w = 210; // A4 width mm
	protected $h = 297; // A4 height mm

	public function __construct() {
		$this->AddPage();
	}

	public function AddPage() {
		$this->currentPage++;
		$this->pages[$this->currentPage] = "";
	}

	public function SetFont($family, $style='', $size=12) {
		// no-op placeholder
	}

	public function Cell($w, $h=0, $txt='', $border=0, $ln=0) {
		$this->pages[$this->currentPage] .= $txt."\n";
	}

	public function Ln($h=null) {
		$this->pages[$this->currentPage] .= "\n";
	}

	public function Output($dest='F', $name='doc.pdf') {
		// Extremely simplified PDF writer (text-only). For robust needs use official FPDF.
		$content = "%PDF-1.3\n";
		$objects = [];
		$offsets = [];
		$objects[] = "1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj\n";
		$objects[] = "2 0 obj<< /Type /Pages /Count 1 /Kids [3 0 R] >>endobj\n";
		$text = $this->escapeText($this->pages[1]);
		$stream = "BT /F1 12 Tf 50 750 Td (".$text.") Tj ET";
		$objects[] = "4 0 obj<< /Length ".strlen($stream)." >>stream\n".$stream."\nendstream endobj\n";
		$objects[] = "5 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj\n";
		$objects[] = "3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 5 0 R >> >> /Contents 4 0 R >>endobj\n";
		$xrefPos = 0;
		foreach ($objects as $obj) {
			$offsets[] = strlen($content);
			$content .= $obj;
		}
		$xrefPos = strlen($content);
		$content .= "xref\n0 ".(count($objects)+1)."\n0000000000 65535 f \n";
		for ($i=0;$i<count($objects);$i++) {
			$content .= sprintf("%010d 00000 n \n", $offsets[$i]);
		}
		$content .= "trailer<< /Size ".(count($objects)+1)." /Root 1 0 R >>\nstartxref\n".$xrefPos."\n%%EOF";

		if ($dest === 'F') {
			file_put_contents($name, $content);
			return;
		} else {
			header('Content-Type: application/pdf');
			echo $content;
		}
	}

	protected function escapeText($text) {
		$text = str_replace(['\\', '(', ')', "\r", "\n"], ['\\\\', '\\(', '\\)', '', '\\n'], $text);
		return $text;
	}
}

?>


