<?php	// API/LOAD.AJAX.PHP		// Returns  the  current contents  of
	// =================		// the  Linora  database  as  a  two-
	//				// column HTML table with
	//   (c) C Lester 2013,2014	//	class="LinkTable"
	//				// - the first column  is the caption
	// of a  link,  the  second is an  <a�href=...>  of the URL  and  the
	// caption.  The table is sorted on  first the category,  then on the
	// caption.



    DEFINE ( "_debugging_",	FALSE );

    DEFINE ( "_logging_",	TRUE );
    DEFINE ( "_log_source_",	"GET LINK-TABLE" );
	DEFINE ( "_log_filename_",	$_SERVER["DOCUMENT_ROOT"] . "/API/_API_.LOG" );

    INCLUDE $_SERVER["DOCUMENT_ROOT"] . "/API/hidden/(LINORA).inc.php";	// Linora-specific defines and function
    INCLUDE $_SERVER["DOCUMENT_ROOT"] . "/API/hidden/(DB_EASY).inc.php";// Reusable mysqli-database utilities
    if (_logging_) INCLUDE $_SERVER["DOCUMENT_ROOT"] . "/API/hidden/LOGGING.inc.php";
				// For logging, if required



    $DB = new DB_easy;
    $_select_ = $DB->Query("SELECT * FROM entries ORDER BY cat,cap ASC",__file__,__line__);
		// No parameters, so no security issue, so no PREPAREing or binding.

    if ( $_select_->rowCount() == 0 ) // i.e. if no rows
      { echo "No links have been archived yet.<br/>\r\n"; }
    else // Horrible! would be better to return JSON - then could use a private
	 // library function to turn the resultset into the JSON. BUT keep it simple
         // and return HTML for more straigtforward start-of-unit teaching.
      { echo "<table class='LinkTable' cellspacing='0'>".
	     "<tr><td colspan='3'></td></tr>";
	while ($row = $_select_->fetch(PDO::FETCH_ASSOC))
	  { echo "<tr>";
	    echo "<td>".$row['cat']."&nbsp;&nbsp;</td>";
	    if ($row['url']=="")
		echo "<td>".$row['cap']."</td>";
	    else
		echo "<td><a href='".$row['url']."'>".$row['cap']."</a></td>";
	    echo "</tr>\r\n";
	  }
	echo "<tr><td colspan='3'></td></tr>".
	     "</table>\r\n\n";
      }



    $DB->Close();

    log_close_("");


?>
