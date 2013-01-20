<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		
		if ($this->session->userdata('logged_in') == FALSE) {
			redirect('login');
		}
	}

	function view()
	{	
		$get_statuses = $this->db
			->select('status_id AS id,status')
			->from('statuses')
			->get();
		$data['statuses'] = $get_statuses->result();

		$data['page'] = 'statuses/view';
		$data['title'] = 'View Statuses';

		$this->load->view('shell', $data);
	}

	function generate()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_start_before_end['.$this->input->post('end_date').']');
		$this->form_validation->set_rules('end_date', 'End Date', 'required');
		$this->form_validation->set_rules('summary', 'Summary', 'required');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'reports/generate';
			$data['title'] = 'Generate Report';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'start_date' => date('m/d/Y', strtotime($this->input->post('start_date'))),
				'end_date' => date('m/d/Y', strtotime($this->input->post('end_date'))),
				'summary' => $this->input->post('summary'),
				'site' => $this->session->userdata('site_url')
			);

			$get_links = $this->db
				->select('l.link_id AS id,l.location,l.text')
				->from('links l')
				->join('types t', 't.type_id = l.type_id', 'left outer')
				->join('statuses s', 's.status_id = l.status_id', 'left outer')
				->join('categories c', 'c.category_id = l.category_id', 'left outer')
				->where('l.site_id', $this->session->userdata('site_id'))
				->where('l.date >=', $this->input->post('start_date'))
				->where('l.date <=', $this->input->post('end_date'))
				->order_by('l.date', 'DESC')
				->get();
			$data['links'] = $get_links->result();

			// Generate report HTML within view, save to variable
			$pdf_report = $this->load->view('reports/pdf_template', $data, TRUE);

			// Take generated view and create PDF with it
			include('assets/pdf/mpdf.php');	
			$mpdf=new mPDF('c');
			$mpdf->setAutoTopMargin = stretch;
			$mpdf->setAutoBottomMargin = stretch;
			$mpdf->autoMarginPadding = 5;
			$mpdf->WriteHTML($pdf_report);
			
			$curr_date = date('m/d/Y');
			$mpdf->Output("Links Report -- {$curr_date}.pdf", 'D');
			

			$data['page'] = 'reports/generate';
			$data['title'] = 'Generate Report';

			$this->load->view('shell', $data);
		}
	}
	function start_before_end($start_date, $end_date)
	{
		$start_date = strtotime($start_date);
		$end_date = strtotime($end_date);
		
		if ($end_date < $start_date) {
			$this->form_validation->set_message('start_before_end', "The Start Date must always be before the End Date.");
			return FALSE;
		} else {
			return TRUE;
		}
	}

}