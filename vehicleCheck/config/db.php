<?php
	
	class Database {
		
		
		private $db_host = 'localhost'; 
		private $db_user = 'root'; 
		private $db_pass = 'root1988'; 
		private $db_name = 'carCheck';
 
		private $result = array(); 
		
		//check to see if table exits
		private function tableExists($table)
		{
		    $tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
		    if($tablesInDb)
		    {
		        if(mysql_num_rows($tablesInDb)==1)
		        {
		             return true; 
		        }
		        else
		        { 
		         	 return false; 
		        }
		    }
		}
		
		public function selectQuery($table,$query) {
			
			$q = $query;
			
			if($this->tableExists($table))
		    {
		        $query = @mysql_query($q);
		        
		        if($query)
		        {
		            $numResults = mysql_num_rows($query);
		      
		            for($i = 0; $i < $numResults; $i++)
		            {
		                $r = mysql_fetch_array($query);
		                $key = array_keys($r); 
		                
		                for($x = 0; $x < count($key); $x++)
		                {
			             
							//echo($key[$x]);
							// echo("</br>");
							// Sanitizes keys so only alphavalues are allowed
		                    if(!is_int($key[$x]))
		                    {
		                        if(mysql_num_rows($query) > 1)
		                            $this->result[$i][$key[$x]] = $r[$key[$x]];
		                        else if(mysql_num_rows($query) < 1)
		                            $this->result = null; 
		                        else
		                            $this->result[$key[$x]] = $r[$key[$x]]; 
		                    }
		                }
		            }            
		            return true; 
		            
		        } else {
			        
		            return false; 
		        }
		        
		    } else {
			    
		      return false; 
		    }

		}
		
		
		//function to connect to databsae
		public function connect()
	    {
	        if(!$this->con)
	        {
	            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
	            if($myconn)
	            {
	                $seldb = @mysql_select_db($this->db_name,$myconn);
	                if($seldb)
	                {
	                    $this->con = true; 
	                    return true; 
	                } else
	                {
	                    return false; 
	                }
	            } else
	            {
	                return false; 
	            }
	        } else
	        {
	            return true; 
	        }
	    }
	    
	    // Escape your string
		public function escapeString($data){
			if (function_exists('mysql_real_escape_string') && $myconn) {
				$data = mysql_real_escape_string($data, $myconn);
			} else {
				$data = mysql_escape_string($data);
			}
			return $data;
			}
	    
	    //function to close datbase conneciton
	    public function disconnect()
		{
		    if($this->con)
		    {
		        if(@mysql_close())
		        {
		                       $this->con = false; 
		            return true; 
		        }
		        else
		        {
		            return false; 
		        }
		    }
		}
		
		public function lastInsertedRecordID() {
			
			$id = mysql_insert_id();
			
			return $id;
		}

		
		public function select($table, $rows = '*', $where = null, $order = null)
	    {
	        $q = 'SELECT '.$rows.' FROM '.$table;
	        if($where != null)
	            $q .= ' WHERE '.$where;
	        if($order != null)
	            $q .= ' ORDER BY '.$order;
	            
	        if($this->tableExists($table))
		    {
		        $query = @mysql_query($q);
		        
		        if($query)
		        {
		            $numResults = mysql_num_rows($query);
		      
		            for($i = 0; $i < $numResults; $i++)
		            {
		                $r = mysql_fetch_array($query);
		                $key = array_keys($r); 
		                
		                for($x = 0; $x < count($key); $x++)
		                {
			             
							//echo($key[$x]);
							// echo("</br>");
							// Sanitizes keys so only alphavalues are allowed
		                    if(!is_int($key[$x]))
		                    {
		                        if(mysql_num_rows($query) > 1)
		                            $this->result[$i][$key[$x]] = $r[$key[$x]];
		                        else if(mysql_num_rows($query) < 1)
		                            $this->result = null; 
		                        else
		                            $this->result[$key[$x]] = $r[$key[$x]]; 
		                    }
		                }
		            }            
		            return true; 
		            
		        } else {
			        
		            return false; 
		        }
		        
		    } else {
			    
		      return false; 
		    }
			
		}
		
		public function selectWithOutKey($table, $rows = '*', $where = null, $order = null)
	    {
	        $q = 'SELECT '.$rows.' FROM '.$table;
	        if($where != null)
	            $q .= ' WHERE '.$where;
	        if($order != null)
	            $q .= ' ORDER BY '.$order;
	            
	        if($this->tableExists($table))
		    {
		        $query = @mysql_query($q);
		        
		        if($query)
		        {
		            $numResults = mysql_num_rows($query);
		      
		            for($i = 0; $i < $numResults; $i++)
		            {
		                $r = mysql_fetch_array($query);
		                //$key = array_keys($r);
		                
		                $values = array_values($r);
						$this->result = array();
						//for($x = 0; $x < count($values); $x++)
						foreach( $values as $value )
		                {
			                array_push($this->result, $value);
			             
							/*
							//echo($key[$x]);
							// echo("</br>");
							// Sanitizes keys so only alphavalues are allowed
		                    if(!is_int($key[$x]))
		                    {
		                        if(mysql_num_rows($query) > 1)
		                            $this->result[$i][$key[$x]] = $r[$key[$x]];
		                        else if(mysql_num_rows($query) < 1)
		                            $this->result = null; 
		                        else
		                            $this->result[$key[$x]] = $r[$key[$x]]; 
		                    }
							*/
		                }
						
		            }            
		            return true; 
		            
		        } else {
			        
		            return false; 
		        }
		        
		    } else {
			    
		      return false; 
		    }
			
		}

		
		public function selectCheck($table, $rows = '*', $where = null, $order = null)
	    {
	        $q = 'SELECT '.$rows.' FROM '.$table;
	        if($where != null)
	            $q .= ' WHERE '.$where;
	        if($order != null)
	            $q .= ' ORDER BY '.$order;
	            
	        if($this->tableExists($table))
		    {
		        $query = @mysql_query($q);
		        
		        if(mysql_num_rows($query) > 0)
		        {        
			         $this->result = array("message" => "Found");
			   		 return true; 
		            
		        } else {
			        $this->result = array("message" => "Not Found");
		            return false; 
		        }
		        
		    } else {
			    
		      return false; 
		    }
			
		}

		
		// Function to insert into the database
		public function insert($table, $params=array()){
    		// Check to see if the table exists
			if($this->tableExists($table)){
    	 		$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
		 		$this->myQuery = $sql; // Pass back the SQL
		 		// Make the query to insert to the database
		 		if($ins = @mysql_query($sql)){
            		array_push($this->result, mysql_insert_id());
					return true; // The data has been inserted
				}else{
					array_push($this->result, mysql_error());
					return false; // The data has not been inserted
				}
        	}else{
        		return false; // Table does not exist
			}
    	}    	
    
    	public function delete($table,$where = null)
	    {
	        if($this->tableExists($table))
	        {
	            if($where == null)
	            {
	                $delete = 'DELETE '.$table; 
	            }
	            else
	            {
	                $delete = 'DELETE FROM '.$table.' WHERE '.$where; 
	            }
	            $del = @mysql_query($delete);
	 
	            if($del)
	            {
	                return true; 
	            }
	            else
	            {
	               return false; 
	            }
	        }
	        else
	        {
	            return false; 
	        }
	    }

	    
	  
		public function update($table,$rows,$where)
	    {
	        if($this->tableExists($table))
	        {
	            // Parse the where values
	            // even values (including 0) contain the where rows
	            // odd values contain the clauses for the row
	            for($i = 0; $i < count($where); $i++)
	            {
	                if($i%2 != 0)
	                {
	                    if(is_string($where[$i]))
	                    {
	                        if(($i+1) != null)
	                            $where[$i] = '"'.$where[$i].'" AND ';
	                        else
	                            $where[$i] = '"'.$where[$i].'"';
	                    }
	                }
	            }
	            $where = implode('=',$where);
	             
	             
	            $update = 'UPDATE '.$table.' SET ';
	            $keys = array_keys($rows); 
	            for($i = 0; $i < count($rows); $i++)
	           {
	                if(is_string($rows[$keys[$i]]))
	                {
	                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
	                }
	                else
	                {
	                    $update .= $keys[$i].'='.$rows[$keys[$i]];
	                }
	                 
	                // Parse to add commas
	                if($i != count($rows)-1)
	                {
	                    $update .= ','; 
	                }
	            }
	            $update .= ' WHERE '.$where;
	            $query = @mysql_query($update);
	            if($query)
	            {
	                return true; 
	            }
	            else
	            {
	                return false; 
	            }
	        }
	        else
	        {
	            return false; 
	        }
	    }
	    
	    
	    public function clearResult() {
		    
		    $this->result = array();
	    }
	    
	    public function getResult() {
		    
		    
		    //$json["Car"][] = $this->result;
		    
		    $json = $this->result;
		    
		    return $json;
	    }

	}
	
	
	
	
	?>