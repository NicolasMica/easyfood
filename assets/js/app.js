window.$ = window.jQuery = require('jquery')

require('materialize-css')

$(document).ready(function() {
    $(".button-collapse").sideNav()
    $("select").material_select()
})
