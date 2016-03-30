<?php

require_once 'backend/classes/dbClass.php';


$dir = "files";

// Run the recursive function

$response = scan($dir);


// This function scans the files folder recursively, and builds a large array

function scan($dir)
{

    $accessableFiles = dbClass::getAccessableFiles($_COOKIE['userId']);
    $folder = [];



    foreach ($accessableFiles as $index => $code){    

        if(strpos($code['file'], '/') !== false){
            $code['file'] = explode('/', $code['file'])[1];
        }
        
        $folder[] = $code['file'];
    }
    
    
    

    $files = array();

    // Is there actually such a folder/file?
    
    if (file_exists($dir)) {
        
        
                
        $allowedFolder = $accessableFiles[0]['file'];
        
        foreach (scandir($dir) as $f) {
            
            if (!$f || $f[0] == '.') {
                continue; // Ignore hidden files
            }
            
            
            if (is_dir($dir . '/' . $f)) {

                // The path is a folder
                
                
                for($i=0; $i<count($folder); $i++){
                    
                    if($f == $folder[$i]){

                        $files[] = array(
                            "name"    => $f,
                            "type"    => "folder",
                            'checked' => false,
                            "path"    => $dir . '/' . $f,
                            "items"   => scan($dir . '/' . $f) // Recursively get the contents of the folder
                        );
                    }
                    
                }
                
                
            } else {

                // It is a file

                $files[] = array(
                    "name"    => $f,
                    "type"    => "file",
                    'checked' => false,
                    "path"    => $dir . '/' . $f,
                    "size"    => filesize($dir . '/' . $f) // Gets the size of this file
                );
            }
        }
    }

    return $files;
}


// Output the directory listing as JSON

header('Content-type: application/json');

echo json_encode(array(
    "name"  => "files",
    "type"  => "folder",
    "path"  => $dir,
    "items" => $response
));
