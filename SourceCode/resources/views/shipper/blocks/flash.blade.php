<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-xs-push-3 col-sm-push-4">
        @if (Session::has('flash_message'))
            <div class="message alert alert-{{ Session::get('flash_level') }}">
                <p class="text-center">{{ Session::get('flash_message') }}</p>
            </div>
        @endif
    </div>
</div>