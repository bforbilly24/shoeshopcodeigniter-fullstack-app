<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdfview extends CI_Controller
{
	public function index()
	{
		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Total Income';

		// filename dari pdf ketika didownload
		$file_pdf = 'Total Income';
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('pdf', $this->data, true);

		// run dompdf
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}
}