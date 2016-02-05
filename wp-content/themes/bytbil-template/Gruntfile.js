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
                src: ['assets/fonts/**/*.css'],
                dest: 'assets/fonts/fonts.con.css'
            },
            vendorcss: {
                src: ['assets/css/vendor/**/*.css'],
                dest: 'assets/css/vendor/vendor.con.css'
            },
            themecss: {
                src: ['assets/css/theme/**/*.css'],
                dest: 'assets/css/theme/theme.con.css'
            },
            vendorjs: {
                src: ['assets/js/vendor/**/*.js'],
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
            target: {
                files: {
                    'assets/css/style.min.css': ['assets/fonts/fonts.con.css', 'assets/css/vendor/vendor.con.css', 'assets/css/theme/theme.con.css']
                }
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
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-cache-breaker');

    grunt.registerTask('concatcss', ['clean:fonts', 'clean:vendorcss', 'clean:themecss', 'concat:fonts', 'concat:vendorcss', 'concat:themecss']);
    grunt.registerTask('minifycss', ['clean:fonts', 'clean:vendorcss', 'clean:themecss', 'concat:fonts', 'concat:vendorcss', 'concat:themecss', 'cssmin', 'cachebreaker:devcss']);
    grunt.registerTask('concatjs', ['clean:vendorjs', 'clean:themejs', 'concat:vendorjs', 'concat:themejs']);
    grunt.registerTask('minifyjs', ['clean:vendorjs', 'clean:themejs', 'concat:vendorjs', 'concat:themejs', 'uglify', 'cachebreaker:devjs']);

};
