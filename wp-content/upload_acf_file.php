<?php
set_time_limit(0);

/* Source File URL */
$remote_file_url = 'http://jamesway-dev.itwdev3.info/wp-content/ai1wm-backups/jamesway-dev.itwdev3.info-20211104-101859-546.wpress';

/* New file name and path for this file */
$local_file = __DIR__.'/jamesway-dev.itwdev3.info-20211104-101859-546.wpress';

/* Copy the file from source url to server */
$copy = copy( $remote_file_url, $local_file );

/* Add notice for success/failure */
if( !$copy ) {
    echo "Doh! failed to copy $local_file...\n";
}
else{
    echo "WOOT! success to copy $local_file...\n";
}