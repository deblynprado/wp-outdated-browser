module.exports = function(grunt) {
	'use strict';
	var gruntConfig = {
		pkg: grunt.file.readJSON('package.json'),      
    compress: {
      main: {
        options: {
          archive: '<%= pkg.name %>-<%= pkg.version %>.zip'
        },
        files: [
        {src:['**', '!*.zip', '!*.git', '!*.gitignore', '!*.DS_Store', '!*.md', '!*.json', '!Gruntfile.js', '!node_modules/**', '!original/**', '!PSDs/**']}
      ]
    }
  }

};

grunt.initConfig(gruntConfig);

var keys = Object.keys(gruntConfig);
var tasks = [];

for(var i = 1, l = keys.length; i < l; i++) {
  tasks.push(keys[i]);
}
grunt.loadNpmTasks('grunt-contrib-compress');
grunt.registerTask('default', tasks);

};
