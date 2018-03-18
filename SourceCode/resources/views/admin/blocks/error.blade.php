{{-- Hiển thị thông báo lỗi: đếm số lỗi, nếu > 0  thì lặp và hiển thị tất cả các lỗi ra --}}
@if (count($errors) > 0)
    <div class="error alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
