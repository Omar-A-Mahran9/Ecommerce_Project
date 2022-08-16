<?php
	function lang($phrase){

		static $lang=array(


			//Dashboard page
			'Home_Admin'		=>'Adminstrator',
			'Go_shop'			=>'Visit Shop',
			'Categories_Site'	=>'Categories',
			'Profile_Edit'		=>'Edit Profile',
			'Logout_Site'		=>'Logout',
			'Items_Site'		=>'Itmes',
			'Member_site'		=>'Members',
			'comments_site'		=>'Comments',
			'Logs_site'			=>'Logs',
			'E-Commerce'		=>'E-Commerce',
		);


     	
     		return $lang[$phrase];
	}
	
	


