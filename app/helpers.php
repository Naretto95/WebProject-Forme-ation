<?php

if (!function_exists('page_title')) {
	function page_title($title)
	{
		$base_title = config('app.name');
		return empty($title) ? $base_title : sprintf('%s | %s', $title, $base_title);
	}
}

if (!function_exists('set_active_route')) {
	function set_active_route($route)
	{
		return Route::is($route) ? 'active' : '';
	}
}

if(!function_exists('flash')){
	function flash($message, $type = 'success'){
		Session::flash('notification.message', $message);
        Session::flash('notification.type', $type);
	}
}

if(!function_exists('set_selected')){
	function set_selected($value, $old_value){
		return $value == $old_value ? 'selected' : '';
	}
}

if(!function_exists('isSuperAdmin')){
	function isSuperAdmin($user){
		return $user && $user->status === 'super-admin';
	}
}

if(!function_exists('isAdmin')){
	function isAdmin($user){
		return $user && ($user->status === 'super-admin' || $user->status === 'admin');
	}
}

if(!function_exists('isUser')){
	function isUser($user){
		return $user && $user->status === 'user';
	}
}