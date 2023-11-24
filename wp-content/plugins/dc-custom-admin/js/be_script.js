jQuery(function($){
    $('iframe').load( function() {
        $('iframe').contents().find("head")
        .append($("<style type='text/css'>  iframe html {overflow-y: scroll !important;}  </style>"));
    });
});