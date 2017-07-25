<?php
// header('Access-Control-Allow-Origin: http://188.226.140.143', false);
 header('Access-Control-Allow-Origin: localhost', false);

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	session_start();
    //SIMPLE INCLUDE MUST BE REMOVED. 
    //INCLUDED PAGES ARE NOT HAVING AcCESS TO GLOBAL (UPPER LEVEL) VARIABLES
    //problem: PROFILE can't be opened for a certain user id that was set before 
    include 'classes/simpleInclude.php';
    $INCLUDE = new simpleInclude;
    $INCLUDE('class','simpleUrl');
	$aUrl = new simpleUrl;


	/******************************************
				 BUILDING THE PAGE
	*/

	/*HEAD*/
    $INCLUDE('page','mStart');

    /*HEADER*/
    include 'pages/header.php';

	/*CONTENT*/

if (isset($aUrl()[1])){
	switch ($aUrl()[1]) {
	    

	    case 'PROFILE':
            if(isset($aUrl()[2])){
                switch ($aUrl()[2]) {
                    case 'EDIT':
                        $profileId = $_SESSION["userIdSession"];
                        include('pages/editprofile.php');
                    break;
                    default:
                        $profileId = $aUrl()[2];
                        include('pages/profile.php');
                        //$INCLUDE('page','profile');
                    break;
                }
            }else{
                if(isset($_SESSION["userIdSession"])){
                    $profileId = $_SESSION["userIdSession"];
                    include('pages/profile.php');
                }else{
                    include('pages/index.php');
                }
            }
        break;
            
        case 'PRODUCTS':
            if(isset($aUrl()[2])){
                switch ($aUrl()[2]) {
                    case 'ADD':
                        $INCLUDE('page','addproduct');
                    break;
                    default:
                        if(isset($aUrl()[3])){
                            switch ($aUrl()[3]) {
                                case 'REVIEW':
                                    include('pages/makeReview.php');
                                break;
                                default:
                                    $itemId = $aUrl()[2];
                                    include('pages/booking.php');
                                break;
                            }
                        }else{
                            $itemId = $aUrl()[2];
                            include('pages/booking.php');
                        }
                    break;
                }
            }else{
                $INCLUDE('page','index');
            }
        break;
       
       	case 'FAQ':
            $INCLUDE('page','faq');
	    //include('pages/faq.php');
        break;
            
        case 'MESSAGES':
            include('pages/messenger.php');
        break;

	    default:
            $INCLUDE('page','index');
	    break;
	}
}else{
 $INCLUDE('page','index');
}
	/*FOOTER*/
    $INCLUDE('page','footer');

	/*END OF BODY*/
    $INCLUDE('page','mEnd');

?>
