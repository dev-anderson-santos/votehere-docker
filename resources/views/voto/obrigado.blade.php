@if (session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    {{-- {{ session()->flush() }} --}}
@endif

@if (session()->get('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    {{-- {{ session()->flush() }} --}}
@endif