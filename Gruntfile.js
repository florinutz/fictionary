module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'font-awesome/fonts'
                }
            }
        },
        cssmin : {
            fictionary:{
                src: 'web/assets/css/fictionary.css',
                dest: 'web/assets/css/fictionary.min.css'
            },
            ascultaici:{
                src: 'web/assets/css/ascultaici.css',
                dest: 'web/assets/css/ascultaici.min.css'
            }
        },
        uglify : {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            js: {
                files: {
                    'web/assets/js/fictionary.min.js': ['web/assets/js/fictionary.js'],
                    'web/assets/js/ascultaici.min.js': ['web/assets/js/ascultaici.js']
                }
            }
        },
        concat: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            css_fictionary: {
                src: [
                    'web/assets/css/bootstrap.css',
                    'web/assets/css/font-awesome.css',
                    'src/Flo/Bundle/FictionaryBundle/Resources/public/css/*.css'
                ],
                dest: 'web/assets/css/fictionary.css'
            },
            js_fictionary: {
                src : [
                    'web/assets/js/jquery.js',
                    'web/assets/js/bootstrap.js',
                    'src/Flo/Bundle/FictionaryBundle/Resources/public/js/*.js'
                ],
                dest: 'web/assets/js/fictionary.js'
            },
            css_ascultaici: {
                src: [
                    'web/assets/css/bootstrap.css',
                    'web/assets/css/font-awesome.css',
                    'src/Flo/Bundle/AscultaiciBundle/Resources/public/css/*.css'
                ],
                dest: 'web/assets/css/ascultaici.css'
            },
            js_ascultaici: {
                src : [
                    'web/assets/js/jquery.js',
                    'web/assets/js/bootstrap.js',
                    'src/Flo/Bundle/AscultaiciBundle/Resources/public/js/*.js'
                ],
                dest: 'web/assets/js/ascultaici.js'
            }
        },
        copy: {
            images_fictionary: {
                expand: true,
                cwd: 'src/Flo/Bundle/FictionaryBundle/Resources/public/images',
                src: '*',
                dest: 'web/assets/images/fictionary/'
            },
            images_ascultaici: {
                expand: true,
                cwd: 'src/Flo/Bundle/AscultaiciBundle/Resources/public/images',
                src: '*',
                dest: 'web/assets/images/ascultaici/'
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['bowercopy','copy', 'concat', 'cssmin', 'uglify']);
};
