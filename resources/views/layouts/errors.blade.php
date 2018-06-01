@if ($errors->any())
    <div class="errors">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="is-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif