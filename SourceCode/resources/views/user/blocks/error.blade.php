<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-md-push-4">
        @if (count($errors) > 0)
            <div class="error alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('flash_message'))
            <div class="message alert alert-{{ Session::get('flash_level') }}">
                <p class="text-center">{{ Session::get('flash_message') }}</p>
            </div>
        @endif
    </div>
</div>

