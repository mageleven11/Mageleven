// File: app/code/Backend/DemoExtension/view/frontend/web/js/backend-demo.js
require(['jquery'], function ($) {
    $(document).ready(function () {
        $('#backend-demo-button').click(function () {
            $.ajax({
                url: '/backenddemo/index/backenddemo',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data.backend_demo_url) {
                        window.open(data.backend_demo_url, '_blank');
                    }
                }
            });
        });
    });
});
s