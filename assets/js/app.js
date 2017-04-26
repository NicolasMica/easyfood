import jQuery from 'jquery'
window.$ = window.jQuery = jQuery

require('materialize-css')

window.Materialize = Materialize

$(document).ready(function() {
    $(".button-collapse").sideNav()
})
