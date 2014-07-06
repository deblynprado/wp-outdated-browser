module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    zip: {
    	'<%= pkg.name %>.zip': ['**', '!*.zip', '!*.git', '!*.gitignore', '!*.DS_Store', '!*.md', '!*.json', '!Gruntfile.js', '!node_modules/**', '!assets/demo/**', '!assets/LICENSE', '!assets/README.md', '!assets/outdatedbrowser/outdatedBrowser.css', '!assets/outdatedbrowser/outdatedBrowser.js'],
    }    
  });

  grunt.loadNpmTasks('grunt-zip');

  grunt.registerTask('default', ['zip']);

};