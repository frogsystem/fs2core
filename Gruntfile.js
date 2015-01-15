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
      dist: {
        src: ['lib/<%= pkg.name %>.js'],
        dest: 'dist/<%= pkg.name %>.js'
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= concat.dist.dest %>',
        dest: 'dist/<%= pkg.name %>.min.js'
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
      }
      //~ , No tests at the moment
      //~ lib_test: {
        //~ src: ['lib/**/*.js', 'test/**/*.js']
      //~ }
    },
    //~ No tests at the moment
    //~ nodeunit: {
      //~ files: ['test/**/*_test.js']
    //~ },
    
    watch: {
      sass: {
        files: ['assets/sass/**/*.scss'],
        tasks: ['sass:dev']
      },
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      }
      //~ , No tests at the moment
      //~ lib_test: {
        //~ files: '<%= jshint.lib_test.src %>',
        //~ tasks: ['jshint:lib_test', 'nodeunit']
      //~ }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-nodeunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task.
  grunt.registerTask('default', ['sass:dev', 'jshint', 'concat', 'uglify']);

};
