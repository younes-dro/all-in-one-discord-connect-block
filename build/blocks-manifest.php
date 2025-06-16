<?php
// This file is generated. Do not modify it manually.
return array(
	'all-in-one-discord-connect-block' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'dro-block/all-in-one-discord-connect-block',
		'version' => '1.0.0',
		'title' => 'AIO Discord Connect Block',
		'category' => 'widgets',
		'description' => 'Displays a customizable "Connect to Discord" button',
		'example' => array(
			
		),
		'attributes' => array(
			'connectButtonTextColor' => array(
				'type' => 'string',
				'default' => '#ffffff'
			),
			'connectButtonBgColor' => array(
				'type' => 'string',
				'default' => '#77a02e'
			),
			'disconnectButtonTextColor' => array(
				'type' => 'string',
				'default' => '#ffffff'
			),
			'disconnectButtonBgColor' => array(
				'type' => 'string',
				'default' => '#ffffff'
			),
			'loggedInText' => array(
				'type' => 'string',
				'default' => 'Connect to Discord'
			),
			'loggedOutText' => array(
				'type' => 'string',
				'default' => 'Disconnect from Discord'
			),
			'roleWillAssignText' => array(
				'type' => 'string',
				'default' => 'You will be assigned the following Discord roles:'
			),
			'roleAssignedText' => array(
				'type' => 'string',
				'default' => 'You have been assigned the following Discord roles:'
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'dro-aio-dcc-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js',
		'render' => 'file:./render.php'
	)
);
