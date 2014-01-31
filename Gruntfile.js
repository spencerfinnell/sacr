module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          // target.css file: source.less file
          "css/style.css": "css/style.less"
        }
      }
    },
    watch: {
      styles: {
        // Which files to watch (all .less files recursively in the less directory)
        files: ['css/*.less'],
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    },
    uglify: {
      my_target: {
        files: [{
            expand: true,
            cwd: 'js',
            src: '**/*.js',
            dest: 'js'
        }]
      }
    },
    concat: {
      js: {
        src: 'js/*.js',
        dest: 'js/app.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.registerTask('build', ['uglify', 'concat']);
  grunt.registerTask('default', ['uglify', 'concat', 'watch']);
};