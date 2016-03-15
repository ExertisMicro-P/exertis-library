<?php
/*
 Folder Tree with PHP and jQuery.

 R. Savoul Pelister
 http://techlister.com

*/
require_once '../classes/dbClass.php';


class treeview {
    
	private $files;
	private $folder;
	
	function __construct( $path ) {
            
		$files = array();	
		
		if( file_exists( $path)) {
			if( $path[ strlen( $path ) - 1 ] ==  '/' )
				$this->folder = $path;
			else
				$this->folder = $path . '/';
			
			$this->dir = opendir( $path );
			while(( $file = readdir( $this->dir ) ) != false )
				$this->files[] = $file;
			closedir( $this->dir );
		}
	}

	function create_tree( ) {
			
		if( count( $this->files ) > 2 ) { /* First 2 entries are . and ..  -skip them */
                        
			natcasesort( $this->files );
			$list = '<ul class="filetree" style="display: none;">';
                        
                        if(isset(explode('=', $_SERVER['HTTP_REFERER'])[1])){
                            $id = explode('=', $_SERVER['HTTP_REFERER'])[1];
                            
                            $files = dbClass::getAccessableFiles($id);
                            $filesNeedsToBeChecked = [];
                            foreach($files as $fl){
                                $filesNeedsToBeChecked[] .= $fl['file'];
                            }
                            
                                foreach( $this->files as $file ) {
                                        if( file_exists( $this->folder . $file ) && $file != '.' && $file != '..' && is_dir( $this->folder . $file )) {
                                                $fls = str_replace('/', '', explode('../../files/', $this->folder)[1]);
                                                                                                                                                                                                
                                            if(in_array($file, $filesNeedsToBeChecked)){
                                                $list .= '<li class="folder collapsed checkAll"><input type="checkbox" checked name="file[]" value="'.$this->folder.$file.'" class="left"><a href="#" rel="' . htmlentities( $this->folder . $file ) . '/">' . htmlentities( $file ) . '</a></li>';
                                            } else {
                                                $list .= '<li class="folder collapsed checkAll"><input type="checkbox" name="file[]" value="'.$this->folder.$file.'" class="left"><a href="#" rel="' . htmlentities( $this->folder . $file ) . '/">' . htmlentities( $file ) . '</a></li>';
                                            }
                                        }
                                }
                                // Group all files
                                foreach( $this->files as $file ) {
                                        if( file_exists( $this->folder . $file ) && $file != '.' && $file != '..' && !is_dir( $this->folder . $file )) {
                                                $ext = preg_replace('/^.*\./', '', $file);
                                                $fls = $this->folder . $file;
                                                $fls = explode('../../files/', $fls)[1];
                                                
                                                if(in_array($fls, $filesNeedsToBeChecked)){
                                                    $list .= '<li class="file ext_' . $ext . '"><a for="'.$file.'" rel="' . htmlentities( $this->folder . $file ) . '">' . htmlentities( $file ) . '</a></li>';
                                                } else {
                                                    $list .= '<li class="file ext_' . $ext . '"><a for="'.$file.'" rel="' . htmlentities( $this->folder . $file ) . '">' . htmlentities( $file ) . '</a></li>';
                                                }
                                        }
                                }
                            
                        } else {
			// Group folders first
                            foreach( $this->files as $file ) {
                                    if( file_exists( $this->folder . $file ) && $file != '.' && $file != '..' && is_dir( $this->folder . $file )) {
                                            $list .= '<li class="folder collapsed checkAll"><input type="checkbox" name="file[]" value="'.$this->folder.$file.'" class="left"><a href="#" rel="' . htmlentities( $this->folder . $file ) . '/">' . htmlentities( $file ) . '</a></li>';
                                    }
                            }
                            // Group all files
                            foreach( $this->files as $file ) {
                                    if( file_exists( $this->folder . $file ) && $file != '.' && $file != '..' && !is_dir( $this->folder . $file )) {
                                            $ext = preg_replace('/^.*\./', '', $file);
                                            $list .= '<li class="file ext_' . $ext . '"><a for="'.$file.'" rel="' . htmlentities( $this->folder . $file ) . '">' . htmlentities( $file ) . '</a></li>';
                                    }
                            }
                        }
                        
			$list .= '</ul>';	
			return $list;
		}
	}
}

$path = urldecode( $_REQUEST['dir'] );
$tree = new treeview( $path );
echo $tree->create_tree();
?>