<?php

class Site_model extends CI_Model {

	public function __construct()
	{
		
	}
	
	
	// keep track of the user ip and what medium they used to open the site i.e mobile or web
	public function visitor_medium($medium,$agent,$ip,$date,$page)
	{
		$data 				= 	array(
			
			'medium' 		=> 	$medium,
			'agent' 		=> 	$agent,
			'visitor_ip' 	=> 	$ip,
			'medium_date' 	=> 	$date,
			'page'			=>	$page
				
		);
		
		$query 				= 	$this->db->insert('visitor_medium_agent', $data);
		if($query)
		{
			
			return TRUE;
		
		}
		
	}
	
	public function get_all_sliders()
	{
		$this->db->where('status', 1);
		$this->db->order_by('sequence', 'ASC');
		return $this->db->get('home_banner')->result_array();
	}
	
	public function get_all_products()
	{
		$this->db->where('status', 1);
		
		$this->db->order_by('sequence', 'ASC');
		
		$this->db->order_by('date_created', 'DESC');
		
		return $this->db->get('product')->result_array();
	}
	
	public function get_all_campaigns()
	{
		$this->db->where('publish', 1);
				
		$this->db->order_by('sequence', 'ASC');
		
		$this->db->order_by('date_created', 'DESC');

		
		return $this->db->get('campaign')->result_array();
	}
	
	public function get_all_articles()
	{
		$this->db->where('publish', 1);
		
		$this->db->order_by('date_created', 'DESC');
		
		return $this->db->get('article')->result_array();
	}
	
	public function get_faq()
	{
		$this->db->where('faq_status', 1);
		
		$this->db->order_by('date_created', 'ASC');
		
		return $this->db->get('faq')->result_array();
	}
	
	public function get_dealers()
	{
		$this->db->where('status', 1);
		
		$this->db->order_by('sequence', 'ASC');
		
		$this->db->order_by('date_created', 'ASC');
		
		return $this->db->get('dealers')->result_array();
	}
	
	public function get_recall_page_email_message()
	{
		$this->db->where('id', '1');
				
		return $this->db->get('email_messages')->row_array();
	}
	
	public function get_recall_received_email_message()
	{
		$this->db->where('id', '3');
				
		return $this->db->get('email_messages')->row_array();
	}
	
	public function get_recall_email_address()
	{
		
		$this->db->where('page_id', '1');
		
		$query 				= 	$this->db->get('email_settings');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['email'];
			
		}
		
	}
	
	public function save_recall_mail($save)
	{
		$query 				= 	$this->db->insert('email_recall', $save);
		
		if($query)
		{
			return TRUE;
			
		}else{
			
			return FALSE;
			
		}
	}
	
	public function get_contact_us_email_message()
	{
		$this->db->where('id', '2');
				
		return $this->db->get('email_messages')->row_array();
	}
	
	public function get_contact_us_email_address()
	{
		
		$this->db->where('page_id', '2');
		
		$query 				= 	$this->db->get('email_settings');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['email'];
			
		}
		
	}
	
	public function save_contact_us_mail($save)
	{
		$query 				= 	$this->db->insert('email_contact_us', $save);
		
		if($query)
		{
			return TRUE;
			
		}else{
			
			return FALSE;
			
		}
	}
	
	public function save_product_brochure_download($save)
	{
		$query 				= 	$this->db->insert('product_broch_downl', $save);
		
		if($query)
		{
			return TRUE;
			
		}else{
			
			return FALSE;
			
		}
	}
	
	public function get_brochure_download_email_message()
	{
		$this->db->where('id', '4');
				
		return $this->db->get('email_messages')->row_array();
	}
	
	public function get_brochure_download_email_address()
	{
		
		$this->db->where('page_id', '3');
		
		$query 				= 	$this->db->get('email_settings');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['email'];
			
		}
		
	}
	
	public function save_book_test_drive($save)
	{
		$query 				= 	$this->db->insert('product_book_test_ride', $save);
		
		if($query)
		{
			return TRUE;
			
		}else{
			
			return FALSE;
			
		}
	}
	
	public function get_book_test_drive_email_message()
	{
		$this->db->where('id', '5');
				
		return $this->db->get('email_messages')->row_array();
	}
	
	public function get_book_test_drive_email_address()
	{
		
		$this->db->where('page_id', '4');
		
		$query 				= 	$this->db->get('email_settings');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['email'];
			
		}
		
	}
	
	public function save_request_quote($save)
	{
		$query 				= 	$this->db->insert('product_request_quote', $save);
		
		if($query)
		{
			return TRUE;
			
		}else{
			
			return FALSE;
			
		}
	}
	
	public function get_request_quote_email_message()
	{
		$this->db->where('id', '6');
				
		return $this->db->get('email_messages')->row_array();
	}
	
	public function get_request_quote_email_address()
	{
		
		$this->db->where('page_id', '5');
		
		$query 				= 	$this->db->get('email_settings');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['email'];
			
		}
		
	}
	
	
	public function get_product_name($product_id)
	{
		
		$this->db->where('product_id', $product_id);
		
		$query 				= 	$this->db->get('product');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['product'];
			
		}
		
	}
	
	public function get_articles($tbl_name, $limit=0, $offset=0, $slug = FALSE)
	{
		
		if ($slug === FALSE)
		{
			$this->db->where('publish', 1);
			$this->db->order_by('publish_date', 'DESC');
			$this->db->from($tbl_name);
			
			if($limit>0)
			{
				$this->db->limit($limit, $offset);
			}
			
			$query 				= 	$this->db->get();
		 
			return $query->result_array();

		}
		
		
		$query 					= 	$this->db->get_where($tbl_name, array('article_slug' => $slug, 'publish'=> 1));

		if($query->num_rows() > 0)
		 {
			
			$result 			= 	$query->row_array();

			// keep record of who viewed each article
			$id 				= 	$result['article_id'];
			
			if ($this->agent->is_mobile())
			{
				$agent 		= 	$this->agent->mobile();
				
				$medium 	= 	"mobile";
			}
			
			elseif ($this->agent->is_browser())
			{
				$agent 		= 	$this->agent->browser().' '.$this->agent->version();
				
				$medium 	= 	"web";
			}
			elseif ($this->agent->is_robot())
			{
				$agent 		= 	$this->agent->robot();
				
				$medium 	= 	"robot";
			}
			else
			{
				$agent 		= 	'Unidentified User Agent';
				
				$medium 	= 	"";
			}
		
			$date 				= 	date('Y-m-d H:i:s');
			
			$ip 				= 	$this->input->ip_address();
			
			$data_viewed_article = array(
			
				'article_id' 	=> 	$id,
				'medium'		=>	$medium,
				'agent'			=>	$agent,
				'ip' 			=> 	$ip,
				'date_viewed' 	=> 	$date
			
			);
			
			$this->db->insert('viewed_articles', $data_viewed_article);
			
		 }
		 else
		 {
			 
			 $result 			= 	$query->row_array();
			 
		 }

		 return $result;

	}
	
	
	public function view_product($slug = FALSE, $preview = FALSE)
	{
		
		$this->db->select('*');
		$this->db->from('product');
		$this->db->where('product_slug', $slug);
		 
		if(empty($preview))
		{
			$this->db->where('status', '1');
		}
		
		 $query = $this->db->get();
		 
		 if($query->num_rows() > 0)
		 {
			
			foreach ($query->result() as $row)
			{
				
				$prod_id 				= 	$row->product_id;
				$exterior_photos 		= 	$this->get_product_photos('product_exterior_photos', $prod_id);
				$interior_photos 		= 	$this->get_product_photos('product_interior_photos', $prod_id);
				$technology_photos 		= 	$this->get_product_photos('product_technology_photos', $prod_id);
				$color_photos 			= 	$this->get_product_color_photos($prod_id);
				$exterior_features 		= 	$this->get_product_features('product_exterior_feature', $prod_id);
				$interior_features 		= 	$this->get_product_features('product_interior_feature', $prod_id);
			
			}
			  
			$data 						= 	array(
			
				"exterior_photos" 			=> 	$exterior_photos,
				"interior_photos" 			=> 	$interior_photos,
				"color_photos" 				=> 	$color_photos,
				"technology_photos" 		=> 	$technology_photos,
				"exterior_features" 		=> 	$exterior_features,
				"interior_features"			=> 	$interior_features
					
			);
				
			$result 					= 	array_merge($query->row_array(), $data);
			
			if ($this->agent->is_mobile())
			{
				$agent 		= 	$this->agent->mobile();
				
				$medium 	= 	"mobile";
			}
			
			elseif ($this->agent->is_browser())
			{
				$agent 		= 	$this->agent->browser().' '.$this->agent->version();
				
				$medium 	= 	"web";
			}
			elseif ($this->agent->is_robot())
			{
				$agent 		= 	$this->agent->robot();
				
				$medium 	= 	"robot";
			}
			else
			{
				$agent 		= 	'Unidentified User Agent';
				
				$medium 	= 	"";
			}
			
			$ip 			= 	$this->input->ip_address();
			
			$date 			= 	date('Y-m-d H:i:s');
			
			
			$data_viewed_prod 				= 	array(
				
				'product_id' 				=> 	$prod_id,
				'agent'						=>	$agent,
				'medium'					=>	$medium,
				'ip' 						=> 	$ip,
				'date_viewed' 				=> 	$date
			
			);
			
			$this->db->insert('viewed_products', $data_viewed_prod);
		 }
		 else
		 {
			 
			 $result 						= 	$query->row_array();
			 
		 }

		return $result;
	}
	
	// get all the product photos associated with this product id
	public function get_product_photos($tbl_name, $product_id)
	{
		
		$query 					= 	$this->db->query("SELECT * FROM $tbl_name where product_id = '$product_id' ORDER BY primary_photo DESC ");
		
		return $query->result_array();
		
	}
	
	public function get_product_color_photos($product_id)
	{
		
		$this->db->select('*');
		$this->db->where('product_id', $product_id);
		$this->db->from('product_color_photos');
		$this->db->join('color', 'color.color_id = product_color_photos.color_id', 'left');
		
		$query 		= $this->db->get();
		
		return 		$query->result_array();
		
	}
	
	// get all the product features associated with this product id
	public function get_product_features($tbl_name, $product_id)
	{
		
		$query 					= 	$this->db->query("SELECT * FROM $tbl_name where product_id = '$product_id' ORDER BY sequence ASC ");

		return $query->result_array();
		
	}
	
	// fetch all the dealers that match this search
	public function search_dealer($search)
	{

		 $status 		= 	'1';
		 
		if(!empty($search))
		{
			//support multiple words
			$term 		= 	explode(' ', $search);
		
			foreach($term as $t)
			{
				
				$not			= 	'';
				$operator		= 	'OR';
				
				if(substr($t,0,1) == '-')
				{
					$not		= 	'NOT ';
					$operator	= 	'AND';
					
					//trim the - sign off
					$t			= 	substr($t,1,strlen($t));
				}
		
				$like		= 	'';
				$like		.= 	"( `location` ".$not."LIKE '%".$t."%' " ;
				$like		.= 	$operator." `address` ".$not."LIKE '%".$t."%'  ";
				$like		.= 	$operator." `sales_contact` ".$not."LIKE '%".$t."%'  ";
				$like		.= 	$operator." `sales_contact_email` ".$not."LIKE '%".$t."%'  ";
				$like		.= 	$operator." `aftersales_contact` ".$not."LIKE '%".$t."%'  ";
				$like		.= 	$operator." `aftersales_contact_email` ".$not."LIKE '%".$t."%' )";
				//$like	.= $operator." `notes` ".$not."LIKE '%".$t."%' )";
		
				$this->db->where($like);
			}	
		}
			
		 $this->db->where('status', $status);
		 
		 $query 	= 	$this->db->get('dealers');
		 
		if ($this->agent->is_mobile())
		{
			$agent 				= 	$this->agent->mobile();
			
			$medium 			= 	"mobile";
		}
		
		elseif ($this->agent->is_browser())
		{
			$agent 				= 	$this->agent->browser().' '.$this->agent->version();
			
			$medium 			= 	"web";
		}
		elseif ($this->agent->is_robot())
		{
			$agent 				= 	$this->agent->robot();
			
			$medium 			= 	"robot";
		}
		else
		{
			$agent 				= 	'Unidentified User Agent';
			
			$medium 			= 	"";
		}
		
		$save['medium']			=	$medium;
		$save['agent']			=	$agent;
		$save['user_ip']		=	$this->input->ip_address();
		$save['search_date'] 	= 	date('Y-m-d h:i:s');
		$save['search_term']	=	$search;
		$save['result_found'] 	= 	$query->num_rows();
		
		
		$this->db->insert('search_dealer', $save);
		
		return $query->result_array();
		
	}
	
	// fetch all the records that match this search
	public function search($search)
	{
		$status 		= 	'1';
		 
		if(!empty($search))
		{
			//support multiple words
			$term 		= 	explode(' ', $search);
		
			foreach($term as $t)
			{
				$not			= 	'';
				$operator		= 	'OR';
				
				if(substr($t,0,1) == '-')
				{
					$not		= 	'NOT ';
					$operator	= 	'AND';
					
					//trim the - sign off
					$t			= 	substr($t,1,strlen($t));
				}
		
				$like		= 	'';
				$like		.= 	"( `product` ".$not."LIKE '%".$t."%' " ;
				$like		.= 	$operator." `product_text` ".$not."LIKE '%".$t."%'  ";
				$like		.= 	$operator." `specification` ".$not."LIKE '%".$t."%'  ";
				$like		.= 	$operator." `features` ".$not."LIKE '%".$t."%'  ";
		
				$this->db->where($like);
			}	
		}
			
		 $this->db->where('status', $status);
		 
		 $query 	= 	$this->db->get('product');
		
		 $prod		=	array();
		 
		 if($query->num_rows() > 0)
		 {
			foreach($query->result() as $row)
			{
				
				 $prod[$row->product_id]['product_id'] 				= 	$row->product_id;
				 $prod[$row->product_id]['product'] 				= 	$row->product;
				 $prod[$row->product_id]['product_slug'] 			= 	$row->product_slug;
				 $prod[$row->product_id]['product_cover_img'] 		= 	$row->product_cover_img;
				 $prod[$row->product_id]['product_text'] 			= 	$row->product_text;
				 $prod[$row->product_id]['brochure'] 				= 	$row->brochure;
				 $prod[$row->product_id]['product_logo'] 			= 	$row->product_logo;
				 $prod[$row->product_id]['status'] 					= 	$row->status;
				 $prod[$row->product_id]['created_by'] 				= 	$row->created_by;
				 $prod[$row->product_id]['date_created'] 			= 	$row->date_created;
				 
				 /*$prod[$row->product_id]['file_name'] 				= 	$this->get_product_primary_pics($row->product_id);
				 $prod[$row->product_id]['file_name_other'] 		= 	$this->get_product_pics($row->product_id);
				 $prod[$row->product_id]['seller_id'] 				= 	$this->get_product_merchant($row->seller_id);	*/	
				 
				 /*$prod[$row->product_id]['exterior_image']			= 	$this->get_product_images('product_exterior_photos',$row->product_id);					 
				 $prod[$row->product_id]['exterior_feature']		= 	$this->get_product_images('product_exterior_feature',$row->product_id);
				 $prod[$row->product_id]['interior_image']			= 	$this->get_product_images('product_interior_photos',$row->product_id);
				 $prod[$row->product_id]['interior_feature']		= 	$this->get_product_images('product_interior_feature',$row->product_id);	
				 $prod[$row->product_id]['color_image']				= 	$this->get_product_images('product_color_photos',$row->product_id);
				 $prod[$row->product_id]['technology_image']		= 	$this->get_product_images('product_technology_photos',$row->product_id); */  

			}
		 }
		 
		
		
		if ($this->agent->is_mobile())
		{
			$agent 				= 	$this->agent->mobile();
			
			$medium 			= 	"mobile";
		}
		
		elseif ($this->agent->is_browser())
		{
			$agent 				= 	$this->agent->browser().' '.$this->agent->version();
			
			$medium 			= 	"web";
		}
		elseif ($this->agent->is_robot())
		{
			$agent 				= 	$this->agent->robot();
			
			$medium 			= 	"robot";
		}
		else
		{
			$agent 				= 	'Unidentified User Agent';
			
			$medium 			= 	"";
		}
	
		$save['medium']			=	$medium;
		$save['agent']			=	$agent;
		$save['user_ip']		=	$this->input->ip_address();
		$save['search_date'] 	= 	date('Y-m-d h:i:s');
		$save['search_term']	=	$search;
		$save['result_found'] 	= 	$query->num_rows();

		
		$this->db->insert('search', $save);
		
		return $prod;
		
	}

}