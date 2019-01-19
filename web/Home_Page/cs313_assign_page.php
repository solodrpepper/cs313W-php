<!-- Get Directory -->
<?php
// create a PHP object with the filename,filetype, and cwd properties.
class fileN
{
    public $fileName;
    public $fileType;
    public $cwd;
}

$cwd = getcwd(); // get path to the current working directory
$folder = "."; // Set the folder variable to specify the "current" directory

// create an array of filenames of files from the current directory
$files = scandir($folder);
$directory = array(); // create a array object to store a list of objects.

/*******************************************************************************
 *  Start your PHP code here!
 *
 * Add code to populate the "$directory" array with a list of "fileN" objects.
 * Use "new fileN()" to create a fileN object.    $directory[$i] = new fileN();
 * Set each fileN object property to the appropriate values.
 * You can get each file name from the "$files" array.
 * You can get each file type by calling the php function "filetype()" passing it the filename.
 * The "filetype()" function returns the file type. The returned file type is either "file" or "dir".
 * The current working directory has been stored in $cwd.
 * To get the size of an array in php use the sizeof function:  $len = sizeof($files);
 *****************************************************************/

// loop through files
for ($i = 0; $i < sizeof($files); $i++) {
    // create new object
    $directory[$i] = new fileN();
    $directory[$i]->fileName = $files[$i];
    $directory[$i]->fileType = filetype($files[$i]);
    $directory[$i]->cwd = $cwd;
}

/*******************End of your Code *******************************************/

// convert the PHP array of objects to a JSON string
$str = json_encode($directory);
?>


<!DOCTYPE html>
<head>
<title>Austin Kincade</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <!-- CSS -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link
        rel="stylesheet"
        href="home_page.css"
    />
    <!-- Javascript -->
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <!-- Getting the JSON -->
    <script type="text/javascript">
        var directory = <?php echo json_encode($str); ?>;
        
        // this is for the JSON stuff
		function processJSON()
		{
            var myObj = JSON.parse(directory);
            var list = "<table><tr><th>Project Name</th></tr>\n";

            for (var i = 0; i < myObj.length; i++)
            {
                list = list + "<tr><td>" + myObj[i].fileName + "</td>" +
                              "<td><button class=\"button rounded_border\" onclick='window.location=`" + myObj[i].fileName + '/home.php' "`' >Visit</button>" + "</td></tr>\n";
            }
            document.getElementById("directory").innerHTML = list;
		}
	</script>
</head>
<body onload="processJSON()">
<header>My Projects</header>
<!-- For Navbar -->
<?php
// By using require here, instead of include, we have decided that if that nav.php
// page is not available, we want the page to crash.
require "nav.php";
?>
    <div id="directory" class="container">
	</div>
</body>
</html>