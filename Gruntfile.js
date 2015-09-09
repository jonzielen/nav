module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        compass: {
          dist: {
            options: {
              raw: 'require "compass/import-once/activate"\n',
              sassDir:'sass',
              cssDir:'css',
              cacheDir:'.sass-cache',
              httpPath:'/',
              imagesDir:'img',
              javascriptsDir:'js',
              outputStyle:'compressed', //dev only - should be: 'compact'
              noLineComments:true, //dev only - should be: false
              force:true
            }
          }
        },
        uglify: {
          options: {
            mangle:true,
            compress:true
          },
          all: {
            files: [{
              expand: true,
              cwd: 'js/src',
              src:'*.src.js',
              dest: 'js/min',
              ext: '.min.js'
            }],
          },
        },
        watch: {
          scripts: {
            files:[
              'js/src/*.src.js'
            ],
            tasks:['uglify'],
            options: {
              spawn:false,
              livereload:true
            },
          },
          css: {
            files:[
              'sass/*.scss'
            ],
            tasks:['compass'],
            options: {
              spawn:false,
              livereload:true
            }
          }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['compass', 'uglify']);
}
