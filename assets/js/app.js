window.$ = window.jQuery = require('materialize-css/node_modules/jquery/dist/jquery')

require('materialize-css')

$(document).ready(function() {
    $(".button-collapse").sideNav()
    $("select").material_select()
})
