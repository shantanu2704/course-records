'use strict';

module.exports = function( grunt ) {

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		watch: {
			files: [ 'sass/*.scss' ],
			tasks: 'sass:dev',
			options: {
				livereload: true,
			}
		},
		sass: {
			dev: {
				options: {
					style: 'expanded'
				},
				files: {
					'style.css': 'sass/style.scss',
				}
			},
			release: {
				options: {
					style: 'expanded'
				},
				files: {
					'style.css': 'sass/style.scss',
				}
			}
		},
		autoprefixer: {
			options: {
				browsers: [ '> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'ie 9' ]
			},
			single_file: {
				src: 'style.css',
				dest: 'style.css'
			}
		},
		csscomb: {
			options: {
				config: '.csscomb.json'
			},
			files: {
				'style.css': [ 'style.css' ],
			}
		},
		concat: {
			release: {
				src: [
					'js/skip-link-focus-fix.js',
					'js/navigation.js',
				],
				dest: 'js/<%= pkg.name %>-combined.min.js',
			}
		},
		uglify: {
			release: {
				src: 'js/<%= pkg.name %>-combined.min.js',
				dest: 'js/<%= pkg.name %>-combined.min.js'
			}
		},
		// https://www.npmjs.org/package/grunt-wp-i18n
		makepot: {
			target: {
				options: {
					domainPath: '/languages/', // Where to save the POT file.
					potFilename: '<%= pkg.name %>.pot', // Name of the POT file.
					type: 'wp-theme'  // Type of project (wp-plugin or wp-theme).
				}
			}
		}

	} );

	grunt.loadNpmTasks( 'grunt-contrib-watch' );        
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-autoprefixer' );
	grunt.loadNpmTasks( 'grunt-csscomb' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
        
	grunt.registerTask( 'default', [ 'sass:dev' ] );
	grunt.registerTask( 'release', [
		'sass:release',
		'autoprefixer',
		'csscomb',
		'concat:release',
		'uglify:release',
		'makepot'
	] );
};


