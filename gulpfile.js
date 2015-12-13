'use strict';
// plugins
var gulp = require('gulp'),
    ngAnnotate = require('gulp-ng-annotate'),
    rigger = require('gulp-rigger'),
    watch = require('gulp-watch'),
    prefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    compass = require("gulp-compass"),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    gutil = require('gulp-util'),
    sourcemaps = require('gulp-sourcemaps'),
    rimraf = require('rimraf'),
    plumber = require('gulp-plumber');

var path = {
    build: {
        font:    'web/assets/build/fonts/',
        js:      'web/assets/build/js/',
        html:    'web/assets/build/',
        style:   'web/assets/build/style/',
        img:     'web/assets/build/img/'
    },
    src: {
        font:    'web/assets/src/font/**/*.*',
        js:      'web/assets/src/js/main.js',
        html:    'web/assets/src/*.html',
        style:   'web/assets/src/style/main.scss',
        img:     'web/assets/src/img/**/*.*'
    },
    watch: {
        font:    'web/assets/src/font/**/*.*',
        js:      'web/assets/src/js/**/*.js',
        html:    'web/assets/src/**/*.html',
        style:   'web/assets/src/style/**/*.scss',
        img:     'web/assets/src/img/**/*.*'
    },
    clean: 'web/assets/build'
};

gulp.task('font:build', function () {
    gulp.src(path.src.font)
        .pipe(gulp.dest(path.build.font));
});

gulp.task('js:build', function () {
    gulp.src(path.src.js)
        .pipe(plumber())
        .pipe(rigger())
        .pipe(sourcemaps.init())
        .pipe(ngAnnotate())
        .pipe(uglify())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.build.js));
});

gulp.task('html:build', function () {
    gulp.src(path.src.html)
        .pipe(rigger())
        .pipe(gulp.dest(path.build.html));
});

gulp.task('style:build', function() {
  gulp.src(path.src.style)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(prefixer())
    .pipe(compass({
      config_file: 'web/assets/config.rb',
      css: path.build.style,
      sass: 'web/assets/src/style',
      image: path.build.img
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(path.build.style));
});

gulp.task('image:build', function () {
    gulp.src(path.src.img)
        .pipe(plumber())
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest(path.build.img));
});

gulp.task('build', [
    'font:build',
    'js:build',
    'html:build',
    'style:build',
    'image:build'
]);

gulp.task('clean', function (cb) {
    rimraf(path.clean, cb);
});

gulp.task('watch', function(){
    watch([path.watch.font], function(event, cb) {
        gulp.start('font:build');
    });
    watch([path.watch.style], function(event, cb) {
        gulp.start('style:build');
    });
    watch([path.watch.html], function(event, cb) {
        gulp.start('html:build');
    });
    watch([path.watch.js], function(event, cb) {
        gulp.start('js:build');
    });
    watch([path.watch.img], function(event, cb) {
        gulp.start('image:build');
    });
});

gulp.task('default', ['build', 'watch']);
