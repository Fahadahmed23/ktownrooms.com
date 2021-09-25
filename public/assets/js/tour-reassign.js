/* ------------------------------------------------------------------------------
 *
 *  # Dragula - drag and drop library
 *
 *  Demo JS code for extension_dnd.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DragAndDrop = function() {


    //
    // Setup module components
    //

    // Dragula examples
    var _componentDragula = function(scope) {
        if (typeof dragula == 'undefined') {
            console.warn('Warning - dragula.min.js is not loaded.');
            return;
        }

        //
        // Dropdown menu items
        //

        // Define containers
        var containers = $('.dropdown-menu-sortable').toArray();

        // Init dragula
        dragula(containers, {
                mirrorContainer: document.querySelector('.dropdown-menu-sortable')
        }).on('drop', function(el, target, source, sibling) {
          scope.reassingnGroup(el.id, target.id);
        });


    };

    // Select2
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-control-select2').select2();
    };

    // Uniform
    var _comopnentUniform = function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        // Initializw
        $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-warning-400'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function(scope) {
            _componentDragula(scope);
            //_componentSelect2();
            _comopnentUniform();
        }
    }
}();


// Initialize module
// ------------------------------

// document.addEventListener('DOMContentLoaded', function() {
//     DragAndDrop.init();
// });
