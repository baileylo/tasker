var gulp = require('gulp');
var gutil = require('gulp-util');
var notify = require('gulp-notify');
var sass = require('gulp-ruby-sass');
var autoprefix = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var sassDir = 'app/assets/sass';
var targetCSSDir = 'public/css';
var jsDir = ['app/assets/js/jScript.js', 'app/assets/js/modules/*'];
var targetJsDir = 'public/js';


gulp.task('css', function() {
    return gulp.src(sassDir + '/main.sass')
        .pipe(sass({ style: 'compressed' })).on('error', gutil.log)
        .pipe(autoprefix('last 10 versions'))
        .pipe(gulp.dest(targetCSSDir));
});

gulp.task('js', function() {
    return gulp.src(jsDir)
        .pipe(concat('master.js'))
        .pipe(uglify())
        .pipe(gulp.dest(targetJsDir))
});

gulp.task('watch', function() {
    gulp.watch(jsDir, ['js']);
    gulp.watch(sassDir, ['css']);
});

gulp.task('default', ['css', 'js', 'watch']);
