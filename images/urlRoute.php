<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	session_start();
	include 'classes/simpleUrl.php';
	$aUrl = new simpleUrl;



	/******************************************
				 BUILDING THE PAGE
	*/

	/*HEAD*/
	include 'templates/mStart.php';

	/*HEADER*/
	include 'templates/header.php';

	/*CONTENT*/
	switch ($aUrl()[0]) {
	    case 'FAQ':
	    	include 'pages/faq.php';
	        break;
	    case 'PROFILE':
	    	if(isset($aUrl()[1])){
	    		switch ($aUrl()[1]) {
                        
	    			case 'EDIT':
	    				include 'pages/editprofile.php';
	    				echo '</br>';
	    				break;
                    
	    			default:
	    			$profileId = $aUrl()[1];
	    			include 'pages/profile.php';
	    				break;
	    		}
                
	    	}else{
                include 'pages/profile.php';
            }
	    	break;
	    
            -********************************
                
            case 'PRODUCTS':
                if(isset($aUrl()[1])){
                    switch ($aUrl()[1]) {

                    case 'ADD':
                        include 'pages/addproduct.php';
                        echo '</br>';
                        break;

                    case 'PRODUCTID':
                        if(isset($aUrl()[2])){
	    		             switch ($aUrl()[2]) {
                        
                            case 'REVIEW':
                                include 'pages/makeReview.php';
                                echo '</br>';
                                break;

                            default:
                            $profileId = $aUrl()[2];
                            include 'pages/booking.php';
                            break;
                        }

                    }else{
                            include 'pages/booking.php';
                        }

                    default:
                    $profileId = $aUrl()[1];
                    include 'pages/index.php';
                        break;
                    }

                }else{
                    include 'pages/index.php';
                }
	    	break;
                *************************

	    default:
	        echo '3code to be executed if n is different from all labels</br>';
	}

	/*FOOTER*/
	include 'templates/footer.php';

	/*END OF BODY*/
	include 'templates/mEnd.php';

?>
