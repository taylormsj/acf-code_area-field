'use strict';

var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    csso = require('gulp-csso'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat');

gulp.task('css', function () {
    return gulp.src('css/codemirror.css')
        .pipe(csso())
        .pipe(rename(function (path) {
            path.basename += '.min';
        }))
        .pipe(gulp.dest('css'));
});

gulp.task('js', function () {
    return gulp.src([
        'js/codemirror.js',
        'js/mode/javascript.js',
        'js/mode/css.js',
        'js/mode/htmlmixed.js',
        'js/mode/xml.js',
        'js/mode/php.js',
        'js/mode/clike.js',
        'js/addon/xml-fold.js',
        'js/addon/matchtags.js',
        'js/acf-code_area.js'
    ])
        .pipe(uglify())
        .pipe(concat('acf-code_area.min.js'))
        .pipe(gulp.dest('js'));
});

gulp.task('default', ['css', 'js']);