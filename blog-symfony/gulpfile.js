const gulp = require('gulp');
const merge = require('merge-stream');
const sass = require('gulp-sass');
const gulpminify = require('gulp-minify');

gulp.task('default', function() {

    const bootstrap = gulp.src('node_modules/bootstrap/dist/css/*.css')
        .pipe( gulp.dest('public/assets/css/') );

    const bootstrapjs = gulp.src('node_modules/bootstrap/dist/js/*.js')
        .pipe( gulp.dest('public/assets/js/') );

    const jquery = gulp.src('node_modules/jquery/dist/*.js')
        .pipe( gulp.dest('public/assets/js/') );

    return merge( bootstrap,bootstrapjs,jquery );

});


gulp.task('sass', function() {

    const sasstranspilation = gulp.src('./assets/scss/general.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/assets/css/'));

    const minify = gulp.src('public/assets/css/general.css')
          .pipe( gulpminify() )
          .pipe( gulp.dest('public/assets/css/'));

    return merge( sasstranspilation,minify );

});

gulp.task('sass:watch', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
});