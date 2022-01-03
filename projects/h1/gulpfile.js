'use strict';

var gulp = require('gulp'),
    sourcemaps = require('gulp-sourcemaps'),
    less = require('gulp-less'),
    minifyCSS = require('gulp-minify-css');


gulp.task('copy:images', function() {
    return gulp.src('./src/images/**/*.*')
        .pipe(gulp.dest('./web/images'));
});

gulp.task('copy:fonts', function() {
    return gulp.src('./node_modules/bootstrap/fonts/**/*.*')
        .pipe(gulp.dest('./web/fonts'));
});
gulp.task('copy', ['copy:images', 'copy:fonts']);

gulp.task('less:dev', function () {
    return gulp.src('./src/less/style.less')
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./web/css'));
});

gulp.task('less:prod', function() {
    return gulp.src('./src/less/style.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('./web/css'));
});

gulp.task('watch', function() {
    gulp.watch('./src/**/*.less', ['less:dev']);
    gulp.watch('./src/images/**/*.*', ['copy:images']);
});

gulp.task('build', ['copy', 'less:prod']);
gulp.task('default', ['copy', 'less:dev', 'watch']);
