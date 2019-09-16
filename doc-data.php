<?php

/**
* Available method names: get, collection, post, patch, delete, getRelationships, getRelationshipData, postRelationships, patchRelationships, deleteRelationships
*/

return [
	[
		'title' => 'Users',
		'description' => 'User resources',
		'name' => 'User',
		'type' => 'users',
		'methods' => [], // Available methods, default is all (get, collection, post, patch, delete)
		'id' => [
			'type' => 'string:uuid'
		],
		'attributes' => [
			'name' => [
				'type' => 'string',
				'description' => 'User full name (6-100 chars)',
				'methods' => [
					'get', 
					'collection',
					'getRelationshipData',
					'post' => [
						'required' => true
					],
					'patch' => [
						'required' => false
					],
				]
			],
			'email' => [
				'type' => 'string',
				'description' => 'User email address',
				'methods' => [
					[
						'get', 
						'collection', 
						'post' => [
							'required' => true
						],
						'getRelationshipData'
					]
				]
			],
			'password' => [
				'type' => 'string',
				'description' => 'User password',
				'methods' => [
					'post' => [
						'required' => true
					], 
					'patch', // (Default) required: false
				]
			],
		],
		'relationships' => [
			'posts' => [
				'type' => 'posts',
				'relationship_type' => 'many',
				'methods' => [
					'getRelationships', 'getRelationshipData', 'postRelationships'
				],
			],
			'country' => [
				'type' => 'countries',
				'relationship_type' => 'one',
				// methods is not set => default only available 2 methods: getRelationships, getRelationshipData 
			]
		],
		'filters' => [
			'limit' => 'The maximum number of results to show on a page.', 
			'page' => 'The page of results to show.',
			'ids' => 'Retrieve only users specified by a comma-separated list of order IDs.'
		],
	],
	[
		'title' => 'Countries',
		'description' => 'User resource',
		'name' => 'Country',
		'type' => 'countries',
		'methods' => [
			'get', 
			'collection', 
		],
		'id' => [
			'type' => 'integer'
		],
		'attributes' => [
			'name' => [
				'type' => 'string',
				'description' => 'Country name'
			], // Methods is not set or blank = all methods
			'code' => [
				'type' => 'string',
				'description' => 'Country code'
			]
		]
	],
	[
		'title' => 'Posts',
		'description' => 'Post resource',
		'name' => 'Post',
		'type' => 'posts',
		'id' => [
			'type' => 'string:uuid'
		],
		'attributes' => [
			'title' => [
				'type' => 'string',
				'description' => 'Post title',
				'methods' => [
					'get', 
					'collection', 
					'post' => [
						'required' => true
					], 
					'patch', 
					'getRelationshipData'
				]
			],
			'description' => [
				'type' => 'string',
				'description' => 'Post description'
			],
			'content' => [
				'type' => 'string',
				'description' => 'Post content',
				'methods' => [
					'get', 
					'post', 
					'patch'
				]
			]
		],
		'relationships' => [
			'author' => [
				'type' => 'users',
				'relationship_type' => 'one',
				'methods' => [
					'getRelationships', 'getRelationshipData', 'patchRelationships'
				],
			]
		]
	]
];