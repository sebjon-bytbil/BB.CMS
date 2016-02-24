module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: {
            fonts: ['assets/fonts/fonts.con.css'],
            vendorcss: ['assets/css/vendor/vendor.con.css'],
            themecss: ['assets/css/theme/theme.con.css'],
            vendorjs: ['assets/js/vendor/vendor.con.js'],
            themejs: ['assets/js/theme/theme.con.js']
        },
        concat: {
            fonts: {
                src: ['assets/fonts/**/*.css', '!assets/fonts/**/*.con.css'],
                dest: 'assets/fonts/fonts.con.css'
            },
            devcss: {
                src: ['assets/css/**/*.css', '!assets/css/**/*.con.css'],
                dest: 'assets/css/style.con.css'
            },
            vendorcss: {
                src: ['assets/css/vendor/**/*.css', '!assets/css/vendor/**/*.con.css'],
                dest: 'assets/css/vendor/vendor.con.css'
            },
            themecss: {
                src: ['assets/css/theme/**/*.css', '!assets/css/theme/**/*.con.css'],
                dest: 'assets/css/theme/theme.con.css'
            },
            vendorjs: {
                src: [
                    'assets/js/vendor/jquery-1.11.1.min.js',
                    'assets/js/vendor/bootstrap.min.js',
                    'assets/js/vendor/jquery.flexslider-min.js',
                    'assets/js/vendor/jquery-ui.min.js',
                    'assets/js/vendor/extra/bootstrap-select.min.js',
                    'assets/js/vendor/extra/jquery.cookiebar.js'
                ],
                dest: 'assets/js/vendor/vendor.con.js'
            },
            themejs: {
                src: ['assets/js/theme/**/*.js'],
                dest: 'assets/js/theme/theme.con.js'
            }
        },
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundPrecision: -1
            },
            css: {
                files: {
                    'assets/css/style.min.css': ['assets/fonts/fonts.con.css', 'assets/css/vendor/vendor.con.css', 'assets/css/theme/theme.con.css']
                }
            },
            customcss: {
                files: [{
                    expand: true,
                    src: ['plugins/bytbilcms-sitesettings/assets/**/*.css', '!plugins/bytbilcms-sitesettings/assets/**/*.min.css'],
                    ext: '.min.css'
                }]
            }
        },
        uglify: {
            options: {
                mangle: false,
                compress: true,
                unused: true,
                warnings: true
            },
            controller: {
                files: {
                    'assets/js/script.min.js': ['assets/js/theme/theme.con.js', 'assets/js/vendor/vendor.con.js']
                }
            }
        },
        cachebreaker: {
            devcss: {
                options: {
                    match: ['style.min.css']
                },
                files: {
                    src: ['header.php']
                }
            },
            devjs: {
                options: {
                    match: ['script.min.js']
                },
                files: {
                    src: ['footer.php']
                }
            }
        },
        replace: {
            devcss: {
                src: ['header.php'],
                overwrite: true,
                replacements: [{
                    from: /style\.min\.css(.*)?\'/,
                    to: 'style.con.css\''
                }]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-cache-breaker');
    grunt.loadNpmTasks('grunt-text-replace');

    grunt.registerTask('dev', ['clean:vendorcss', 'clean:themecss', 'concat:devcss', 'replace:devcss']);

    grunt.registerTask('concatcss', ['clean:fonts', 'clean:vendorcss', 'clean:themecss', 'concat:fonts', 'concat:vendorcss', 'concat:themecss']);
    grunt.registerTask('minifycss', ['clean:fonts', 'clean:vendorcss', 'clean:themecss', 'concat:fonts', 'concat:vendorcss', 'concat:themecss', 'cssmin:css', 'cachebreaker:devcss']);
    grunt.registerTask('concatjs', ['clean:vendorjs', 'clean:themejs', 'concat:vendorjs', 'concat:themejs']);
    grunt.registerTask('minifyjs', ['clean:vendorjs', 'clean:themejs', 'concat:vendorjs', 'concat:themejs', 'uglify', 'cachebreaker:devjs']);
    grunt.registerTask('customcss', ['cssmin:customcss']);
};
