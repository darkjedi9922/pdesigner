var gulp = require('gulp');
var sass = require('gulp-sass');
//var concatCss = require('gulp-concat-css');
var minifyCss = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var glob = require('glob');

var vuetask = require('./browserify');

gulp.task('styles', function () {
    return gulp.src([
        'sources/styles/*.scss',
    ])
        .pipe(sass())
        //.pipe(concatCss('style.css'))
        .pipe(minifyCss())
        .pipe(autoprefixer())
        .pipe(gulp.dest('css'));
});

gulp.task('js', function () {
    return gulp.src([
        'libs/jquery-3.3.1.min.js',
        'libs/src/semantic/build/semantic.min.js',
        'libs/vue.js',
        'libs/marked.min.js',
        'sources/scripts/stores/*.js',
        'sources/scripts/mixins/*.js',
        'sources/scripts/components/*.js',
        'sources/scripts/*.js'
    ])
        //.pipe(uglify({ warnings: "verbose" }))
        .pipe(concat('asset.js'))
        .pipe(gulp.dest('js'));
});

gulp.task('vue', vuetask({
    entries: glob.sync('sources/vue/*.js'),
    output: 'asset.js',
    dest: 'build'
}));

/*gulp.task('semantic', run('gulp build --cwd libs/semantic'));
gulp.task('semantic-all', function() {
    runSequence('semantic', 'styles');
});*/

gulp.task('build', gulp.parallel('styles', 'js', 'vue'));

gulp.task('watch-styles', () => {
    return gulp.watch(['sources/styles/*', 'sources/styles/*/*', 'sources/styles/*/*/*'], gulp.series('styles'));
});

gulp.task('watch-js', () => {
    return gulp.watch(['sources/scripts/*', 'sources/scripts/*/*', 'sources/scripts/*/*/*'], gulp.series('js'));
});

gulp.task('watch', gulp.parallel('watch-styles', 'watch-js'));
gulp.task('default', gulp.parallel('build', 'watch'));