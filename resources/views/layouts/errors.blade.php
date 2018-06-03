@if ($errors->any())
    <div class="content">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:darkred;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif