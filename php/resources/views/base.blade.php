<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title', 'Default title') | 大寫鎖定工作室訂票系統</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link media="all" type="text/css" rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <script src="https://unpkg.com/holderjs@2.9.4/holder.min.js" charset="utf-8"></script>
    <style>
       ::-webkit-input-placeholder { /* WebKit browsers */
         color:    #ccc !important;
       }

       :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
         color:    #ccc !important;
         opacity:  1;
       }

       ::-moz-placeholder { /* Mozilla Firefox 19+ */
         color:    #ccc !important;
         opacity:  1;
       }

       :-ms-input-placeholder { /* Internet Explorer 10+ */
         color:    #ccc !important;
       }

       input, select {
         color: #999 !important;
       }

       .btn {
         color: #fff !important;
       }

       .margin-bottom25 {
         margin-bottom: 25px;
       }
    </style>
  </head>
  <body>
    <div id="event_page_wrap" vocab="http://schema.org/" style="background: rgba(0, 0, 0, 0.1)">
      <div class="content" style="min-height: calc(100vh - 85px);">
        @yield('content')
      </div>
      <footer id="footer" class="container-fluid">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              Powered By CapsLock, Studio
            </div>
          </div>
        </div>
      </footer>
    </div>
    <script src="/js/app.js"></script>
    @isset($error)
      <script type="text/javascript">
        humane.log('{{ $error }}')
      </script>
    @endisset
  </body>
</html>
