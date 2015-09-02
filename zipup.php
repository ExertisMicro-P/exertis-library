<?php

/**
 * CLEANSE FILE LIST
 * =================
 * This works through the file list sent from the browser to ensure that all
 * files are in the correct location and so avoid hacking attempts to retrieve
 * files from elsewhere on the server.
 *
 */
function cleanseFileList()
{
    $fileList = ['folders' => [], 'files' => [] ] ;
    $files    = json_decode($_POST['files'], true) ;

    $rootDir = dirname(__FILE__) . '/' ;

    foreach ($files as $fileInfo) {

        $fname = realpath($rootDir . $fileInfo['name']);

        if ($fname && substr($fname, 0, strlen($rootDir)) == $rootDir) {

            if ($fileInfo['type'] == 'folder') {
                // -----------------------------------------------------------
                // To simplify checks in removeDuplicates, add the trailing
                // slash to all directory names
                // -----------------------------------------------------------
                $fileList['folders'][] = $fname . '/';

            } else {
                $fileList['files'][] = $fname ;
            }
        }
    }
    return $fileList ;
}

/**
 * REMOVE DUPLICATES
 * =================
 * This checks the list of specific files against the list of directories. If
 * the container directory was also chosen, the file is removed from the list.
 *
 * @param $fileList
 *
 * @return array
 */
function removeDuplicates($fileList) {
    $selectedFiles['folders'] = $fileList['folders'] ;

    if (count($selectedFiles)) {
        foreach ($fileList['files'] as $filename) {

            foreach ($fileList['folders'] as $index => $folderName) {
                if (substr($filename, 0, strlen($folderName)) == $folderName) {
                    unset($fileList['files'][$index]) ;
                    break ;
                }
            }
//            if ($filename) {
//                $selectedFiles[] = $filename ;
//            }
        }
    } elseif (count($fileList['files'])) {
        $selectedFiles = $fileList['files'] ;
    }
    return $fileList ;
}

/**
 * ZIP THE FILES
 * =============
 *
 * @param $fileList
 *
 * @return bool
 */
function zipTheFiles($fileList) {
    $zip = new ZipArchive();

    $destination = tempnam('tmp', mktime()) ;
    rename($destination, $destination . '.zip') ;
    $destination .= '.zip' ;

    if ($zip->open($destination, ZIPARCHIVE::OVERWRITE) !== true) {
        return false;
    }
    $rootDir = dirname(__FILE__) . '/' ;
    $rdLen = strlen($rootDir) ;


    foreach ($fileList['folders'] as $folder) {
        $dir_iterator = new RecursiveDirectoryIterator($folder);
        $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $file) {
            $baseName = $file->getBasename() ;
            if (substr($baseName, 0, 1) <> '.') {
                if (!is_dir($file)) {
                    $outname = substr($file, $rdLen);
                    $zip->addFile($file, $outname);
                }
            }
        }
    }

    foreach ($fileList['files'] as $file) {
        $outname = substr($file, $rdLen) ;
        $zip->addFile($file, $outname);
    }
    $res = $zip->close();

    return $destination ;
}

// Output the directory listing as JSON

$fileList = cleanseFileList() ;
$fileList = removeDuplicates($fileList) ;

if (count($fileList['folders']) || count($fileList['files'])) {
    $fullName = zipTheFiles($fileList) ;

    if ($fullName) {
        $docRoot = $_SERVER['DOCUMENT_ROOT'] ;

        $output = substr($fullName, strlen($docRoot . '/tmp/')) ;
    }

} else {
    $output = '' ;
}
$info =  "\n$fullName" ;
$info .= ' ' . filesize($fullName) ;



header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$output\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($fullName));

readfile($fullName);

exit ;

header('Content-type: application/json');

echo json_encode(array(
    "ok"       => $output <> '',
    "filename" => $output
));
