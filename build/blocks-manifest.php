<?php
// This file is generated. Do not modify it manually.
return array(
	'all-in-one-discord-connect-block' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'dro-blocks/all-in-one-discord-connect-block',
		'version' => '1.0.0',
		'title' => 'AIO Discord Connect Block',
		'category' => 'widgets',
		'description' => 'Displays a customizable "Connect to Discord" button that integrates with supported membership plugins like Paid Memberships Pro, MemberPress, and Ultimate Member, as well as LMS plugins such as Tutor LMS, LearnDash',
		'example' => array(
			
		),
		'attributes' => array(
			'btnColor' => array(
				'type' => 'string',
				'default' => '#77a02e'
			),
			'disconnectBtnColor' => array(
				'type' => 'string',
				'default' => '#ff0000'
			),
			'loggedInText' => array(
				'type' => 'string',
				'default' => 'You are logged in as {username}. Click to connect to Discord.'
			),
			'loggedOutText' => array(
				'type' => 'string',
				'default' => 'You must be logged in to connect to Discord'
			),
			'disconnectText' => array(
				'type' => 'string',
				'default' => 'Disconnect From Discord'
			),
			'roleWillAssignText' => array(
				'type' => 'string',
				'default' => 'You will be assigned the following Discord roles:'
			),
			'roleAssignedText' => array(
				'type' => 'string',
				'default' => 'You have been assigned the following Discord roles:'
			),
			'connectedUsername' => array(
				'type' => 'string'
			),
			'rolesHtml' => array(
				'type' => 'string'
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
