'use strict';

var gulp = require('gulp'),
	argv = require('yargs').argv,
	gulpif = require('gulp-if'),
	browsersync = require('browser-sync'),
	sass = require('gulp-sass'),
	postcss = require('gulp-postcss'),
	cssnano = require('gulp-cssnano'),
	autoprefixer = require('autoprefixer'),
	sourcemaps = require('gulp-sourcemaps'),
	sassLint = require('gulp-sass-lint');

gulp.task('sass-lint'), function() {
	return gulp.src('./assets/scss/**/*.scss')
		.pipe(sassLint())
		.pipe(sassLint.format())
		.pipe(sassLint.failOnError())
}

gulp.task('sass', function () {
	var processors = [
		autoprefixer({browsers: ['>2%']})
	]
	return gulp.src('./assets/css/scss/**/*.scss')
		.pipe(gulpif(!argv.production, sourcemaps.init() ) )
		.pipe(sass({}).on('error', sass.logError))
		.pipe(postcss(processors))
		.pipe(gulpif(argv.production, cssnano() ) )
		.pipe(gulpif(!argv.production, sourcemaps.write('./maps') ) )
		.pipe(gulp.dest('./assets/css'))
});

// browser-sync task for starting the server.
gulp.task('browsersync', function() {
	//watch files
	var files = [
	'./assets/css/style.css',
	'./*.php',
	'./gulpfile.js'
	];

	// initialize browsersync
	browsersync.init(files, {
	// browsersync with a php server
	proxy: "tenupclp.dev",
	notify: false
	});
});

gulp.task('watch', function () {
	gulp.watch(['./assets/css/scss/**/*.scss'], ['sass-lint', 'sass']);
});

gulp.task('default',['sass-lint', 'sass', 'browsersync', 'watch']);
