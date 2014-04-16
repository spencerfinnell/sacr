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
        files: {
          'js/app.min.js': ['js/vendor/html5.js', 'js/vendor/jquery.fancybox.pack.js', 'js/vendor/jquery.ui.map.min.js', 'js/vendor/responsiveslides.min.js', 'js/sacr.js' ]
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('build', ['uglify', 'less']);
  grunt.registerTask('default', ['watch']);
};