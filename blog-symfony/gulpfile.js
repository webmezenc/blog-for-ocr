var gulp = require('gulp');
var merge = require('merge-stream');


gulp.task('default', function() {

    var bootstrap = gulp.src('node_modules/bootstrap/dist/css/*.css')
        .pipe( gulp.dest('public/assets/css/') );

    var bootstrapjs = gulp.src('node_modules/bootstrap/dist/js/*.js')
        .pipe( gulp.dest('public/assets/js/') );

    var jquery = gulp.src('node_modules/jquery/dist/*.js')
        .pipe( gulp.dest('public/assets/js/') );

    return merge( bootstrap,bootstrapjs,jquery );

});