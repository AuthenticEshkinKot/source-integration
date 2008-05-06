<?php
# Copyright (C) 2008	John Reese
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );

$f_repo_id = gpc_get_int( 'repo_id' );
$f_repo_name = gpc_get_string( 'repo_name' );
$f_repo_url = gpc_get_string( 'repo_url' );

$t_repo = SourceRepo::load( $f_repo_id );
$t_type = SourceType($t_repo->type);

$t_repo->name = $f_repo_name;
$t_repo->url = $f_repo_url;

$t_updated_repo = event_signal( 'EVENT_SOURCE_UPDATE_REPO', array( $t_repo ) );

if ( !is_null( $t_updated_repo ) ) {
	$t_updated_repo->save();
} else {
	$t_repo->save();
}

print_successful_redirect( plugin_page( 'repo_manage_page', true ) . '&id=' . $t_repo->id );

