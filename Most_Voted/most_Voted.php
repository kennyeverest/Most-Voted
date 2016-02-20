<?php

class Most_Voted 

{
				private $con;
				private $sql_result;
				private $arr_result;
				
				/**
				Constructor untuk melakukan koneksi ke database
				Parameter :
										1. $server		--> server komputer 
										2. $user			--> account mysql
										3. $password 	--> password account mysql
										4. $db				--> nama database yang akan digunakan	
				**/
				
				public function __construct($server, $user, $password, $db)
				{
					$this->arr_result = array();
					
					$this->con = mysqli_connect($server,$user,$password,$db);
					
					if(mysqli_connect_errno())
					{
						
							echo "Error ".mysqli_connect_error()."</br>";
									
					}
				
				}
				
				/**
				Function untuk menjalankan perintah query di mysql dan menyimpan hasil query pada variable 
				$sql_result
				
				Parameter :
										1. query --> perintah query yang akan dijalankan (string)
				
				Tipe			: Void 
				**/
				
				
				public function run_query($query)
				{
					
					$result = mysqli_query($this->con,$query);
					//$this->arr_result = $result->fetch_all();
					$this->sql_result = $result;
					mysqli_close($this->con);
					
				}
				
				/**
				Getter function untuk variable / attribut $sql_result
				**/
				
				public function getSql_result()
				{
					return $this->sql_result();
				}
				
				/**
				Getter function untuk variable / attribut $con
				**/
				
				public function getCon()
				{
					return $this->con;
				}
				
				/**
				Function untuk mendapatkan voting terbanyak pada actions 
				dan menyimpan dalam variable class $arr_result
				
				Tipe : void
				**/
				
				public function getMostVoted()
				{
					$i = 0;
					
					while($row = $this->sql_result->fetch_assoc())
					{
						//echo $row['title']."</br>";
						$this->arr_result[$i++] = $row;
					}
					
				}
				
				/**
				Function untuk menampilkan actions terpopuler 
				dengan banyak sesuai dengan permintaan
				
				Parameter	:
										1. $num		--> banyak list yang akan ditampilkan
										
				tipe			: void
				**/
				
				public function displayMostVoted($num)
				{
					
					if($num > count($this->arr_result))
					{
						die('Index of array is Out of bound');
					}
					
					for($x = 0; $x < $num; $x++)
					{
						echo $this->arr_result[$x]['title']."</br>";
					}
					 	
				}
}

/** End of Most_Voted Class **/



															/**

																					Langkah eksekusi class

															1. Inisasi class 
															2. Menjalankan perintah query
															3. Invoke function run_query
															4. Invoke funciton getMostVoted
															5. Invoke function displayMostVoted

															**/
														
//Stub driver untuk class Most_Voted

$t = new Most_Voted('localhost','root','kenny','finitivedb');

$query = 'SELECT a.title AS title, b.actions_id as id,
count(id) as total_votes
FROM actions a inner join votes b
on a.id = b.actions_id
GROUP BY b.actions_id  ORDER BY total_votes DESC ';

$t->run_query($query);
$t->getMostVoted();
$t->displayMostVoted(3);

/** End of Stub driver **/


