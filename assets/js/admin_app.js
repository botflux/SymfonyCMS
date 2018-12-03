/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css')
import 'bulma'

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js')

const ckeditor = document.querySelector('textarea.ckeditor')

if (ckeditor !== undefined) {
    import('@ckeditor/ckeditor5-build-classic').then(editor => {
        console.log(editor.default)
        editor.default
            .create(document.querySelector('textarea.ckeditor'))
            .then(e => {
                window.editor = e
            })
            .catch(error => {
                console.error(err.stack)
            })
    })
}