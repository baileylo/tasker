var gulp = require('gulp');
var gutil = require('gulp-util');
var notify = require('gulp-notify');
var sass = require('gulp-ruby-sass');
var autoprefix = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var sassConfig = {
    targetDirectory : 'public/css',
    watchFiles: [
        'app/assets/sass/main.scss',
        'app/assets/sass/modules/*',
    ]
};

var jsDir = ['app/assets/js/jScript.js', 'app/assets/js/modules/*', 'app/assets/js/pages/*'];
var targetJsDir = 'public/js';

var bootstrap = 'app/assets/sass/bootstrap';


gulp.task('css', function() {
    return gulp.src(sassConfig.watchFiles)
        .pipe(sass({ style: 'compressed' })) //.on('error', gutil.log)
        .pipe(autoprefix('last 10 versions'))
        .pipe(gulp.dest(sassConfig.targetDirectory));
});

gulp.task('bootstrap', function() {
    return gulp.src(bootstrap)
        .pipe(sass({ style: 'compressed' })) //.on('error', gutil.log)
        .pipe(autoprefix('last 10 versions'))
        .pipe(gulp.dest(sassConfig.targetDirectory));
});

gulp.task('js', function() {
    return gulp.src(jsDir)
        .pipe(concat('master.js'))
//        .pipe(uglify())
        .pipe(gulp.dest(targetJsDir))
});

gulp.task('watch', function() {
    gulp.watch(jsDir, ['js']);
    gulp.watch(sassConfig.watchFiles, ['css']);
});

gulp.task('default', ['css', 'js', 'bootstrap', 'watch']);
