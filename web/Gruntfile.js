module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        jshint: {
            options: {
                node: true,
                browser: true,
                esnext: true,
                bitwise: true,
                camelcase: false,
                curly: false,
                eqeqeq: true,
                immed: true,
                indent: 4,
                latedef: true,
                newcap: true,
                noarg: true,
                quotmark: false, 
                regexp: true,
                undef: true,
                unused: false,
                strict: false,
                trailing: true,
                smarttabs: true,
                maxdepth: 5,
                freeze: true,
                evil: true,
                sub: true,
                white: true,
                globals: {
                    angular: false,
                    jQuery: false,
                    $: false,
                    _: false,
                    app: false,
                    YouTubeYTPlayer: false,
                    YT: false,
                    MerchandiseCtrl: true,
                    SearchFilterCtrl: true,
                    MyFavoriteCtrl: true,
                    LibCtrl: true,
                    AdCtrl: true,
                    MyUtil: true
                },
                force: false,
                ignores: []
            },
            files: {
                src: [
                ],
            }
        },
        uglify: {
            options: {
                compress: {
                    drop_console: true
                }, 
                mangle: true,
                beautify: false 
            },    
            build: {
                src: [
                ],
               dest: 'app/assets/js/app.js'
            }
        },
        compass: {
            options: {
                config: 'config/compass.rb'
            },
            dev: {
                options: {
                    environment: 'development',
                    outputStyle: 'expanded',
                    relativeAssets: true
                }
            }
        },
        cssmin: {
            dev: {
                expand: true,
                files: {
                }
            }
        },
        watch: {
            options: {
                livereload: true,
            },
            js: {
                files: ['app/assets/js/**/*.js', 'app/assets/js/main.js', '!app/assets/js/app.js'],
                tasks: ['uglify']
            },
            css: {
                files: ['app/assets/scss/*.scss', 'app/assets/scss/component/*.scss'],
                tasks: ['compass']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['jshint', 'compass', 'uglify', 'cssmin', 'watch']);
    grunt.registerTask('production', ['jslint', 'compass', 'uglify', 'cssmin', 'watch']);

    grunt.event.on('watch', function (action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });
};
