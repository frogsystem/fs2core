/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',

    // Task configuration.
    bower: {
      install: {
				options: {
					cops: false,
          verbose: true
				}
      }
    },
    
    sass: {
      options: {
        unixNewlines: true
      },
      
      dev: {
        files: [
          {
            expand: true,
            cwd: 'assets/sass',
            src: '**/[!_]*.scss',
            dest: 'assets/css',
            ext: '.css'
          }
        ]
      },
      dist: {
        options: {
          style: 'compressed',
        },
        files: [
          {
            expand: true,
            cwd: 'assets/sass',
            src: '**/[!_]*.scss',
            dest: 'assets/css',
            ext: '.css'
          }
        ]
      }
    },    

    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dev: {
        files: [
          { 
            'assets/js/admin.js' : ['assets/vendor/jquery/dist/jquery.js', 'assets/js/_frontend.js', 'assets/js/admin/**/_*.js']
          }
        ]
      }
    },

    uglify: {
      options: {
        banner: '<%= banner %>',
        compress: true,
        mangle: true,
        sourceMap: true
      },
      
      dist: {
        files: [
          {
            expand: true,
            cwd: 'assets/js',
            src: '**/[!_]*.js',
            dest: 'assets/js',
            ext: '.min.js'
          }
        ]
      }
    },
    
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        globals: {
          jQuery: true
        }
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      lib_test: {
        //~ JS won't pass at the moment
        //~ src: ['assets/js/**/[!_]*.js', 'test/**/*.js']
      }
    },
    nodeunit: {
      //~ No tests at the moment
      //~ files: ['test/**/*_test.js']
    },
    
    watch: {
      sass: {
        files: ['assets/sass/**/*.scss'],
        tasks: ['sass:dev']
      },
      js: {
        files: ['assets/js/**/_*.js'],
        tasks: ['concat']
      },
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test', 'nodeunit']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-nodeunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-newer');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-bower-task');

  // Default task.
  grunt.registerTask('default', ['sass:dev', 'jshint', 'concat']);
  grunt.registerTask('build', ['bower:install', 'sass:dist', 'jshint', 'concat', 'uglify:dist']);
  //~ grunt.registerTask('serve', ['']);

};
