<?php
ini_set('max_execution_time',10000);
$conn = mysqli_connect("localhost","aaronsha_w4admin","w4admin@123","aaronsha_w4");
if (mysqli_connect_errno()){
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$urll = file_get_contents('followers.json');
$i=0;
$arraydata=json_decode($urll , true);
foreach($arraydata as $data)
{ 
	if($i <=100){
		 $url = 'https://twitter.com/'.$data;
		 
		 $curl = curl_init($url);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			$result = curl_exec($curl);
			if ($result !== false) {
			  $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
			  if ($statusCode == 404) {
				echo "URL Not Exists";
			  }
			  else{  
                    $sql1=mysqli_query($conn,"SELECT `screen_name` FROM `birthdate_save` WHERE `screen_name`='".$data."'");
					if($sql1==TRUE){
						echo "same";
					}else{
					$url3 = file_get_contents('https://twitter.com/'.$data);
					$first_step = explode( '<div class="ProfileHeaderCard-birthdate">' , $url3 );
					$second_step = explode("</div>" , $first_step[1]);
					
					if(empty($second_step[0])){
						}
						         else{		
									 $dt = strip_tags("<span>".$second_step[0]."</span>"); 
									 $sql = mysqli_query($conn,"INSERT INTO `birthdate_save`(`birthdate`,`screen_name`) VALUES('".$dt."', '".$data."')");
									  if ($sql){
											echo "New record created successfully";}
											else{
												echo "Error: " . $sql . "<br>" . $conn->error;}  
									}
					     }									
					} 
				}
					else{
					   echo "URL not Exists";}
						echo $i;
						 $i++;
						}else{
							sleep(5);
							 $i=0;
						}
					}

?>