<!DOCTYPE html>
<html lang="en">
    @include('partials.user.head')
    <body>
        <main>
            @include('partials.user.header')
            
             @yield('content')
			
            @include('partials.user.footer')
        </main><!-- Main Wrapper -->

    @include('partials.admin.loading')
    @include('partials.user.tail')
        
    </body> 
</html>