<?php namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Home | Andi Belajar Ngoding',
			'test' => ['satu','dua','tiga']
		];
		
		return view('pages/home', $data);
		

	}
	public function about()
	{
		$data = [
			'title' => 'About me'
		];
    
        return view('pages/about', $data);
    
		
	}
	public function contact()
	{
		$data = [
			'title' => 'Contact us',
			'alamat' => [
				[
					'tipe' => 'Rumah',
					'alamat' => 'Jl. abc No. 123',
					'kota' => 'Bandung'
				],
				[
					'tipe' => 'Kantor',
					'alamat' => 'Jl. Setiabudi No. 193',
					'kota' => 'Bandung'
				]
			]
		];
    
        return view('pages/contact', $data);
    
		
	}
    
	


	//--------------------------------------------------------------------

}
