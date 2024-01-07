<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="description" content="اسئلة و ردود - اسال وجاوب طلاب جامعة النجاح">
    <meta name="keywords" content="اسئلة,ردود,طلاب جامعة النجاح,مساقات,كليات,طلاب,أسئلة,questions,ask and answer,najah students" >
    <meta name="author" content="Yazan Diab" >

    <meta id="meta-application-name" name="application-name" content="اسأل وجاوب طلاب جامعة النجاح" />
    <meta id="meta-description" name="description" content="اسئلة و ردود.اسال وجاوب طلاب جامعة النجاح.طلاب جامعة النجاح" />
    <meta id="meta-keywords" name="keywords" content="اسئلة,ردود,طلاب جامعة النجاح,مساقات,كليات,طلاب,أسئلة,questions,ask and answer,najah students" />

    <meta id="meta-item-name" itemprop="name" content="اسأل وجاوب طلاب جامعة النجاح" />
    <meta id="meta-item-description" itemprop="description" content="اسئلة و ردود.اسال وجاوب طلاب جامعة النجاح.طلاب جامعة النجاح" />
    <meta id="meta-item-image" itemprop="image" content="{{ asset('images/question.png') }}" />

    <meta id="twt-card" name="twitter:card" content="summary" />
    <meta id="twt-site" name="twitter:site" content="@ask_and_answer" />
    <meta id="twt-title" name="twitter:title" content="اسأل وجاوب طلاب جامعة النجاح" />
    <meta id="twt-description" name="twitter:description" content="اسئلة و ردود.اسال وجاوب طلاب جامعة النجاح.طلاب جامعة النجاح" />
    <meta id="twt-creator" name="twitter:creator" content="@ask_and_answer" />
    <meta id="twt-image" name="twitter:image" content="{{ asset('images/question.png') }}" />

    <meta id="og-title" property="og:title" content="اسأل وجاوب طلاب جامعة النجاح" />
    <meta id="og-type" property="og:type" content="website" />
    <meta id="og-url" property="og:url" content="https://askandanswer.site/" />
    <meta id="og-image" property="og:image" content="{{ asset('images/question.png') }}" />
    <meta id="og-description" property="og:description" content="اسئلة و ردود.اسال وجاوب طلاب جامعة النجاح.طلاب جامعة النجاح" />
    <meta property="og:site_name" content="اسأل وجاوب طلاب جامعة النجاح" />
    <meta property="og:image" content="{{ asset('images/question.png') }}" />


    <link rel="shortcut icon" href="{{ asset('images/question.png') }}">
    <link rel="icon" href="{{ asset('images/question.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/question.png') }}">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"rel="stylesheet"/> --}}
    <!-- MDB -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet"/> --}}
    @yield('style')
</head>
<body>    
    <div id="app"></div>
    @yield('content')

    @yield('modal')
    
    <script src="{{ asset('js/app.js') }}" ></script>

    {{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}
    <script src="{{ asset('js/all.min.js') }}"></script>
    {{-- <script src="{{ asset('js/popper.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        var host = "http://192.168.1.18/";
    </script>
    <!-- MDB -->
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script> --}}

    @yield('script')
    
</body>
</html>
