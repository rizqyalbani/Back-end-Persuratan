<?php 


/*DIMANA PROSES GUNANYA UNTUK MELAKUAKN HAL SEPERTI CRUD*/
 

class Proses extends mainController
{

	public function register()
	{
		$validate = $this->model('registerModel')->validateRegister();
		if (!empty($validate)) {
			//keluar
		}
		
		$add = $this->model('registerModel')->register($_POST);
		
		if ($add > 0) {
			
			header('Location: '.BASE_URL.'login/login');
			exit();
		}else{
			
			header('Location: '.BASE_URL.'register/register');
			exit(); 
		}
	}
    
}
