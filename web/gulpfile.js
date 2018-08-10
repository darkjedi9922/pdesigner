var gulp = require('gulp');
var sass = require('gulp-sass');
//var concatCss = require('gulp-concat-css');
var minifyCss = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
//var run = require('gulp-run-command').default;
//var runSequence = require('run-sequence');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('styles', function() {
    gulp.src([
        'sources/styles/*.scss',
    ])
        .pipe(sass())
        //.pipe(concatCss('style.css'))
        .pipe(minifyCss())
        .pipe(autoprefixer())
        .pipe(gulp.dest('css'));
});

gulp.task('js', function () {
    gulp.src([
        'libs/jquery-3.3.1.min.js',
        'libs/src/semantic/build/semantic.min.js',
        'libs/vue.js',
        'libs/marked.min.js',
        'sources/scripts/components/*.js',
        'sources/scripts/*.js'
    ])
        //.pipe(uglify({ warnings: "verbose" }))
        .pipe(concat('asset.js'))
        .pipe(gulp.dest('js'));
});

/*gulp.task('semantic', run('gulp build --cwd libs/semantic'));
gulp.task('semantic-all', function() {
    runSequence('semantic', 'styles');
});*/

gulp.task('build', function() {
    gulp.start('styles');
    gulp.start('js');
});
gulp.task('watch', function() {
    gulp.watch(['sources/styles/*', 'sources/styles/*/*', 'sources/styles/*/*/*'], ['styles']);
    gulp.watch(['sources/scripts/*', 'sources/scripts/*/*', 'sources/scripts/*/*/*'], ['js']);
});

gulp.task('default', ['build', 'watch']);