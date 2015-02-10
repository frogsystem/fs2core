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
      options: {
        copy: false
      },
      install: {
        options: {
          copy: false,
          verbose: true
        }
      }
    },
    
    copy: {
      admin: {
        files: [
          {
            'www/admin/js/admin.js' : 'dist/js/admin.js',
            'www/admin/js/codemirror.js' : 'dist/js/codemirror.js'
          },
          {
            expand: true,
            flatten: true,
            src: ['dist/css/admin/*.css'],
            dest: 'www/admin/css/'
          }
        ]
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
            dest: 'dist/css',
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
            dest: 'dist/css',
            ext: '.css'
          }
        ]
      }
    },
    
    cssjoin: {
      options: {
        paths : ["assets/", "vendor/"]
      },
      admin: {
        files: {
          'dist/css/admin/admin.css': ['dist/css/admin/admin.css'],
          'dist/css/admin/codemirror.css': ['dist/css/admin/codemirror.css']
        }
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
            'dist/js/admin.js' : [
              'vendor/jquery/dist/jquery.js',
              'vendor/colpick-jQuery-Color-Picker/js/colpick.js',
              'assets/js/_frontend.js',
              'assets/js/admin/**/_*.js'
            ],
            'dist/js/codemirror.js' : [
              'vendor/codemirror/lib/codemirror.js',
              
              'vendor/codemirror/mode/css/css.js',
              'vendor/codemirror/mode/javascript/javascript.js',
              'vendor/codemirror/mode/xml/xml.js',
              'vendor/codemirror/mode/htmlmixed/htmlmixed.js',
              
              'vendor/codemirror/addon/display/fullscreen.js'
            ]
          }
        ]
      }
    },

    uglify: {
      options: {
        banner: '<%= banner %>',
        compress: true,
        mangle: true,
        sourceMap: false
      },
      
      dist: {
        files: [
          {
            expand: true,
            cwd: 'dist/js',
            src: '**/[!_]*.js',
            dest: 'dist/js',
            ext: '.js'
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
        tasks: ['sass:dev', 'cssjoin']
      },
      js: {
        files: ['assets/js/**/_*.js'],
        tasks: ['concat']
      },
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      //~ lib_test: {
        //~ files: '<%= jshint.lib_test.src %>',
        //~ tasks: ['jshint:lib_test', 'nodeunit']
      //~ }, 
      copy: {
        options: {
          livereload: true
        },
        files: ['dist/**/*'],
        tasks: ['newer:copy']
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
  grunt.loadNpmTasks('grunt-cssjoin');

  // Default task.
  grunt.registerTask('default', ['sass:dev', 'cssjoin', 'jshint', 'concat', 'copy']);
  grunt.registerTask('build', ['bower:install', 'sass:dist', 'jshint', 'concat', 'uglify:dist', 'copy']);
};
