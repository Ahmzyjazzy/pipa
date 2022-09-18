<?php

function save_leadership_assessment($save, $communication, $schedule, $participant)
	{
		
		$slug_field							=	'survey_slug';
		
		$table								=	'program_survey';
		
		$id_field							=	'survey_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['survey_id']))
		{
			//its an edit	
			
			$this->db->where('survey_id', $save['survey_id']);
			
			$query							=	$this->db->update('program_survey', $save);
			
			if($query)
			{
				
				//now insert all the communications
				$saveCommunication			=	$this->save_program_communication($communication, $save['survey_id']);
				
				
				if($saveCommunication)
				{
					
					$saveSchedule			=	$this->save_program_survey_schedule($schedule, $save['survey_id']);
					
					if($saveSchedule)
					{
						
						//now check if the participant value is not empty
						if(!empty($participant))
						{
							
							$handleParticipant		=	$this->move_participant_temp_to_live($participant, $save['survey_id']);
							
							if($handleParticipant)
							{
								
								$this->update_competency_survey_ref($save['survey_id']);
								
								return TRUE;
								
							}else{
								
								return FALSE;
									
							}
							 
						}else{
							
							$this->update_competency_survey_ref($save['survey_id']);
							
							return TRUE;	
							
						}
						
					}else{
						
						return FALSE;
						
					}
			
				}else{
					
					return FALSE;
						
				}
				
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//its a new record
			
			$query							=	$this->db->insert('program_survey', $save);
			
			$survey_id						=	$this->db->insert_id();
			
			if($query)
			{
				
				//now insert all the communications
				$saveCommunication			=	$this->save_program_communication($communication, $survey_id);
								
				if($saveCommunication)
				{
					
					$saveSchedule					=	$this->save_program_survey_schedule($schedule, $survey_id);
					
					if($saveSchedule)
					{
						//now check if the participant value is not empty
						if(!empty($participant))
						{
							
							$handleParticipant		=	$this->move_participant_temp_to_live($participant, $survey_id);
							
							if($handleParticipant)
							{
								
								$this->update_competency_survey_ref($survey_id);
								
								return TRUE;
								
							}else{
								
								return FALSE;
									
							}
							 
						}else{
							
							$this->update_competency_survey_ref($survey_id);
							
							return TRUE;	
							
						}
						
					}else{
						
						return FALSE;
						
					}	
			
				}else{
					
					return FALSE;
						
				}
				
			}else{
				
				return FALSE;
					
			}
			
		}
		
	}
	
?>