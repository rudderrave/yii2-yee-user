$(document).ready(function () {
    var routeCheckboxes = $('.route-checkbox');
    var routeText = $('.route-text');

// For checked routes
    var backgroundColor = '#D6FFDE';

    function showAllRoutesBack() {
        $('#routes-list').find('.hide').each(function () {
            $(this).removeClass('hide');
        });
    }

//Make tree-like structure by padding controllers and actions
    routeText.each(function () {
        var _t = $(this);

        var chunks = _t.html().split('/').reverse();
        var margin = chunks.length * 30 - 30;

        if (chunks[0] == '*')
        {
            margin -= 30;
        }

        _t.closest('label').closest('div.checkbox').attr('style', 'margin-left: ' + margin + 'px !important');

    });

// Highlight selected checkboxes
    routeCheckboxes.each(function () {
        var _t = $(this);

        if (_t.is(':checked'))
        {
            _t.closest('label').css('background', backgroundColor);
        }
    });

// Change background on check/uncheck
    routeCheckboxes.on('change', function () {
        var _t = $(this);

        if (_t.is(':checked'))
        {
            _t.closest('label').css('background', backgroundColor);
        } else
        {
            _t.closest('label').css('background', 'none');
        }
    });


// Hide on not selected routes
    $('#show-only-selected-routes').on('click', function () {
        $(this).addClass('hide');
        $('#show-all-routes').removeClass('hide');

        routeCheckboxes.each(function () {
            var _t = $(this);

            if (!_t.is(':checked'))
            {
                _t.closest('label').addClass('hide');
                _t.closest('div.separator').addClass('hide');
            }
        });
    });

// Show all routes back
    $('#show-all-routes').on('click', function () {
        $(this).addClass('hide');
        $('#show-only-selected-routes').removeClass('hide');

        showAllRoutesBack();
    });

// Search in routes and hide not matched
    $('#search-in-routes').on('change keyup', function () {
        var input = $(this);

        if (input.val() == '')
        {
            showAllRoutesBack();
            return;
        }

        routeText.each(function () {
            var _t = $(this);

            if (_t.html().indexOf(input.val()) > -1)
            {
                _t.closest('label').removeClass('hide');
                _t.closest('div.separator').removeClass('hide');
            } else
            {
                _t.closest('label').addClass('hide');
                _t.closest('div.separator').addClass('hide');
            }
        });
    });
});