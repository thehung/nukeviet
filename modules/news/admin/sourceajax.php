<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$q = $nv_Request->get_title( 'term', 'get', '', 1 );
if( empty( $q ) ) return;

$db->sqlreset()
	->select( 'title, link' )
	->from( NV_PREFIXLANG . '_' . $module_data . '_sources' )
	->where( 'title LIKE :title OR link LIKE :link' )
	->order( 'weight ASC' )
	->limit( 50 );

$sth = $db->prepare( $db->sql() );
$sth->bindParam( ':title', '%' . $q . '%', PDO::PARAM_STR );
$sth->bindParam( ':link', '%' . $q . '%', PDO::PARAM_STR );
$sth->execute();

$array_data = array();
while( list( $title, $link ) = $result->fetch( 3 ) )
{
	$array_data[] = array( 'label' => $title . ': ' . $link, 'value' => $link );
}

header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Content-type: application/json' );

ob_start( 'ob_gzhandler' );
echo json_encode( $array_data );
exit();

?>